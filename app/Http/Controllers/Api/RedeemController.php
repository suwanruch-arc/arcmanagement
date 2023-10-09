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
                            'default_code' => $privilege->default_code
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

    public function getCode(Request $request)
    {

        $now = date('Y-m-d H:i:s');
        $campaign_keyword = Str::upper($request->c);
        $partner_keyword = Str::upper($request->p);
        $unique_code = $request->u;
        $response_recaptcha = $request->r;

        $recapt = $this->validateCaptcha($response_recaptcha);
        if ($recapt->success && $recapt->score > 0.7) {
            $campaign = Campaign::where(['keyword' => $campaign_keyword, 'status' => 'active'])->first();
            $user = DB::connection('storage_code')
                ->table($campaign->table_name)->select(['code', 'is_use', 'expire_date', 'start_date', 'first_view_date', 'shop_id', 'privilege_id'])
                ->where(['partner_keyword' => $partner_keyword, 'flag' => 'ok'])
                ->where(DB::raw('BINARY unique_code'), '=', $unique_code)
                ->first();
            $privilege = $campaign->privileges()->find($user->privilege_id);

            if ($user) {
                if ($now <= $user->expire_date) {
                    if ($user->is_use === 'no') {
                        $res['status'] = 'ok';
                        $res['code'] = $user->code;
                        $res['default_code'] = $privilege->default_code;
                    } else {
                        $res['status'] = 'already';
                    }
                } else {
                    $res['status'] = 'expired';
                }
            } else {
                $res['status'] = 'emptry';
            }
        }else{
            $res['status'] = 'error';
        }

        return response()->json($res);
    }

    public function getView()
    {
    }
}
