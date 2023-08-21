<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Privilege;
use Illuminate\Http\Request;

class PrivilegeController extends Controller
{
    public function fields($campaign, $model = null)
    {
        $type = $model ? 'update' : 'create';
        $fields = [
            'type' => $type,
            'campaign' => $campaign,
            'shop_id' => old('shop_id') ?? ($model ? $model->shop_id : ''),
            // 'shop_list' => $this->getShopLists(),
            'title' => old('title') ?? ($model ? $model->title : ''),
            'description' => old('description') ?? ($model ? $model->description : ''),
            'value' => old('value') ?? ($model ? $model->value : ''),
            'start_date' => old('start_date') ?? ($model ? $model->start_date : ''),
            'end_date' => old('end_date') ?? ($model ? $model->end_date : ''),
            'has_timer' => old('has_timer') ?? ($model ? $model->has_timer == 'yes' : 0),
            'timer_value' => old('timer_value') ?? ($model ? $model->timer_value : ''),
            'can_view' => old('can_view') ?? ($model ? $model->can_view == 'yes' : 0),
            'default_code' => old('default_code') ?? ($model ? $model->default_code : 'qrcode'),
            'has_detail' => old('has_detail') ?? ($model ? $model->has_detail == 'yes' : 0),
            'detail' => old('detail') ?? ($model ? $model->detail : ''),
            'has_tandc' => old('has_tandc') ?? ($model ? $model->has_tandc == 'yes' : 0),
            'tandc' => old('tandc') ?? ($model ? $model->tandc : ''),
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
    public function store(Request $request)
    {
        //
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
    public function edit(Privilege $privilege)
    {
        //
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
}
