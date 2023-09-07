<?php

namespace App\Http\Controllers\Sites;

use App\Models\Shop;
use App\Models\Uniques;
use App\Models\Campaign;
use App\Models\Privilege;
use App\Models\Warehouse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Campaign $campaign)
    {
        $uniques = $campaign->uniques ?? [];

        return view('site.warehouse.index', compact('campaign'))->with(compact('uniques'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Campaign $campaign)
    {
        $privileges = $campaign->privileges;
        $privilege_list = [];
        foreach ($privileges as $key => $privilege) {
            $end_date = date('Y-m-d', strtotime($privilege->end_date));
            $privilege_list[$privilege->shop->keyword]['title'] = $privilege->shop->name;
            $privilege_list[$privilege->shop->keyword]['list'][$end_date][] = $privilege->value;
        }

        return view('site.warehouse._form', compact('campaign'))->with('privileges', $privilege_list);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, Campaign $campaign)
    {
        $uuid = base64_encode(auth()->id());
        if ($request->hasFile('filepond')) {
            $file = $request->file('filepond');
            $temp_path = storage_path("temp_file/{$campaign->keyword}/");
            $temp_name = "file_{$uuid}.tmp";
            $temp_path_file = $temp_path . $temp_name;

            $file->move($temp_path, $temp_name);

            $temp_file_content = File::get($temp_path_file);
            $encrypt_content = Crypt::encrypt($temp_file_content);
            File::put($temp_path_file, $encrypt_content);

            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'error'], 400);
        }
    }

    public function checkFormat(Request $request, Campaign $campaign)
    {
        $uuid = base64_encode(auth()->id());
        $type = $request->type_split_data;
        $temp_path_file = storage_path("temp_file/{$campaign->keyword}/file_{$uuid}.tmp");
        $temp_file_encrypt = File::get($temp_path_file);
        $temp_file_content = Crypt::decrypt($temp_file_encrypt);

        $privilege_list = [];
        if ($campaign->privileges) {
            foreach ($campaign->privileges as $privilege) {
                $end_date = date('Y-m-d', strtotime($privilege->end_date));
                $privilege_list[$privilege->shop->keyword][$end_date][] = $privilege->value;
            }
        }

        $db_code = DB::connection('storage_code')->table($campaign->table_name)->where(['flag' => ['ok', 'deviate']])->pluck('code')->toArray();
        $already_code = [];
        if ($temp_file_content) {
            $contents = explode("\r\n",  $temp_file_content);
            foreach ($contents as $key => $data) {
                $line = $key + 1;
                $split_data = explode($type, $data);

                if (count($split_data) < 5) {
                    $res['error'][$line] = 'Format ไฟล์ไม่ถูกต้อง';
                } else {
                    list($mobile, $code, $keyword, $value, $expire) = $split_data;
                    $expire = date('Y-m-d', strtotime($expire));
                    if (!preg_match('/^([0]{1}|[66]{2})(6|7|8|9){1}[0-9]{8}$/', $mobile)) {
                        $res['error'][$line] = "เบอร์โทรศัพท์ไม่ถูกต้อง ~ {$mobile}";
                        continue;
                    }

                    if (in_array($code, $already_code)) {
                        $res['error'][$line] = "โค้ดซ้ำในไฟล์ที่นำเข้า ~ {$code}";
                        continue;
                    }

                    if (in_array($code, $db_code)) {
                        $res['error'][$line] = "โค้ดซ้ำในในระบบ ~ {$code}";
                        continue;
                    }

                    if (!isset($privilege_list[$keyword][$expire]) || !in_array($value, $privilege_list[$keyword][$expire])) {
                        $res['error'][$line] = "ไม่พบข้อมูล ~ {$keyword}{$type}{$value}{$type}{$expire}";
                        continue;
                    }
                }
                array_push($already_code, $code);
            }
            if (!isset($res['error'])) {
                $res['msg'] = 'Format ถูกต้องสามารถอัพโหลดไฟล์ได้';
            }
        } else {
            $res['error'] = 'ไม่พบไฟล์';
        }

        $res['status'] = isset($res['error']) ? 'error' : 'ok';

        return response()->json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request, Campaign $campaign)
    {
        $uuid = base64_encode(auth()->id());
        $type = $request->type_split_data;
        $temp_path_file = storage_path("temp_file/{$campaign->keyword}/file_{$uuid}.tmp");
        $temp_file_encrypt = File::get($temp_path_file);
        $temp_file_content = Crypt::decrypt($temp_file_encrypt);

        $result = [];
        if ($temp_file_content) {
            $contents = explode("\r\n",  $temp_file_content);
            foreach ($contents as $key => $content) {
                list($mobile, $code, $keyword, $value, $expire) = explode($type, $content);
                $mobile = Str::padLeft(Str::substr($mobile, -9), 11, '66');
                $expire = date('Y-m-d 23:59:59', strtotime($expire));

                $unique = $this->getUnique();
                $secret_code =  $this->getSecretCode();
                $result[$key]['mobile'] = $mobile;
                $result[$key]['code'] = $code;
                $result[$key]['unique'] = $unique;
                $result[$key]['secret_code'] = $secret_code;
            }
        }

        return response()->json($result);
    }

    public function getUnique()
    {
        
    }
}
