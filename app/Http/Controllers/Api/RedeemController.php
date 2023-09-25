<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Models\File;
use App\Models\Campaign;
use App\Models\Privilege;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;

class RedeemController extends Controller
{
    public function getDetail(Request $request)
    {
        $now = date('Y-m-d H:i:s');
        $campaign_keyword = Str::upper($request->c);
        $partner_keyword = Str::upper($request->p);
        $unique_code = $request->u;
        $privilege_keyword = $campaign_keyword . Str::upper(Str::substr($unique_code, 0, 7));
        $shop_keyword = Str::substr($unique_code, 0, 3);

        $shop = Shop::select('name')->where(['keyword' => $shop_keyword])->first();
        $campaign = Campaign::select('id', 'name', 'template_type', 'table_name')->where(['keyword' => $campaign_keyword, 'status' => 'active'])->first();
        $privilege = $campaign->privileges()->where(['keyword' => $privilege_keyword])->first();
        $user = DB::connection('storage_code')->table($campaign->table_name)->select(['code','is_use', 'expire_date', 'first_view_date'])->where(['partner_keyword' => $partner_keyword, 'flag' => 'ok'])->where(DB::raw('BINARY unique_code'), '=', $unique_code)->first();

        $banner = Image::get($privilege->id, 'privileges', 'banner');
        $template = Image::get($privilege->id, 'privileges', 'template');

        $campaign->makeHidden('id', 'table_name');
        $privilege->makeHidden('id', 'keyword', 'campaign_id', 'shop_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status');
        if ($now <= $user->expire_date) {
            $res['status'] = true;
            $res['template_type'] = $campaign->template_type;
            $res['code_type'] = $privilege->default_code;

            switch ($campaign->template_type) {
                case 'STD':
                    $res['banner'] = $banner;
                    $res['campaign'] = $campaign;
                    $res['user'] = $user;
                    $res['shop'] = $shop;
                    $res['privilege'] = $privilege;
                    if ($privilege->can_view === 'yes') {
                        if ($user->is_use === 'yes') {
                            $res['flag'] = 'view';
                        } elseif ($now >= $user->expire_date) {
                            $res['flag'] = 'expire';
                        } else {
                            $res['flag'] = 'ok';
                        }
                    } else {
                        if ($user->is_use === 'yes') {
                            $res['flag'] = 'already';
                        } elseif ($now >= $user->expire_date) {
                            $res['flag'] = 'expire';
                        } else {
                            $res['flag'] = 'ok';
                        }
                    }
                    break;
                case 'CTM':
                    $res['template'] = $template;
                    $res['code'] = $user->code;
                    $res['settings'] = $privilege->settings;
                    break;
            }
        } else {
            $res['status'] = false;
        }
        return response()->json($res);
    }
}
