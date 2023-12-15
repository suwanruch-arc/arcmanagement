<?php

namespace App\Http\Controllers\Sites;

use App\Models\Partner;
use App\Models\Campaign;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Models\CampaignUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CampaignController extends Controller
{
    public function getOwnerLists()
    {
        $position = Auth::user()->position;
        switch ($position) {
            case 'leader':
                $deps = Department::where(['partner_id' => Auth::user()->partner_id, 'status' => 'active'])->get();
                break;
            default:
                $deps = Department::where(['status' => 'active'])->get();
                break;
        }
        foreach ($deps as $dep) {
            $departments[$dep->partner->name][$dep->id] = $dep->name;
        }
        return $departments ?? [];
    }

    public function fields($model = null)
    {
        if ($model) {
            $assign_users = $model->assign_lists->pluck('user_id')->toArray();
        }
        $type = $model ? 'update' : 'create';
        $fields = [
            'type'          => $type,
            'template_type' => old('template_type') ?? ($model ? $model->template_type : $_GET['template_type'] ?? 'STD'),
            'name'          => old('name') ?? ($model ? $model->name : ''),
            'keyword'       => old('keyword') ?? ($model ? $model->keyword : ''),
            'description'   => old('description') ?? ($model ? $model->description : ''),
            'start_date'    => old('start_date') ?? ($model ? $model->start_date : date('Y-m-d 00:00:00')),
            'end_date'      => old('end_date') ?? ($model ? $model->end_date :  date('Y-m-t 23:59:59')),
            'owner_id'      => old('owner_id') ?? ($model ? $model->owner_id : $_GET['owner_id'] ?? ''),
            'assign_users'  => old('assign_lists') ?? ($assign_users ?? []),
            'status'        => old('status') ?? ($model ? $model->status : 'active'),
            'title_alert'   => old('title_alert') ?? ($model ? $model->title_alert : 'ยืนยันรับสิทธิ์'),
            'desc_alert'    => old('desc_alert') ?? ($model ? $model->desc_alert : 'ถ้ากดรับสิทธิ์จะไม่สามารถแก้ไขหรือยกเลิกได้'),
            'redeem_btn'      => old('redeem_btn') ?? ($model ? $model->redeem_btn : 'กดรับสิทธิ์'),
            'view_btn'        => old('view_btn') ?? ($model ? $model->view_btn : 'ดูโค้ด'),
            'expire_btn'      => old('expire_btn') ?? ($model ? $model->expire_btn : 'หมดอายุแล้ว'),
            'already_btn'     => old('already_btn') ?? ($model ? $model->already_btn : 'รับสิทธิ์เรียบร้อยแล้ว'),
            'main_color'      => old('main_color') ?? ($model ? $model->main_color : '#FFFFFF'),
            'secondary_color' => old('secondary_color') ?? ($model ? $model->secondary_color : '#2196F3'),
            'redeem_color'    => old('redeem_color') ?? ($model ? $model->redeem_color : '#8BC34A'),
            'view_color'      => old('view_color') ?? ($model ? $model->view_color : '#FFC107'),
            'expire_color'    => old('expire_color') ?? ($model ? $model->expire_color : '#F44336'),
            'already_color'   => old('already_color') ?? ($model ? $model->already_color : '#9E9E9E'),
        ];
        return $fields;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $campaign_query = Campaign::orderBy('status')->orderBy('end_date');

        if ($request->department_id) {
            $campaign_query->where('owner_id', $request->department_id);
        }

        $campaigns = $campaign_query->get();

        $partner_id = Auth::user()->position === 'leader' ? Auth::user()->partner_id : null;

        return view('site.campaigns.index', [
            'partner_lists' => Partner::list(),
            'department_lists' => Department::list($partner_id),
        ])->with(compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function preCreate()
    {
        return view('site.campaigns.pre-create', [
            'owner_lists'   => $this->getOwnerLists(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('components.views.create', [
            'title' => 'Campaign',
            'route' => 'site.campaigns',
            'fields' => $this->fields(),
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
        $validated = $request->validate([
            'name' => 'required',
            'template_type' => 'required',
            'keyword' => 'required|min:3|max:3|unique:campaigns,keyword',
            'description' => 'nullable',
            'start_date' => 'required|date|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date|after:start_date|date_format:Y-m-d H:i:s',
            'owner_id' => 'required|exists:departments,id',
            'status' => 'required|in:active,inactive',
            'title_alert'    => 'required',
            'desc_alert'     => 'required',
            'title_alert'   => 'required',
            'desc_alert'    => 'required',
            'main_color'     => 'required',
            'secondary_color' => 'required',
            'redeem_color'   => 'required',
            'view_color'     => 'required',
            'expire_color'   => 'required',
            'already_color'  => 'required',
            'redeem_btn'     => 'required',
            'view_btn'       => 'required',
            'expire_btn'     => 'required',
            'already_btn'    => 'required',
        ]);


        DB::transaction(function () use ($validated, $request, &$campaign) {
            $campaign = new Campaign;
            $campaign->fill($validated);
            $campaign->keyword = Str::upper($campaign->keyword);
            $table_name = Str::lower("tb_{$campaign->owner->keyword}_{$campaign->keyword}");
            $campaign->table_name = $table_name;
            $campaign->created_by = Auth::id();
            $campaign->updated_by = Auth::id();
            $campaign->save();


            if (!Schema::connection('db_storage_code')->hasTable($table_name)) {
                Schema::connection('db_storage_code')->create($table_name, function (Blueprint $table) use ($campaign) {
                    $table->id();
                    $table->integer('lot');
                    $table->string('refid');
                    $table->string('partner_keyword', 10)->index();
                    $table->integer('shop_id')->index();
                    $table->string('shop_keyword', 10)->index();
                    $table->integer('privilege_id')->index();
                    $table->string('privilege_keyword', 10)->index();
                    $table->string('secret_code', 12)->unique();
                    $table->string('unique_code', 20)->unique();
                    $table->string('msisdn', 11)->nullable();
                    $table->string('code');
                    $table->string('value', 5);
                    $table->dateTime('import_date');
                    $table->dateTime('start_date');
                    $table->dateTime('update_date')->nullable();
                    $table->dateTime('redeem_date')->nullable();
                    $table->dateTime('first_view_date')->nullable();
                    $table->dateTime('expire_date')->nullable();
                    $table->text('info')->nullable();
                    $table->enum('flag', ["ok", "cancel", "deviate"]);
                    $table->enum('is_use', ["yes", "no"]);
                });
            }

            if ($campaign->id && isset($request->assign_lists) && count($request->assign_lists)) {
                foreach ($request->assign_lists as $user_id) {
                    $assign = new CampaignUser();
                    $assign->campaign_id = $campaign->id;
                    $assign->user_id = $user_id;
                    $assign->assigned_by = Auth::id();
                    $assign->save();
                }
            }
        });

        $name = $campaign->name;

        return redirect()->route('site.campaigns.index')
            ->with('success', __('message.created', ['name' => $name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        return view('components.views.update', [
            'params' => ['campaign' => $campaign->id],
            'title' => $campaign->name,
            'route' => 'site.campaigns',
            'fields' => $this->fields($campaign),
            'cols' => 12
        ])->with(compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'name' => 'required',
            'template_type' => 'required',
            'description' => 'nullable',
            'start_date' => 'required|date|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date|after:start_date|date_format:Y-m-d H:i:s',
            'owner_id' => 'required|exists:departments,id',
            'status' => 'required|in:active,inactive',
            'title_alert'    => 'required',
            'desc_alert'     => 'required',
            'title_alert'   => 'required',
            'desc_alert'    => 'required',
            'main_color'     => 'required',
            'secondary_color' => 'required',
            'redeem_color'   => 'required',
            'view_color'     => 'required',
            'expire_color'   => 'required',
            'already_color'  => 'required',
            'redeem_btn'     => 'required',
            'view_btn'       => 'required',
            'expire_btn'     => 'required',
            'already_btn'    => 'required',
        ]);

        DB::transaction(function () use ($validated, $request, &$campaign) {
            $campaign->fill($validated);
            $campaign->updated_by = Auth::id();
            $campaign->save();

            if ($campaign->id && isset($request->assign_lists) && count($request->assign_lists)) {
                CampaignUser::where(['campaign_id' => $campaign->id])->delete();
                foreach ($request->assign_lists as $user_id) {
                    $assign = new CampaignUser();
                    $assign->campaign_id = $campaign->id;
                    $assign->user_id = $user_id;
                    $assign->assigned_by = Auth::id();
                    $assign->save();
                }
            }
        });

        $name = $campaign->name;

        return redirect()->route('site.campaigns.index')
            ->with('success', __('message.updated', ['name' => $name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Campaign $campaign)
    {
        $name = $campaign->name;
        $campaign->departments()->update(['status' => 'inactive']);
        $campaign->update(['status' => 'inactive']);

        return redirect()->route("site.campaigns.index")->with('success', __('message.disabled', ['name' => $name]));
    }
}
