<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Partner;
use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function main()
    {
        foreach (glob(storage_path("logs/redeem/*.*")) as $file) {
            foreach (file($file) as $line) {
                $line = explode('|', $line);
                $line_data = json_decode($line[4]);
                $date = date('Y-m-d', strtotime($line_data->data_access));
                $time = date('H:i:s', strtotime($line_data->data_access));
                $data_access[$date][] = $time;
            }
        }

        for ($d = 7; $d >= 1; $d--) {
            $date = date('Y-m-d', strtotime("-{$d}days"));

            $data_traffic_week[$date] = isset($data_access[$date]) ? count($data_access[$date]) : 0;
        }

        for ($t = 0; $t <= 23; $t++) {
            $hour = Str::padLeft($t, 2, '0');
            $data_traffic_today[$t] = 0;
        }

        if (isset($data_access[date('Y-m-d')])) {
            foreach ($data_access[date('Y-m-d')] as $times) {
                [$hour, $minute, $second] = Str::of($times)->explode(':');
                $data_traffic_today[$hour]++;
            }
        }

        $connection = 'db_storage_code';
        $total_campaign =  Campaign::count();
        $total_shop = Shop::count();
        $total_partner = Partner::count();
        $tables = DB::connection($connection)->select('SHOW TABLES');
        $total_code = 0;

        foreach ($tables as $table) {
            $tableName = reset($table);
            if ($tableName) {
                $total_code += DB::connection($connection)->table($tableName)->count();
            }
        }

        return view('dashboard', [
            'data_traffic_today' => implode(',', $data_traffic_today),
            'data_traffic_week' => implode(',', $data_traffic_week),
            'total_shop' => $total_shop ?? 0,
            'total_campaign' => $total_campaign ?? 0,
            'total_code' => $total_code ?? 0,
            'total_use' => $total_use ?? 0,
            'total_partner' => $total_partner ?? 0
        ]);
    }
}
