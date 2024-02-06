<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Models\Campaign;
use App\Models\Privilege;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class DetailController extends Controller
{
    public function getData(Request $request)
    {
        $table_storage_code = 'db_storage_code';
        $now = date('Y-m-d H:i:s');
        $campaign_keyword = Str::upper($request->c);
        $partner_keyword = Str::upper($request->p);
        $unique_code = $request->u;

        $logs['request'] = ['campaign' => $request->c, 'partner' => $request->p, 'unique' => $request->u];
        $logs['data_access'] = $now;

        $campaign = Campaign::where(['keyword' => $campaign_keyword, 'status' => 'active'])->first();
        $user = DB::connection($table_storage_code)
            ->table($campaign->table_name)->select(['id', 'code', 'is_use', 'expire_date', 'start_date', 'first_view_date', 'privilege_keyword'])
            ->where(['partner_keyword' => $partner_keyword, 'flag' => 'ok'])
            ->where(DB::raw('BINARY unique_code'), '=', $unique_code)
            ->first();

        $user_update_data = DB::connection($table_storage_code)
            ->table($campaign->table_name)
            ->where('id', $user->id);

        if ($user->first_view_date === null) {
            $user_update_data->update([
                'first_view_date' => $now,
            ]);
        }

        $user_update_data->update([
            'last_view_date' => $now,
        ]);

        if ($user && $now >= $user->start_date) {
            $privilege = Privilege::where(['campaign_id' => $campaign->id, 'keyword' => $user->privilege_keyword])->first();
            $config = json_decode($campaign->settings);
            switch ($campaign->template_type) {
                case 'STD':
                    $logo = Image::getUrl($privilege->campaign->owner_id,'departments','logo');
                    $banner = Image::getUrl($privilege->id, 'privileges', 'banner') ?? Image::getUrl($privilege->shop->id, 'shops', 'banner');
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
                        'logo'   => $logo,
                        'banner' => $banner,
                        'btn'    => $campaign->getButton($flag),
                        'config' => [
                            'alert' => [
                                'status' => $privilege->skip_confirm === 'no',
                                'title' => $config->alert->title,
                                'desc'  => $config->alert->description
                            ],
                            'themes' => [
                                'main'      => $config->color->main,
                                'secondary' => $config->color->secondary,
                            ],
                            'timer' => [
                                'status' => $privilege->has_timer === 'yes',
                                'value' => $privilege->timer_value
                            ]
                        ],
                        'flag'      => $flag,
                        'status'    => true,
                        'shop'      => [
                            'name' => $shop->name
                        ],
                        'privilege' => [
                            'title'       => $privilege->title,
                            'description' => $privilege->description,
                            'has_detail'  => $privilege->has_detail === 'yes',
                            'detail'      => $privilege->detail,
                            'tandc'       => $privilege->tandc ?? $privilege->shop->tandc,
                            'default_code' => $privilege->default_code,
                            'expire_date' => $privilege->end_date
                        ],
                        'template_type' => $campaign->template_type,
                    ];
                    break;
                case 'CTMT':
                    $template = Image::getUrl($privilege->id, 'privileges', 'template') ?? Image::getUrl($privilege->shop->id, 'shops', 'template');
                    $res = [
                        'code' => $user->code,
                        'code_type' => $privilege->default_code,
                        'settings' => $privilege->settings,
                        'status' => true,
                        'flag' => 'ok',
                        'template' => $template,
                        'template_type' => $campaign->template_type,
                    ];
                    break;
            }
        } else {
            $res['status'] = false;
        }

        $date = date('Ymd');
        Log::build([
            'driver' => 'single',
            'path' => storage_path("logs/redeem/{$date}.log"),
        ])->info("Type:getDetail|Unique:{$unique_code}|Ip:{$request->ip()}|UserAgent:{$request->server('HTTP_USER_AGENT')}|" . json_encode($logs) . "|Flag:" . json_encode($res['flag']));
        return response()->json($res);
    }
}
