<?php

namespace App\Http\Controllers;

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

    public function backupDatabase(Request $request)
    {
        

        $data = $request->data;

        if (in_array('semua', $data)) {
            
            $fileName = $this->generateSqlFile(null);

            DatabaseSetting::create([
                'nama_database' => implode(",", $data),
                'tanggal_simpan' => date('Y-m-d H:i:s'),
                'database_file' => $fileName,
            ]);
            
        }else{

            $fileName = $this->generateSqlFile($data);

            DatabaseSetting::create([
                'nama_database' => implode(",", $data),
                'tanggal_simpan' => date('Y-m-d H:i:s'),
                'database_file' => $fileName,
            ]);

        }

        return response()->json(['success' => 'Database backup success']);

    }

    public function generateSqlFile($dbname)
    {

        try {

            $dumpSetting = [];
            $dumpSetting['include-tables'] = $dbname;

            $fileName = "backup-". time().'_'. ".sql";
            $path = public_path("storage/db/");
            $dump = new IMysqldump\Mysqldump('mysql:host='.env('DB_HOST').';dbname='
                                        .env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'), $dbname ? $dumpSetting : []);

            $dump->start($path . $fileName);
            
            return $fileName;

        } catch (\Exception $e) {

            echo 'mysqldump-php error: ' . $e->getMessage();

        }

        // linux
        // shell_exec('mysqldump -h {IP} -u {user} -p {pass} --databases app_puem > cc.sql');


    }
}
