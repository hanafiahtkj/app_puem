<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ifsnop\Mysqldump as IMysqldump;
use App\Models\DatabaseSetting;

class DatabaseSettingController extends Controller
{
    public function index()
    {

        $tables = collect(DB::select('SHOW TABLES'));

        $except_table = ["migrations", "password_resets", "permissions", "personal_access_tokens",
                            "role_has_permissions", "model_has_roles", "model_has_permissions", "failed_jobs", "roles"];

        $tablesFilter = $tables->map(function ($item) use ($except_table) {
            $item = (array) $item;
            $item = array_values($item);
            $item = $item[0];
            return $item;
        })->filter(function ($item) use ($except_table) {
            return !in_array($item, $except_table);
        });

        $data = DatabaseSetting::all();

        return view('database-setting.index', compact('tablesFilter', 'data'));
    }

    public function data_json()
    {

        $data = DatabaseSetting::all()->map(function($val, $key){
            return [
                'no'                => $key + 1,
                'nama_database'     => $val->nama_database,
                'tanggal_simpan'    => $val->tanggal_simpan,
                'database_file'     => $val->database_file,
            ];
        });

        return Datatables::of($data)
                        ->addColumn('action', function ($row) {
                            return '<a href="'.route('database-download', $row['database_file']).'" class="btn btn-primary btn-sm"><i class="fa fa-download"></i></a>
                                    <a href="" class="btn btn-danger btn-sm" onclick="return confirm_click()"><i class="fa fa-trash"></i></a>';                
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    public function backupDatabase(Request $request)
    {
        

        $data = $request->data;

        if (in_array('semua', $data)) {
            
            $fileName = $this->_generateSqlFile([]);

            // linux test
            // $fileName = $this->_generateSqlFileLinux();

            DatabaseSetting::create([
                'nama_database' => implode(",", $data),
                'tanggal_simpan' => date('Y-m-d H:i:s'),
                'database_file' => $fileName,
            ]);
            
        }else{

            $fileName = $this->_generateSqlFile($data);

            DatabaseSetting::create([
                'nama_database' => implode(",", $data),
                'tanggal_simpan' => date('Y-m-d H:i:s'),
                'database_file' => $fileName,
            ]);

        }

        return response()->json(['success' => 'Database backup success']);

    }

    public function restoreDatabase(Request $request)
    {

        $file = $request->sqlFile;

        try {
            
            DB::unprepared(file_get_contents($file));

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Database restore failed']);
        }

        return response()->json(['success' => 'Database restore success']);
        
    }

    public function downloadSqlFile($sqlFile)
    {

        $headers = [
            'Content-Type' => 'application/octet-stream',
        ];

        $file = $this->_getSqlFile($sqlFile);

        return response()->download($file, $sqlFile, $headers);
    }

    private function _getSqlFile($file)
    {
        return public_path(). "/storage/db/$file";
    }

    private function _generateSqlFile($dbname)
    {

        try {

            $dumpSetting = [];
            $dumpSetting['include-tables'] = $dbname;
            $dumpSetting['databases']      = true;
            $dumpSetting['add-drop-table'] = true;

            $fileName = "backup-". time().'_'. ".sql";
            $path = public_path("storage/db/");
            $dump = new IMysqldump\Mysqldump("mysql:host=".env('DB_HOST').";dbname=".env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'), $dumpSetting);
            $dump->start($path . $fileName);
            
            return $fileName;

        } catch (\Exception $e) {

            echo 'mysqldump-php error: ' . $e->getMessage();

        }

    }

    private function _generateSqlFileLinux()
    {

        $path = public_path("storage/db/");

        try{

            exec('mysqldump -h '.env('DB_HOST').' -u '.env('DB_USERNAME').' -p'.env('DB_PASSWORD').' --databases app_puem > '.$path.'backup-'.time().'.sql');
            return 'ok';

        }catch(\Exception $e){

            echo 'mysqldump-php error: ' . $e->getMessage();

        }

    }
}
