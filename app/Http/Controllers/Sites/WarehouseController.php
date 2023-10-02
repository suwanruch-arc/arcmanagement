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
use App\Models\File as FileModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;

class WarehouseController extends Controller
{
    public function index(Campaign $campaign)
    {
        $uniques = DB::connection('storage_code')->table($campaign->table_name)->get();

        return view('site.warehouse.index', compact('campaign'))->with(compact('uniques'));
    }

    public function import(Campaign $campaign)
    {
        $privilege_list = [];
        $templates = [];
        $privileges = $campaign->privileges;
        switch ($campaign->template_type) {
            case 'STD':
                foreach ($privileges as $key => $privilege) {
                    $end_date = date('Y-m-d', strtotime($privilege->end_date));
                    $privilege_list[$privilege->shop->keyword]['title'] = $privilege->shop->name;
                    $privilege_list[$privilege->shop->keyword]['list'][$end_date][] = $privilege->value;
                }
                break;

            case 'CTM':
                foreach ($privileges as $key => $privilege) {
                    $templates[$privilege->id]['expire'] = date('Y-m-d', strtotime($privilege->end_date));
                    $templates[$privilege->id]['value'] = $privilege->value;
                    $templates[$privilege->id]['template'] = FileModel::where('table_id', $privilege->id)->where('table_name', 'privileges')->value('origin_name');
                }
                break;
        }


        return view('site.warehouse._form', compact('campaign'))->with('privileges', $privilege_list)->with('templates', $templates);
    }

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
        $res['status'] = true;
        $type = $request->type_split_data;
        $temp_file_content = $this->getFileTemp($campaign->keyword);
        if ($temp_file_content) {
            $contents = explode("\r\n",  $temp_file_content);
            $db_code = DB::connection('storage_code')->table($campaign->table_name)->where(['flag' => ['ok', 'deviate']])->pluck('code')->toArray();
            list($total, $already_code) = [0, []];
            switch ($campaign->template_type) {
                case 'STD':
                    $privilege_list = $this->getPrivilegeList($campaign);
                    foreach ($contents as $key => $data) {
                        $line = $key + 1;
                        $split_data = explode($type, $data);

                        if (count($split_data) < 5 || count($split_data) > 5) {
                            $res['error'][$line] = 'Format ไฟล์ไม่ถูกต้อง';
                        } else {
                            $total++;
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

                            if (!isset($privilege_list[$keyword][$expire]) || !isset($privilege_list[$keyword][$expire][$value])) {
                                $res['error'][$line] = "ไม่พบข้อมูล ~ {$keyword}{$type}{$value}{$type}{$expire}";
                                continue;
                            }
                            array_push($already_code, $code);
                        }
                    }
                    break;
                case 'CTM':
                    $template_list = $this->getTemplateList($campaign);
                    foreach ($contents as $key => $data) {
                        $line = $key + 1;
                        $split_data = explode($type, $data);

                        if (count($split_data) < 3 || count($split_data) > 3) {
                            $res['error'][$line] = 'Format ไฟล์ไม่ถูกต้อง';
                        } else {
                            $total++;
                            list($mobile, $code, $template) = $split_data;
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

                            if (!collect($template_list)->contains('template', $template)) {
                                $res['error'][$line] = "ไม่พบข้อมูล - {$template}";
                                continue;
                            }
                            array_push($already_code, $code);
                        }
                    }
                    break;
            }
            if (!isset($res['error'])) {
                $total_text = number_format($total, 0);
                $res['msg'] = "{$total_text} รายการที่สามารถ Generate ได้";
            }
        } else {
            $res['status'] = false;
        }

        return response()->json($res);
    }

    public function generate(Request $request, Campaign $campaign)
    {
        $res['status'] = true;

        $now = date('YmdHis');
        $type = $request->type_split_data;
        $refid = "{$campaign->keyword}@{$now}";
        $temp_file_content = $this->getFileTemp($campaign->keyword);
        if ($temp_file_content) {
            $unique_data = DB::connection('storage_code')->table($campaign->table_name)->where(['flag' => ['ok', 'deviate']])->pluck('unique_code', 'secret_code')->toArray();
            $lot = DB::connection('storage_code')->table($campaign->table_name)->where(['flag' => ['ok', 'deviate']])->max('lot');
            $lot = $lot + 1;
            [$already_secret, $already_unique] = Arr::divide($unique_data);
            $privilege_list = $this->getPrivilegeList($campaign);
            $template_list = $this->getTemplateList($campaign);
            $contents = explode("\r\n",  $temp_file_content);

            foreach ($contents as $key => $data) {
                $split_data = explode($type, $data);
                switch ($campaign->template_type) {
                    case 'STD':
                        list($mobile, $code, $shop_keyword, $value, $expire) = $split_data;
                        $privilege_id = $privilege_list[$shop_keyword][$expire][$value]['id'];
                        $privilege_keyword = $privilege_list[$shop_keyword][$expire][$value]['keyword'];
                        break;
                    case 'CTM':
                        list($mobile, $code, $template) = $split_data;
                        $templates = collect($template_list)->firstWhere('template', $template);
                        $privilege_id = $templates['privilege_id'];
                        $privilege_keyword = $templates['privilege_keyword'];
                        $shop_keyword = $templates['shop_keyword'];
                        $value = $templates['value'];
                        $expire = $templates['expire'];
                        break;
                }
                $secret_code =  $this->getSecretCode($campaign->keyword, $already_secret);
                $unique = $this->getUnique($already_unique);

                $res['data'][$key]['mobile'] = $mobile;
                $res['data'][$key]['code'] = $code;
                $res['data'][$key]['secret_code'] = $secret_code;
                $res['data'][$key]['unique_code'] = $this->getPathRedeem($campaign->owner->keyword, $campaign->keyword, $unique);

                $insert = [
                    'refid'             => "'{$refid}'",
                    'lot'               => "'{$lot}'",
                    'partner_keyword'   => "'{$campaign->owner->keyword}'",
                    'privilege_id'      => "'{$privilege_id}'",
                    'privilege_keyword' => "'{$privilege_keyword}'",
                    'shop_keyword'      => "'{$shop_keyword}'",
                    'secret_code'       => "'{$secret_code}'",
                    'unique_code'       => "'{$unique}'",
                    'msisdn'            => "'{$mobile}'",
                    'code'              => "'{$code}'",
                    'value'             => "'{$value}'",
                    'import_date'       => "now()",
                    'expire_date'       => "'{$expire} 23:59:59'",
                    'flag'              => "'ok'",
                    'is_use'            => "'no'",
                ];

                $condition = implode(', ', array_map(function ($key, $value) {
                    return "$key = $value";
                }, array_keys($insert), $insert));

                $res['data'][$key]['sql'] = "INSERT INTO `{$campaign->table_name}` SET {$condition};";
            }
        } else {
            $res['status'] = false;
        }
        return response()->json($res);
    }

    public function randomUpperLower($string)
    {
        $text = '';
        foreach (str_split($string) as $char) {
            if (rand(0, 1)) {
                $text .= strtoupper($char);
            } else {
                $text .= strtolower($char);
            }
        }
        return $text;
    }

    public function getPrivilegeList($campaign)
    {
        foreach ($campaign->privileges as $privilege) {
            $end_date = date('Y-m-d', strtotime($privilege->end_date));
            $privilege_list[$privilege->shop->keyword][$end_date][$privilege->value]['id'] = $privilege->id;
            $privilege_list[$privilege->shop->keyword][$end_date][$privilege->value]['keyword'] = $privilege->keyword;
        }

        return $privilege_list ?? [];
    }

    public function getTemplateList($campaign)
    {
        $campaign->privileges->map(function ($privilege, $key) use (&$templates) {
            $template_file = FileModel::where(['table_id' => $privilege->id, 'table_name' => 'privileges', 'status' => 'active'])->pluck('origin_name', 'id')->toArray();
            [$keys, $values] = Arr::divide($template_file);
            $templates[$privilege->id] = [
                'p_id' => $privilege->id,
                'privilege_id' => $privilege->id,
                'privilege_keyword' => $privilege->keyword,
                'shop_keyword' => $privilege->shop->keyword,
                'template' => $values[0],
                'value' => $privilege->value,
                'expire' => date('Y-m-d', strtotime($privilege->end_date))
            ];
            return $privilege;
        });

        return $templates ?? [];
    }

    public function getFileTemp($keyword)
    {
        $uuid = base64_encode(auth()->id());
        $temp_path_file = storage_path("temp_file/{$keyword}/file_{$uuid}.tmp");
        $temp_file_encrypt = File::get($temp_path_file);
        return Crypt::decrypt($temp_file_encrypt);
    }

    public function getPathRedeem($owner_keyword, $campaign_keyword, $unique_code)
    {
        return env('APP_URL_REDEEM') . Str::lower("{$owner_keyword}/{$campaign_keyword}/") . $unique_code;
    }

    public function getUnique($arr)
    {
        $unique = Str::random(16);
        $has_data = collect($arr)->contains($unique);
        if ($has_data) {
            $this->getUnique($arr);
        }
        return $unique;
    }
    public function getSecretCode($keyword, $arr)
    {

        $secret_code = $this->genSecrectCode($keyword);
        $has_data = collect($arr)->contains($secret_code);
        if ($has_data) {
            $this->getSecretCode($keyword, $arr);
        }
        return $secret_code;
    }

    public function genSecrectCode($keyword, $length = 9)
    {
        $length = $length - strlen($keyword);
        $alphabets = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $numbers = '23456789';
        $characters = $alphabets . $numbers;
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            if ($i % 2 == 0) {
                $randomString .= $alphabets[rand(0, strlen($alphabets) - 1)];
            } else {
                $randomString .= $numbers[rand(0, strlen($numbers) - 1)];
            }
        }
        $shuffledString = str_shuffle($randomString);

        return $keyword . $shuffledString;
    }

    public function changePrivilege(Request $request, Campaign $campaign)
    {
        $privileges = $campaign->privileges;
        $id = $request->id;
        return view('site.warehouse._change-privilege', [
            'id' => json_encode($id)
        ])->with(compact('privileges'))->with(compact('campaign'));
    }

    public function storeChange(Request $request, Campaign $campaign)
    {
        $privilege = $campaign->privileges()->find($request->select);
        $unique_id = json_decode($request->id);
        DB::connection('storage_code')->table($campaign->table_name)
            ->whereIn('id', $unique_id)
            ->update([
                'shop_keyword' => $privilege->shop->keyword,
                'privilege_keyword' => $privilege->keyword,
                'value' => $privilege->value,
                'expire_date' => $privilege->end_date
            ]);
        echo '<script>window.close();</script>';
    }
}
