<?php

namespace App\Http\Controllers\Site;

use App\Models\Shop;
use App\Models\Campaign;
use App\Models\Privilege;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $fields = [
            'type' => $type,
            'campaign' => $campaign,
            'title' => old('title') ?? ($model ? $model->title : ''),
            'value' => old('value') ?? ($model ? $model->value : 0),
            'default_code' => old('default_code') ?? ($model ? $model->default_code : 'qrcode'),
            'shop_id' => old('shop_id') ?? ($model ? $model->shop_id : ''),
            'shop_lists' => $this->getShopLists(),
            'start_date' => old('start_date') ?? ($model ? $model->start_date : $campaign->start_date),
            'end_date' => old('end_date') ?? ($model ? $model->end_date : $campaign->end_date),
            'has_timer' => old('has_timer') ?? ($model ? $model->has_timer == 'yes' : 'no'),
            'timer_value' => old('timer_value') ?? ($model ? $model->timer_value : 60),
            'can_view' => old('can_view') ?? ($model ? $model->can_view == 'yes' : 0),
            'description' => old('description') ?? ($model ? $model->description : ''),
            'has_detail' => old('has_detail') ?? ($model ? $model->has_detail == 'yes' : 0),
            'detail' => old('detail') ?? ($model ? $model->detail : ''),
            'has_tandc' => old('has_tandc') ?? ($model ? $model->has_tandc == 'yes' : 0),
            'tandc' => old('tandc') ?? ($model ? $model->tandc : ''),
            'status' => old('status') ?? ($model ? $model->status : 'active'),
            'settings' => (object) [
                'font-size' => 0,
                'top' => 0,
                'left' => 0,
                'row-1' => 0,
                'row-2' => 0,
                'col-1' => 0,
                'col-2' => 0,
                'col-3' => 0,
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
        $privileges = Privilege::all();

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|integer',
            'start_date' => 'required|date|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date|after:start_date|date_format:Y-m-d H:i:s|unique:privileges,value,' . $request->value,
            'default_code' => 'required|in:qrcode,barcode,textcode',
            'has_detail' => 'nullable',
            'detail' => 'required_if:has_detail,on',
            'has_tandc' => 'nullable',
            'tandc' => 'required_if:has_tandc,on',
            'shop_id' => 'required|exists:shops,id',
            'has_timer' => 'nullable',
            'timer_value' => 'required_if:has_timer,on',
            'can_view' => 'nullable',
            'settings' => 'array'
        ]);
        DB::transaction(function () use ($validated, $request, $campaign, &$privilege) {
            $settings = json_encode($request->settings);

            $campaign_keyword = $campaign->keyword;
            $shop_keyword = Shop::whereId($request->shop_id)->value('keyword');
            $keyword = "{$campaign_keyword}{$shop_keyword}";

            $privilege = new Privilege;
            $privilege->fill($validated);
            $privilege->has_detail = $request->has_detail ? 'yes' : 'no';
            $privilege->has_tandc = $request->has_tandc ? 'yes' : 'no';
            $privilege->has_timer = $request->has_timer ? 'yes' : 'no';
            $privilege->can_view = $request->can_view ? 'yes' : 'no';
            $privilege->campaign_id = $campaign->id;
            $privilege->keyword = $this->getKeyword($keyword);
            $privilege->lot = $this->getLot($validated);
            $privilege->settings = $settings ?? null;
            $privilege->created_by = Auth::id();
            $privilege->updated_by = Auth::id();
            $privilege->save();
        });

        $name = $privilege->name;

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
    public function update(Request $request, Privilege $privilege)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Privilege  $privilege
     * @return \Illuminate\Http\Response
     */
    public function destroy(Privilege $privilege)
    {
        //
    }

    // $campaign, $validated
    public function getKeyword($keyword)
    {
        $length = 3;
        $unique_keyword = Str::random($length);
        $f_keyword = Str::lower("{$keyword}{$unique_keyword}");
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
