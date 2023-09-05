<?php

namespace App\Http\Controllers\Sites;

use App\Models\Shop;
use App\Models\Uniques;
use App\Models\Campaign;
use App\Models\Privilege;
use App\Models\Warehouse;
use Illuminate\Http\Request;
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

    public function checkFormat(Request $request, Campaign $campaign)
    {
        $uuid = base64_encode(auth()->id());
        $type = $request->type_split_data;
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $temp_path = storage_path("temp_file/{$campaign->keyword}/");
            $temp_name = "file_{$uuid}.tmp";
            $temp_path_file = $temp_path . $temp_name;

            $file->move($temp_path, $temp_name);

            $temp_file_content = File::get($temp_path_file);
            $contents = explode("\n",  $temp_file_content);

            foreach ($contents as $key => $data) {
                $line = $key + 1;
                $split_data = explode($type, $data);

                if (count($split_data) < 5) {
                    $res['error'][$line] = 'Format ไฟล์ไม่ถูกต้อง';
                } else {
                    list($mobile, $code, $keyword, $value, $expire) = $split_data;
                    if (!preg_match('/^([0]{1}|[66]{2})(6|7|8|9){1}[0-9]{8}$/', $mobile)) {
                        $res['error'][$line] = 'เบอร์โทรศัพท์ไม่ถูกต้อง ' . $mobile;
                        continue;
                    }

                    $has_data = $campaign->privileges()->where('keyword', 'LIKE', $campaign->keyword . $keyword . '%')
                        ->where('value', $value)->whereDate('end_date', '=', $expire)->count();

                    if (!$has_data) {
                        $res['error'][$line] = "ไม่พบข้อมูล - {$keyword}{$type}{$value}{$type}{$expire}";
                        continue;
                    }
                }
            }
            if (!isset($res['error'])) {
                $encrypt_content = Crypt::encrypt($temp_file_content);
                File::put($temp_path_file, $encrypt_content);

                $res['msg'] = 'Format ถูกต้องสามารถอัพโหลดไฟล์ได้';
            }
        } else {
            $res['error'] = 'ไม่พบไฟล์';
        }

        $res['status'] = isset($res['error']) ? 'error' : 'ok';

        return response()->json($res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, Campaign $campaign)
    {
        // $uuid = base64_encode(auth()->id());
        // $temp_file = storage_path("temp_file/{$campaign->keyword}/file_{$uuid}.tmp");
        // $temp_file_content = File::get($temp_file);
        // $data_file = Crypt::decrypt($temp_file_content);
        // $contents = explode("\r\n",  $data_file);
        var_dump($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }
}
