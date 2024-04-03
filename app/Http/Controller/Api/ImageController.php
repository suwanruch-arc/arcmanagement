<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Image;
use App\Models\Campaign;
use App\Models\Privilege;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    public function getPartner($partner)
    {
        $partner = Str::lower($partner);
        $department = Department::where('keyword', $partner)->value('id');
        $res = Image::get($department, 'departments', 'logo') ?? "https://a.yllo.in/assets/img/logo/{$partner}.png?" . time();
        return  response()->json($res, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public function getLogoPartner(Request $request){
        $table_storage_code = 'db_storage_code';
        $campaign_keyword = Str::upper($request->c);
        $partner_keyword = Str::upper($request->p);
        $unique_code = $request->u;
        $campaign = Campaign::where(['keyword' => $campaign_keyword, 'status' => 'active'])->first();
        $user = DB::connection($table_storage_code)
            ->table($campaign->table_name)->select(['id', 'code', 'is_use', 'expire_date', 'start_date', 'first_view_date', 'privilege_keyword'])
            ->where(['partner_keyword' => $partner_keyword, 'flag' => 'ok'])
            ->where(DB::raw('BINARY unique_code'), '=', $unique_code)
            ->first();
        $privilege = Privilege::where(['campaign_id' => $campaign->id, 'keyword' => $user->privilege_keyword])->first();
        $res['logo'] = Image::getUrl($privilege->campaign->owner_id,'departments','logo');
        $res['width'] = Department::where('id', $campaign->owner_id)->value('logo_width');
        return response()->json($res);
    }
}
