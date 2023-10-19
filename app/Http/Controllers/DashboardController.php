<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function main()
    {
        $total_campaign =  Campaign::count();

        $tables = DB::connection('db_storage_code')->select('SHOW TABLES');

        $total_code = 0;

        foreach ($tables as $table) {
            $tableName = reset($table); // Get the table name from the result object
            if ($tableName) {
                $total_code += DB::connection('db_storage_code')->table($tableName)->count();
            }
        }

        return view('dashboard', [
            'total_campaign' => $total_campaign ?? 0,
            'total_use' => $total_use ?? 0,
            'total_code' => $total_code ?? 0,
        ]);
    }
}
