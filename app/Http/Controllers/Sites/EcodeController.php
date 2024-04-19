<?php

namespace App\Http\Controllers\Sites;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EcodeExport;
use App\Http\Controllers\Controller;
use App\Models\EcodeCampaign;
use App\Models\EcodeWarehouse;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Shop;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Make;
use Str;
use Log;

class EcodeController extends Controller
{
    public function getUUID()
    {
        return base64_encode(auth()->id());
    }
    public function dashboard(EcodeCampaign $campaign)
    {
        $ecode_data = EcodeWarehouse::where('campaign_id', $campaign->id)->get();
        $lot = EcodeWarehouse::select('date_lot', 'number_lot')->where('campaign_id', $campaign->id)->groupBy('date_lot', 'number_lot')->get();
        $array_lot = ['all' => 'ทั้งหมด'];
        foreach ($lot as $value) {
            $array_lot[$value->date_lot]["{$value->date_lot}-" . str_pad($value->number_lot, 3, 0, STR_PAD_LEFT)] = $value->number_lot;
        }

        return view('site.ecode.dashboard', [
            'data' => $ecode_data,
            'campaign' => $campaign,
            'array_lot' => json_encode($array_lot, JSON_UNESCAPED_SLASHES || JSON_UNESCAPED_UNICODE)
        ]);
    }

    public function import(EcodeCampaign $campaign): View
    {
        $this->deleteFile();
        $shops = Shop::where(['status' => 'active'])->get();
        return view('site.ecode.import', [
            'shops' => $shops ?? [],
            'campaign' => $campaign
        ]);
    }

    public function load(Request $request)
    {
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

    public function generate(Request $request, EcodeCampaign $campaign)
    {
        $campaign_id = $request->campaign_id;
        $type = $request->type;
        $shop_id = $request->shop;
        $expire_date = $request->expire;

        $temp_file_content = $this->getFile();
        $date_lot = date('Ymd');
        $last_lot = EcodeWarehouse::where('date_lot', $date_lot)->max('number_lot');
        $lot = $last_lot + 1;
        $shop = Shop::find($shop_id);

        $lot_syntax = $date_lot . '-' . str_pad($lot, 3, 0, STR_PAD_LEFT);

        if ($temp_file_content) {
            $date_s = date('Ym');
            $contents = explode(PHP_EOL, $temp_file_content);
            $full_path = "https://a.yllo.in/e-code/{$type}/{$date_s}/";

            $ecode_data = EcodeWarehouse::where('type', $type)->pluck('code');

            list($success, $skip, $error) = [0, 0, 0];
            $error_data = [];
            $currentDir = getcwd();
            chdir('../../ecoupon/e-code/');
            foreach ($contents as $index => $content) {
                list($code, $value) = explode('|', $content);
                $value = intval(trim($value));
                if (!$ecode_data->contains($code)) {
                    $unique = "STB_{$value}B_{$date_lot}" . Str::random(12);

                    if ($type === 'qrcode') {
                        $returnEcode = Make::QRcode($code, $unique);
                    } else {
                        $returnEcode = Make::Barcode($code, $unique);
                    }

                    if ($returnEcode) {
                        EcodeWarehouse::create([
                            'campaign_id' => $campaign_id,
                            'date_lot' => $date_lot,
                            'number_lot' => $lot,
                            'type' => $type,
                            'code' => $code,
                            'value' => $value,
                            'unique' => $returnEcode->unique,
                            'file_name' => $returnEcode->fileName,
                            'path' => $full_path . $returnEcode->fileName,
                            'expire_date' => $expire_date,
                            'shop_id' => $shop->id,
                            'import_by' => auth()->id(),
                        ]);
                        $success++;
                    } else {
                        $error++;
                        $error_data[] = 'บันทึกข้อมูลไม่สำเร็จ';
                    }
                } else {
                    $skip++;
                    $error_data[] = $code;
                }
            }
            chdir($currentDir);
            return response()->json(['status' => 'ok', 'lot' => $lot_syntax, 'error' => $error_data, 'data' => ["นำเข้าข้อมูลเรียบร้อยแล้ว Lot : {$lot_syntax}", "นำเข้าสำเร็จ : $success , ข้าม : $skip , มีปัญหา : $error"]]);
        } else {
            return response()->json(['status' => 'error', 'error' => ['ไม่พบไฟล์ข้อมูล']]);
        }
    }

    public function export(Request $request)
    {
        $date_now = date('YmdHi');
        $campaign_id = $request->campaign_id;
        $lot = $request->lot;

        return Excel::download(new EcodeExport($lot, $campaign_id), "Ecode@{$date_now}.xlsx");
    }

    public function fields($model = null)
    {
        $type = $model ? 'update' : 'create';

        $deps = Department::where(['status' => 'active'])->get();
        foreach ($deps as $dep) {
            $departments[$dep->partner->name][$dep->id] = $dep->name;
        }

        $fields = [
            'type' => $type,
            'name' => old('name') ?? $model->name ?? '',
            'description' => old('description') ?? $model->description ?? '',
            'owner_id' => old('owner_id') ?? $model->owner_id ?? '',
            'status' => old('status') ?? $model->status ?? 'active',
            'owner_lists' => $departments ?? [],
        ];

        return $fields;
    }

    public function index()
    {
        $campaigns = EcodeCampaign::all();
        return view('site.ecode.index', [
            'campaigns' => $campaigns
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('components.views.create', [
            'title' => 'แคมเปญ',
            'route' => 'site.ecode',
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'owner_id' => 'required|exists:departments,id',
            'description' => 'nullable'
        ]);

        $ecode = new EcodeCampaign();
        $ecode->fill($validated);
        $ecode->created_by = auth()->user()->id;
        $ecode->updated_by = auth()->user()->id;
        $ecode->save();

        $name = $ecode->name;

        return redirect()->route('site.ecode.dashboard', $ecode->id)
            ->with('success', __('message.created', ['name' => $name]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EcodeCampaign $campaign): View
    {
        return view('components.views.update', [
            'title' => 'แคมเปญ',
            'route' => 'site.ecode',
            'params' => ['campaign' => $campaign],
            'fields' => $this->fields($campaign),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EcodeCampaign $campaign): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'owner_id' => 'required|exists:departments,id',
            'description' => 'nullable'
        ]);


        $campaign->fill($validated);
        $campaign->updated_by = auth()->user()->id;
        $campaign->save();

        $name = $campaign->name;

        return redirect()->route("site.ecode.index")
            ->with('success', __('message.updated', ['name' => $name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EcodeCampaign $campaign): RedirectResponse
    {
        $name = $campaign->name;
        EcodeWarehouse::where('campaign_id', $campaign->id)->delete();

        $campaign->delete();

        return redirect()->route("site.ecode.index")->with('success', __('message.deleted', ['name' => $name]));
    }

    public function remove(Request $request)
    {
        $data = EcodeWarehouse::find($request->id);
        $path = parse_url($data->path, PHP_URL_PATH);
        $pathWithoutSlash = substr($path, 1);
        $campaign_id = $data->campaign_id;
        $data->delete();

        if (app()->isProduction()) {
            $currentDir = getcwd();
            chdir('../../ecoupon/');
            File::delete($pathWithoutSlash);
            chdir($currentDir);
        }

        return redirect()->route("site.ecode.dashboard", $campaign_id)->with('success', __('message.deleted'));
    }

    public function deleteFile()
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
