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
        $type = $model ? 'update' : 'create';

        if ($model) {
            $assign_users = $model->assign_lists->pluck('user_id')->toArray();
            $settings = json_decode($model->settings);
        }

        $fields = [
            'type'          => $type,
            'template_type' => old('template_type') ?? $model->template_type ?? $_GET['template_type'] ?? 'STD',
            'connection'    => old('connection') ?? $model->connection ?? $_GET['template_type'] === 'CTMS' ? 'db_a' : 'db_storage_code',
            'name'          => old('name') ?? $model->name ?? '',
            'keyword'       => old('keyword') ?? $model->keyword ?? '',
            'description'   => old('description') ?? $model->description ?? '',
            'start_date'    => old('start_date') ?? $model->start_date ?? date('Y-m-d 00:00:00'),
            'end_date'      => old('end_date') ?? $model->end_date ??  date('Y-m-t 23:59:59'),
            'owner_id'      => old('owner_id') ?? $model->owner_id ?? $_GET['owner_id'] ?? '',
            'assign_users'  => old('assign_lists') ?? $assign_users ?? [],
            'status'        => old('status') ?? $model->status ?? 'active',
            'settings'      => (object) [
                'alert' => (object) [
                    'title'       => old('settings.alert.title') ?? $settings->alert->title ?? 'ยืนยันรับสิทธิ์',
                    'description' => old('settings.alert.description') ?? $settings->alert->description ?? 'ถ้ากดรับสิทธิ์จะไม่สามารถแก้ไขหรือยกเลิกได้'
                ],
                'button' => (object) [
                    'redeem'  => old('settings.button.redeem') ?? $settings->button->redeem ?? 'กดรับสิทธิ์',
                    'view'    => old('settings.button.view') ?? $settings->button->view ?? 'ดูโค้ด',
                    'already' => old('settings.button.already') ?? $settings->button->already ?? 'รับสิทธิ์เรียบร้อยแล้ว',
                    'expire'  => old('settings.button.expire') ?? $settings->button->expire ?? 'หมดอายุแล้ว',
                ],
                'color' => (object) [
                    'main'      => old('settings.color.main') ?? $settings->color->main ?? '#FFFFFF',
                    'secondary' => old('settings.color.secondary') ?? $settings->color->secondary ?? '#2196F3',
                    'redeem'    => old('settings.color.redeem') ?? $settings->color->redeem ?? '#8BC34A',
                    'view'      => old('settings.color.view') ?? $settings->color->view ?? '#FFC107',
                    'already'   => old('settings.color.already') ?? $settings->color->already ?? '#9E9E9E',
                    'expire'    => old('settings.color.expire') ?? $settings->color->expire ?? '#F44336',
                ]
            ]
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
        $type = $_GET['template_type'];

        return view('components.views.create', [
            'title' => 'แคมเปญ - 2/2',
            'route' => 'site.campaigns',
            'fields' => $this->fields(),
            'cols' => $type === 'STD' ? 12 : 6
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
            'settings' => 'nullable|array',
        ]);

        DB::transaction(function () use ($validated, $request, &$campaign) {
            $campaign = new Campaign;
            $campaign->fill($validated);
            $campaign->keyword = Str::upper($campaign->keyword);
            $campaign->connection = $request->connection ?? 'db_storage_code';

            if ($campaign->template_type !== 'CTMS') {
                $table_name = Str::lower("tb_{$campaign->owner->keyword}_{$campaign->keyword}");
                $campaign->table_name = $table_name;
            } else {
                $campaign->table_name = $request->table_name;
            }

            $campaign->settings = json_encode($campaign->settings, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $campaign->created_by = Auth::id();
            $campaign->updated_by = Auth::id();
            $campaign->save();

            if ($campaign->template_type !== 'CTMS' && !Schema::connection('db_storage_code')->hasTable($table_name)) {
                Schema::connection('db_storage_code')->create($table_name, function (Blueprint $table) use ($campaign) {
                    $table->id();
                    $table->string('refid');
                    $table->string('partner_keyword', 10)->index()->default($campaign->keyword);
                    $table->string('privilege_keyword', 10)->index();
                    $table->string('shop_keyword', 10)->index();
                    $table->string('secret_code', 12)->unique();
                    $table->string('unique_code', 20)->unique();
                    $table->string('msisdn', 11)->nullable();
                    $table->string('code');
                    $table->string('value', 5);
                    $table->dateTime('import_date');
                    $table->dateTime('start_date');
                    $table->dateTime('update_date')->nullable();
                    $table->dateTime('first_view_date')->nullable();
                    $table->dateTime('last_view_date')->nullable();
                    $table->dateTime('redeem_date')->nullable();
                    $table->dateTime('expire_date')->nullable();
                    $table->enum('flag', ["ok", "cancel", "deviate"]);
                    $table->enum('is_use', ["yes", "no"]);
                    $table->text('info')->nullable();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        $type = $campaign->template_type;

        return view('components.views.update', [
            'params' => ['campaign' => $campaign->id],
            'title' => $campaign->name,
            'route' => 'site.campaigns',
            'fields' => $this->fields($campaign),
            'cols' => $type === 'STD' ? 12 : 6
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
            'settings' => 'nullable|array',
        ]);

        DB::transaction(function () use ($validated, $request, &$campaign) {
            $campaign->fill($validated);
            $campaign->settings = json_encode($campaign->settings, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
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
