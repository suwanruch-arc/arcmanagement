<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Department;
use App\Models\Privilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class RedeemController extends Controller
{
    public function getDetail(Request $request)
    {
        $partner = Department::where('keyword', $request->p)->first();
        if (isset($partner->campaigns)) {
            $campaign = $partner->campaigns()->where('keyword', $request->c)->first();
            if ($campaign) {
                $unique_data = DB::connection('storage_code')
                    ->table($campaign->table_name)
                    ->select(['refid', 'partner_keyword', 'privilege_keyword', 'shop_keyword', 'code', 'first_view_date', 'redeem_date', 'expire_date', 'flag', 'is_use'])
                    ->where(DB::raw('BINARY unique_code'), '=', $request->u)
                    ->first();
                if ($unique_data) {
                    $privilege = $campaign->privileges()->where('keyword', '=', $unique_data->privilege_keyword)->first();
                    if ($privilege) {
                        $shop = $privilege->shop;
                        if ($shop) {

                            $banner = Image::get($privilege->id, 'privileges', 'banner');

                            $campaign->makeHidden(['id', 'table_name', 'owner_id', 'created_by', 'updated_by', 'created_at', 'updated_at']);
                            $privilege->makeHidden(['id',  'campaign_id', 'shop_id', 'created_by', 'updated_by', 'created_at', 'updated_at']);
                            $shop->makeHidden(['id',  'campaign_id', 'shop_id', 'created_by', 'updated_by', 'created_at', 'updated_at']);

                            $res['banner'] = $banner;
                            $res['campaign'] = $campaign;
                            $res['privilege'] = $privilege;
                            $res['user'] = $unique_data;

                            return response()->json($res);
                        }
                    }
                }
            }
        }

        return response()->json(null);
    }
}
