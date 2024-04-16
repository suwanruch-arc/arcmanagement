<?php

namespace App\Http\Controllers\Managements;

use App\Exports\EcodeExport;
use App\Models\Ecode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Shop;
use Make;
use Maatwebsite\Excel\Facades\Excel;

class Toolcontroller extends Controller
{
    public function getUUID()
    {
        return base64_encode(auth()->id());
    }
    public function main()
    {
        return view('manage.tools.index');
    }

    public function dashboard($type)
    {
        $data = Ecode::orderByDesc('date_lot')->orderByDesc('number_lot')->orderByDesc('id')->get();
        $lot = Ecode::select('date_lot', 'number_lot')->groupBy('date_lot', 'number_lot')->get();
        $array_lot = [];
        foreach ($lot as $value) {
            $array_lot[$value->date_lot]["{$value->date_lot}-" . str_pad($value->number_lot, 3, 0, STR_PAD_LEFT)] = $value->number_lot;
        }

        return view('manage.tools.dashboard', [
            'type' => $type,
            'data' => $data,
            'array_lot' => json_encode($array_lot, JSON_UNESCAPED_SLASHES || JSON_UNESCAPED_UNICODE)
        ]);
    }

    public function import($type)
    {
        $this->delete();

        $deps = Department::where(['status' => 'active'])->get();
        foreach ($deps as $dep) {
            $departments[$dep->partner->name][$dep->id] = $dep->name;
        }
        $shops = Shop::where(['status' => 'active'])->get();
        return view('manage.tools.import', [
            'type' => $type,
            'owner_lists' => $departments ?? [],
            'shops' => $shops ?? [],
        ]);
    }

    public function load(Request $request)
    {
        $type = $request->type;
        if ($request->hasFile('filepond')) {
            $file = $request->file('filepond');
            $temp_path = storage_path("temp_file/");
            $temp_name = "file_{$this->getUUID()}.tmp";
            $temp_path_file = $temp_path . $temp_name;

            $file->move($temp_path, $temp_name);

            $temp_file_content = File::get($temp_path_file);
            $content = explode(PHP_EOL, $temp_file_content);
            $encrypt_content = Crypt::encrypt($temp_file_content);
            File::put($temp_path_file, $encrypt_content);

            return response()->json(['status' => 'ok', 'data' => 'จำนวนข้อมูลทั้งหมด : ' . number_format(count($content), 0) . ' รายการ'], 200);
        } else {
            return response()->json(['status' => 'error'], 400);
        }
    }

    public function check(Request $request)
    {
        $type = $request->type;
        $temp_file_content = $this->getFile();
        $error = [];
        if ($temp_file_content) {
            $contents = explode(PHP_EOL, $temp_file_content);
            foreach ($contents as $index => $content) {
                $data = explode('|', $content);
                if (count($data) < 2) {
                    $error[$index] = 'แถว ' . ($index + 1) . ' ข้อมูลไม่ถูกต้อง';
                }
            }
        } else {
            return response()->json(['status' => 'error', 'error' => ['ไม่พบไฟล์ข้อมูล']]);
        }

        return response()->json(['status' => count($error) > 0 ? 'error' : 'ok', 'error' => $error]);
    }

    public function generate(Request $request)
    {
        $type = $request->type;
        $owner_id = $request->owner_id;
        $shop_id = $request->shop;
        $expire_date = $request->expire;

        $temp_file_content = $this->getFile();
        $error = [];
        $date_lot = date('Ymd');
        $last_lot = Ecode::where('date_lot', $date_lot)->max('number_lot');
        $lot = $last_lot + 1;
        $shop = Shop::find($shop_id);

        if ($temp_file_content) {
            $date_s = date('Ym');
            $contents = explode(PHP_EOL, $temp_file_content);
            $currentDir = getcwd();
            $path = "{$type}/{$date_s}/";
            $full_path = "https://a.yllo.in/ecode/{$path}";

            $ecode_data = Ecode::where('type', $type)->pluck('code');

            list($success, $skip) = [0, 0];
            foreach ($contents as $index => $content) {
                list($code, $value) = explode('|', $content);
                if (!$ecode_data->contains('qweqwe')) {
                    $unique = "STB_{$value}_{$date_lot}" . Str::random(12);
                    $qrcode = Make::QRcode($code, $unique);

                    Ecode::create([
                        'date_lot' => $date_lot,
                        'number_lot' => $lot,
                        'type' => $type,
                        'code' => $code,
                        'value' => $value,
                        'unique' => $qrcode->unique,
                        'path' => './' . $path . $qrcode->fileName,
                        'full_path' => $full_path . $qrcode->fileName,
                        'expire_date' => $expire_date,
                        'owner_id' => $owner_id ?? null,
                        'shop_id' => $shop->id,
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                    ]);
                    $success++;
                } else {
                    $skip++;
                }
            }
            chdir($currentDir);
            return response()->json(['status' => 'ok', 'data' => ["นำเข้าข้อมูลเรียบร้อยแล้ว Lot : {$date_lot}-" . str_pad($lot, 3, 0, STR_PAD_LEFT), "นำเข้าสำเร็จ : $success - ข้าม : $skip"]]);
        } else {
            return response()->json(['status' => 'error', 'error' => ['ไม่พบไฟล์ข้อมูล']]);
        }
    }

    public function export(Request $request)
    {
        $date_now = date('YmdHi');
        $lot = $request->lot;
        list($date_lot, $number_lot) = explode('-', $lot);
        return Excel::download(new EcodeExport($date_lot, $number_lot), "Ecode@{$date_now}.xlsx");
    }

    public function delete()
    {
        $uuid = base64_encode(auth()->id());
        $temp_path = storage_path("temp_file/");
        $temp_name = "file_{$uuid}.tmp";
        $temp_path_file = $temp_path . $temp_name;
        File::delete($temp_path_file);
    }

    public function getFile()
    {
        $uuid = base64_encode(auth()->id());
        $temp_path = storage_path("temp_file/");
        $temp_name = "file_{$uuid}.tmp";
        $temp_path_file = $temp_path . $temp_name;
        if (!file_exists($temp_path_file)) {
            return false;
        }
        $temp_file_encrypt = File::get($temp_path_file);
        $temp_file_content = Crypt::decrypt($temp_file_encrypt);

        return $temp_file_content;
    }
}
