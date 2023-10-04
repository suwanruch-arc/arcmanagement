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

        $campaign = Campaign::where(['keyword' => $campaign_keyword, 'status' => 'active'])->first();
        $user = DB::connection('storage_code')
            ->table($campaign->table_name)->select(['code', 'is_use', 'expire_date', 'start_date', 'first_view_date', 'shop_id', 'privilege_id'])
            ->where(['partner_keyword' => $partner_keyword, 'flag' => 'ok'])
            ->where(DB::raw('BINARY unique_code'), '=', $unique_code)
            ->first();

        if ($user && $now >= $user->start_date) {
            $privilege = $campaign->privileges()->find($user->privilege_id);
            switch ($campaign->template_type) {
                case 'STD':
                    $banner = Image::getUrl($privilege->id, 'privileges', 'banner');
                    $shop = $privilege->shop;
                    if ($now <= $user->expire_date) {
                        if ($privilege->can_view === 'yes' && $privilege->skip_confirm === 'yes') {
                            $flag = 'view';
                        } elseif ($privilege->can_view === 'yes' && $privilege->skip_confirm === 'no') {
                            if ($user->is_use === 'yes') {
                                $flag = 'already';
                            } else {
                                $flag = 'ok';
                            }
                        } elseif ($privilege->can_view === 'no' && $privilege->skip_confirm === 'yes') {
                            if ($user->is_use === 'yes') {
                                $flag = 'already';
                            } else {
                                $flag = 'view';
                            }
                        } elseif ($privilege->can_view === 'no' && $privilege->skip_confirm === 'no') {
                            if ($user->is_use === 'yes') {
                                $flag = 'already';
                            } else {
                                $flag = 'ok';
                            }
                        }

                    } else {
                        $flag = 'expire';
                    }
                    $res = [
                        'banner' => $banner,
                        'btn'    => $campaign->getButton($flag),
                        'config' => [
                            'alert' => [
                                'title' => $campaign->title_alert,
                                'desc'  => $campaign->desc_alert
                            ],
                            'themes' => [
                                'main'      => $campaign->main_color,
                                'secondary' => $campaign->secondary_color,
                            ]
                        ],
                        'flag'      => $flag,
                        'code_type' => $privilege->default_code,
                        'status'    => true,
                        'shop'      => [
                            'name' => $shop->name
                        ],
                        'privilege' => [
                            'title'       => $privilege->title,
                            'description' => $privilege->description,
                            'has_detail'  => $privilege->has_detail,
                            'detail'      => $privilege->detail,
                            'has_tandc'   => $privilege->has_tandc,
                            'tandc'       => $privilege->tandc,
                        ],
                        'user' => [
                            'expire_date' => $user->expire_date
                        ],
                        'template_type' => $campaign->template_type,
                    ];
                    break;
                case 'CTM':
                    $template = Image::getUrl($privilege->id, 'privileges', 'template');
                    $res = [
                        'code' => $user->code,
                        'code_type' => $privilege->default_code,
                        'settings' => $privilege->settings,
                        'status' => true,
                        'template' => $template,
                        'template_type' => $campaign->template_type,
                    ];
                    break;
            }
        } else {
            $res['status'] = false;
        }
        return response()->json($res);
    }
}
