<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Models\File;
use App\Models\Shop;
use GuzzleHttp\Client;
use App\Models\Campaign;
use App\Models\Privilege;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class RedeemController extends Controller
{
    public function getRecaptchaKey()
    {
        return app()->isLocal() ? env('RECAPTCHA_KEY_LOCAL') : env('RECAPTCHA_KEY_PROD');
    }

    public function validateCaptcha($recaptcha)
    {
        $secretkeyrecaptcha = $this->getRecaptchaKey();
        $recaptcha = $recaptcha;
        $response = (object) json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretkeyrecaptcha}&response={$recaptcha}&remoteip={$_SERVER['REMOTE_ADDR']}"), true);

        return $response;
    }

    public function getDetail(Request $request)
    {
        $now = date('Y-m-d H:i:s');
        $campaign_keyword = Str::upper($request->c);
        $partner_keyword = Str::upper($request->p);
        $unique_code = $request->u;

        $logs['request'] = ['campaign' => $request->c, 'partner' => $request->p, 'unique' => $request->u];
        $logs['data_access'] = $now;

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
                                'status' => $privilege->skip_confirm === 'no',
                                'title' => $campaign->title_alert,
                                'desc'  => $campaign->desc_alert
                            ],
                            'themes' => [
                                'main'      => $campaign->main_color,
                                'secondary' => $campaign->secondary_color,
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
                            'has_tandc'   => $privilege->has_tandc === 'yes',
                            'tandc'       => $privilege->tandc,
                            'default_code' => $privilege->default_code,
                            'expire_date' => $privilege->end_date
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
        ])->info("Type:getDetail|Unique:{$unique_code}|Ip:{$request->ip()}|UserAgent:{$request->server('HTTP_USER_AGENT')}|Data:" . json_encode($logs) . "|Flag:" . json_encode($res['flag']));
        return response()->json($res);
    }

    public function getCode(Request $request)
    {
        $now = date('Y-m-d H:i:s');
        $campaign_keyword = Str::upper($request->c);
        $partner_keyword = Str::upper($request->p);
        $unique_code = $request->u;
        $response_recaptcha = $request->r;

        $logs['request'] = ['campaign' => $request->c, 'partner' => $request->p, 'unique' => $request->u];
        $logs['data_access'] = $now;

        $recapt = $this->validateCaptcha($response_recaptcha);
        if ($recapt->success && $recapt->score > 0.7) {
            $campaign = Campaign::where(['keyword' => $campaign_keyword, 'status' => 'active'])->first();
            $user = DB::connection('storage_code')
                ->table($campaign->table_name)->select(['id', 'code', 'is_use', 'expire_date', 'start_date', 'first_view_date', 'shop_id', 'privilege_id'])
                ->where(['partner_keyword' => $partner_keyword, 'flag' => 'ok'])
                ->where(DB::raw('BINARY unique_code'), '=', $unique_code)
                ->first();
            $privilege = $campaign->privileges()->find($user->privilege_id);

            if ($user) {
                $this->setFirstView($campaign->table_name, $user);
                if ($now <= $user->expire_date) {
                    if ($user->is_use === 'no') {
                        $expire = $privilege->has_timer === 'yes' ? date('Y-m-d H:i:s', strtotime("+{$privilege->timer_value}Minute")) : $user->expire_date;

                        $res['status'] = 'ok';
                        $res['code'] = $user->code;
                        $res['expire'] = $expire;
                        $res['default_code'] = $privilege->default_code;

                        $this->setRedeem($campaign->table_name, $user);
                    } else {
                        $res['status'] = 'already';
                    }
                } else {
                    $res['status'] = 'expired';
                }
            } else {
                $res['status'] = 'emptry';
            }
        } else {
            $res['status'] = 'error';
        }

        $date = date('Ymd');
        Log::build([
            'driver' => 'single',
            'path' => storage_path("logs/redeem/{$date}.log"),
        ])->info("Type:getCode|Unique:{$unique_code}|Ip:{$request->ip()}|UserAgent:{$request->server('HTTP_USER_AGENT')}|Data:" . json_encode($logs) . "|Return:" . json_encode($res));
        return response()->json($res);
    }

    public function getView(Request $request)
    {
        $now = date('Y-m-d H:i:s');
        $campaign_keyword = Str::upper($request->c);
        $partner_keyword = Str::upper($request->p);
        $unique_code = $request->u;
        $response_recaptcha = $request->r;

        $logs['request'] = ['campaign' => $request->c, 'partner' => $request->p, 'unique' => $request->u];
        $logs['data_access'] = $now;


        $recapt = $this->validateCaptcha($response_recaptcha);
        if ($recapt->success && $recapt->score > 0.7) {
            $campaign = Campaign::where(['keyword' => $campaign_keyword, 'status' => 'active'])->first();
            $user = DB::connection('storage_code')
                ->table($campaign->table_name)->select(['id', 'code', 'is_use', 'expire_date', 'start_date', 'first_view_date', 'shop_id', 'privilege_id'])
                ->where(['partner_keyword' => $partner_keyword, 'flag' => 'ok'])
                ->where(DB::raw('BINARY unique_code'), '=', $unique_code)
                ->first();
            $privilege = $campaign->privileges()->find($user->privilege_id);

            if ($user) {
                $this->setFirstView($campaign->table_name, $user);
                if ($now <= $user->expire_date) {
                    $expire = $privilege->has_timer === 'yes' ? date('Y-m-d H:i:s', strtotime("+{$privilege->timer_value}Minute")) : $user->expire_date;

                    $res['status'] = 'ok';
                    $res['code'] = $user->code;
                    $res['expire'] = $expire;
                    $res['default_code'] = $privilege->default_code;

                    $this->setRedeem($campaign->table_name, $user);
                } else {
                    $res['status'] = 'expired';
                }
            } else {
                $res['status'] = 'emptry';
            }
        } else {
            $res['status'] = 'error';
        }

        $date = date('Ymd');
        Log::build([
            'driver' => 'single',
            'path' => storage_path("logs/redeem/{$date}.log"),
        ])->info("Type:getView|Unique:{$unique_code}|Ip:{$request->ip()}|UserAgent:{$request->server('HTTP_USER_AGENT')}|Data:" . json_encode($logs) . "|Return:" . json_encode($res));
        return response()->json($res);
    }

    public function setFirstView($table, $user)
    {
        if (is_null($user->first_view_date)) {
            DB::connection('storage_code')
                ->table($table)
                ->where('id', $user->id)
                ->where('code', $user->code)
                ->update([
                    'first_view_date' => date('Y-m-d H:i:s')
                ]);
        }
    }

    public function setRedeem($table, $user)
    {
        if ($user->is_use === 'no') {
            DB::connection('storage_code')
                ->table($table)
                ->where('id', $user->id)
                ->where('code', $user->code)
                ->update([
                    'redeem_date' => date('Y-m-d H:i:s'),
                    'is_use' => 'yes'
                ]);
        }
    }
}
