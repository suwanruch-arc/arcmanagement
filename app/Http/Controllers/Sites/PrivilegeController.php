<?php

namespace App\Http\Controllers\Sites;

use App\Models\Shop;
use App\Models\Campaign;
use App\Models\Privilege;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\FileServiceProvider;

class PrivilegeController extends Controller
{

    public function getShopLists()
    {
        $shop_lists = Shop::where('status', 'active')->pluck('name', 'id')->toArray();

        return $shop_lists ?? [];
    }

    public function fields($campaign, $model = null)
    {
        $type = $model ? 'update' : 'create';

        // dd($model->settings);
        $fields = [
            'id' => ($model ? $model->id : ''),
            'type' => $type,
            'campaign' => $campaign,
            'title' => old('title') ?? ($model ? $model->title : ''),
            'value' => old('value') ?? ($model ? $model->value : 0),
            'default_code' => old('default_code') ?? ($model ? $model->default_code : 'qrcode'),
            'shop_id' => old('shop_id') ?? ($model ? $model->shop_id : ''),
            'shop_lists' => $this->getShopLists(),
            'start_date' => old('start_date') ?? ($model ? $model->start_date : $campaign->start_date),
            'end_date' => old('end_date') ?? ($model ? $model->end_date : $campaign->end_date),
            'has_timer' => old('has_timer') ?? ($model ? $model->has_timer == 'yes' : false),
            'timer_value' => old('timer_value') ?? ($model ? $model->timer_value : 10),
            'skip_confirm' => old('skip_confirm') ?? ($model ? $model->skip_confirm == 'yes' : false),
            'can_view' => old('can_view') ?? ($model ? $model->can_view == 'yes' : false),
            'description' => old('description') ?? ($model ? $model->description : ''),
            'has_detail' => old('has_detail') ?? ($model ? $model->has_detail == 'yes' : false),
            'detail' => old('detail') ?? ($model ? $model->detail : ''),
            'has_tandc' => old('has_tandc') ?? ($model ? $model->has_tandc == 'yes' : false),
            'tandc' => old('tandc') ?? ($model ? $model->tandc : ''),
            'status' => old('status') ?? ($model ? $model->status : 'active'),
            'settings' =>  (object) [
                'font_size' => 16,
                'w' => 100,
                'h' => 100,
                'row1' => 540,
                'row2' => 100,
                'col1' => 400,
                'col2' => 200,
                'col3' => 400,
            ]
        ];

        return $fields;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Campaign $campaign)
    {
        $privileges = $campaign->privileges;

        return view('site.campaigns.privileges.index', compact('privileges'))->with(compact('campaign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Campaign $campaign)
    {
        return view('components.views.create', [
            'cols' => '8',
            'params' => ['campaign' => $campaign->id],
            'title' => 'Privilege',
            'route' => 'site.campaigns.privileges',
            'fields' => $this->fields($campaign),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required_if:template_type,STD|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|integer',
            'start_date' => 'required|date|date_format:Y-m-d H:i:s',
            'end_date' => [
                'required', 'date', 'after:start_date', 'date_format:Y-m-d H:i:s',
                Rule::unique('privileges')->where(function ($query) use ($campaign) {
                    return $query->where('value', request()->input('value'))->where('shop_id', request()->input('shop_id'))->where('campaign_id', $campaign->id);
                }),
            ],
            'default_code' => 'required|in:qrcode,barcode,textcode',
            'has_detail' => 'nullable',
            'detail' => 'required_if:has_detail,on',
            'has_tandc' => 'nullable',
            'tandc' => 'required_if:has_tandc,on',
            'shop_id' => 'required|exists:shops,id',
            'has_timer' => 'nullable',
            'timer_value' => 'required_if:has_timer,on',
            'can_view' => 'nullable',
            'skip_confirm' => 'nullable',
            'settings' => 'array',
            'status' => 'required|in:active,inactive'
        ]);
        DB::transaction(function () use ($validated, $request, $campaign, &$privilege) {
            $settings = json_encode($request->settings ?? []);

            $campaign_keyword = $campaign->keyword;
            $shop_keyword = Shop::whereId($request->shop_id)->value('keyword');
            $keyword = "{$campaign_keyword}{$shop_keyword}";

            $privilege = new Privilege;
            $privilege->fill($validated);
            $privilege->title = $privilege->title ?? "{$shop_keyword}_{$privilege->value}";
            $privilege->skip_confirm = $request->skip_confirm ? 'yes' : 'no';
            $privilege->has_detail = $request->has_detail ? 'yes' : 'no';
            $privilege->has_tandc = $request->has_tandc ? 'yes' : 'no';
            $privilege->has_timer = $request->has_timer ? 'yes' : 'no';
            $privilege->can_view = $request->can_view ? 'yes' : 'no';
            $privilege->campaign_id = $campaign->id;
            $privilege->keyword = $this->getKeyword($keyword);
            $privilege->lot = $this->getLot($validated);
            $privilege->settings = $settings;
            $privilege->created_by = Auth::id();
            $privilege->updated_by = Auth::id();
            $privilege->save();

            $id = $privilege->id;
            $table = $privilege->getTable();
            $path_privilege = "privilege/{$privilege->keyword}";

            if ($request->hasFile('banner')) {
                $file_banner = $request->file('banner');
                $field_banner = 'banner';

                $path_banner = "{$path_privilege}/banner";
                FileServiceProvider::store($file_banner, $path_banner, $id, $table,  $field_banner);
            }

            if ($request->hasFile('template')) {
                $file_template = $request->file('template');
                $field_template = 'template';

                $path_template = "{$path_privilege}/template";
                FileServiceProvider::store($file_template, $path_template, $id, $table,  $field_template);
            }
        });

        $name = $privilege->title;

        return redirect()->route('site.campaigns.privileges.index', ['campaign' => $campaign->id])
            ->with('success', __('message.created', ['name' => $name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Privilege  $privilege
     * @return \Illuminate\Http\Response
     */
    public function show(Privilege $privilege)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Privilege  $privilege
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign, Privilege $privilege)
    {
        return view('components.views.update', [
            'cols' => '8',
            'params' => ['campaign' => $campaign->id, 'privilege' => $privilege->id],
            'title' => $privilege->title,
            'route' => 'site.campaigns.privileges',
            'fields' => $this->fields($campaign, $privilege),
        ])->with(compact('privilege'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Privilege  $privilege
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign, Privilege $privilege)
    {
        $validated = $request->validate([
            'title' => 'required_if:template_type,STD|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|integer',
            'start_date' => 'required|date|date_format:Y-m-d H:i:s',
            'end_date' => [
                'required', 'date', 'after:start_date', 'date_format:Y-m-d H:i:s',
                Rule::unique('privileges')->where(function ($query) use ($campaign, $privilege) {
                    return $query->whereRaw("'STD' = '{$campaign->template_type}'")->where('campaign_id', $campaign->id)->where('value', request()->input('value'))->where('shop_id', request()->input('shop_id'))->where('id', '<>', $privilege->id);
                }),
            ],
            'default_code' => 'required|in:qrcode,barcode,textcode',
            'has_detail' => 'nullable',
            'detail' => 'required_if:has_detail,on',
            'has_tandc' => 'nullable',
            'tandc' => 'required_if:has_tandc,on',
            'shop_id' => 'required|exists:shops,id',
            'has_timer' => 'nullable',
            'timer_value' => 'required_if:has_timer,on',
            'can_view' => 'nullable',
            'skip_confirm' => 'nullable',
            'settings' => 'array',
            'status' => 'required|in:active,inactive'
        ]);

        DB::transaction(function () use ($validated, $request, &$privilege) {
            $settings = json_encode($request->settings ?? []);

            $privilege->fill($validated);
            $privilege->skip_confirm = $request->skip_confirm ? 'yes' : 'no';
            $privilege->has_detail = $request->has_detail ? 'yes' : 'no';
            $privilege->has_tandc = $request->has_tandc ? 'yes' : 'no';
            $privilege->has_timer = $request->has_timer ? 'yes' : 'no';
            $privilege->can_view = $request->can_view ? 'yes' : 'no';
            $privilege->settings = $settings;
            $privilege->updated_by = Auth::id();
            $privilege->save();

            $id = $privilege->id;
            $table = $privilege->getTable();
            $path_privilege = "privilege/{$privilege->keyword}";

            if ($request->hasFile('banner')) {
                $file_banner = $request->file('banner');
                $field_banner = 'banner';

                $path_banner = "{$path_privilege}/banner";
                FileServiceProvider::update($file_banner, $path_banner, $id, $table,  $field_banner);
            }

            if ($request->hasFile('template')) {
                $file_template = $request->file('template');
                $field_template = 'template';

                $path_template = "{$path_privilege}/template";
                FileServiceProvider::update($file_template, $path_template, $id, $table,  $field_template);
            }
        });

        $name = $privilege->title;

        return redirect()->route('site.campaigns.privileges.index', ['campaign' => $campaign->id])
            ->with('success', __('message.updated', ['name' => $name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Privilege  $privilege
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign, Privilege $privilege)
    {
        $name = $campaign->name;
        $privilege->update(['status' => 'inactive']);

        return redirect()->route("site.campaigns.privileges.index", $campaign->id)->with('success', __('message.disabled', ['name' => $name]));
    }

    // $campaign, $validated
    public function getKeyword($keyword)
    {
        $length = 4;
        $unique_keyword = Str::random($length);
        $f_keyword = Str::upper("{$keyword}{$unique_keyword}");
        if (Privilege::whereKeyword($f_keyword)->count() > 0) {
            $this->getKeyword($keyword);
        }
        return $f_keyword;
    }

    public function getLot($validated)
    {
        $input = (object) $validated;
        $lot = Privilege::where(['shop_id' => $input->shop_id, 'value' => $input->value])->max('lot');
        return $lot + 1;
    }
}
