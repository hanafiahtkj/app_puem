<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('database-setting.index', compact('tablesFilter'));
    }

    public function backupDatabase(Request $request)
    {
        

        $data = $request->data;

        if (in_array('semua', $data)) {
            
           
            

        }else{

            $this->generateSqlFile($data);

        }

        return response()->json(['success' => 'Database backup success', 'data' => $data]);

    }

    public function generateSqlFile($dbname)
    {

        // $fileName = "backup-". time().'_'. ".sql";
        // $storageAt = storage_path() . "/app/backup/";
        // $command = "".env('dump', 'dump')." --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . $storageAt . $fileName;

        // $output = null;
        // $returnVar = null;
        // exec($command, $output, $returnVar);
        // $file->move(public_path('storage/databaseBackup'), $fileName);


        shell_exec('mysqldump -h 103.178.83.254 -u app_puem -p@puem_app --databases app_puem > cc.sql');

        // exec('C:\laragon\bin\mysqlmysql-5.7.33-winx64\bin\mysqldump -user=app_puem --password=@puem_app --host=103.178.83.254 app_puem > file.sql');

    }
}
