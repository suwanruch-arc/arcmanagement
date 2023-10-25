<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\UserReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ReportSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public static function getReportList()
    {
        return [];
    }

    public function fields($model = null)
    {
        if ($model) {
            $assign_users = $model->assign_lists->pluck('user_id')->toArray();
        }
        $type = $model ? 'update' : 'create';
        $fields = [
            'type' => $type,
            'report_id' => $model->id ?? null,
            'uuid' => old('uuid') ?? ($model ? $model->uuid : ''),
            'connection' => old('connection') ?? ($model ? $model->connection : 'main'),
            'type_query' => old('type_query') ?? ($model ? $model->type_query : 'std'),
            'name' => old('name') ?? ($model ? $model->name : ''),
            'description' => old('description') ?? ($model ? $model->description : ''),
            'assign_users' => $assign_users ?? [],
        ];
        return $fields;
    }

    public function getForm(Request $request)
    {
        $report = Report::find($request->report);
        $type_query = $request->type_query;
        switch ($type_query) {
            case 'std':
                return view('manage.reports._standard-form', [
                    'report' => $report ?? null
                ]);
                break;
            case 'raw':
                return view('manage.reports._sql-form', [
                    'sql' => old('sql') ?? ($report ? $report->sql : null)
                ]);
                break;
        }
    }

    public function getSelectForm()
    {
        return view('manage.reports._select-form');
    }

    public function index()
    {
        $reports = Report::all();

        return view('manage.reports.index')->with(compact('reports'));
    }

    public function create()
    {
        return view('components.views.create', [
            'title' => 'Report',
            'route' => 'manage.reports',
            'fields' => $this->fields(),
            'cols' => 12,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'connection' => 'required|in:main,db_storage_code,db_95,db_a,db_b',
            'type_query' => 'required|in:std,raw',
            'name' => 'required|max:255',
            'description' => 'nullable',
            'from' => 'required_if:type_query,std',
            'where' => 'nullable',
        ]);

        DB::transaction(function () use ($validated, $request, &$report) {
            $report = new Report();
            $report->fill($validated);
            $report->uuid = Str::uuid();
            $report->created_by = Auth::id();
            $report->updated_by = Auth::id();
            $report->save();

            if ($report->id && isset($request->assign_lists) && count($request->assign_lists)) {
                foreach ($request->assign_lists as $user_id) {
                    $assign = new UserReport();
                    $assign->report_id = $report->id;
                    $assign->user_id = $user_id;
                    $assign->assigned_by = Auth::id();
                    $assign->save();
                }
            }

            if ($report->id && isset($request->selects) && count($request->selects)) {
                foreach ($request->selects as $select) {
                    $item = (object) $select;
                    $report_setting = new ReportSetting();
                    $report_setting->report_id = $report->id;
                    $report_setting->is_search = (isset($item->is_search) && $item->is_search === 'on' ? 'yes' : 'no');
                    $report_setting->label = $item->label;
                    $report_setting->field = $item->field;
                    $report_setting->condition = $item->condition;
                    $report_setting->save();
                }
            }
        });

        $name = $report->name;

        return redirect()->route('manage.reports.index')
            ->with('success', __('message.created', ['name' => $name]));
    }

    public function edit(Report $report)
    {

        return view('components.views.update', [
            'title' => $report->name,
            'route' => 'manage.reports',
            'params' => ['report' => $report->id],
            'fields' => $this->fields($report),
            'cols' => 12,
        ]);
    }

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'connection' => 'required|in:main,db_storage_code,db_95,db_a,db_b',
            'type_query' => 'required|in:std,raw',
            'name' => 'required|max:255',
            'description' => 'nullable',
            'from' => 'required_if:type_query,std',
            'where' => 'nullable',
        ]);

        DB::transaction(function () use ($validated, $request,  &$report) {
            $report->fill($validated);
            $report->updated_by = Auth::id();
            $report->save();

            UserReport::where('report_id', $report->id)->delete();

            if (isset($request->assign_lists) && count($request->assign_lists)) {
                foreach ($request->assign_lists as $user_id) {
                    $assign = new UserReport();
                    $assign->report_id = $report->id;
                    $assign->user_id = $user_id;
                    $assign->assigned_by = Auth::id();
                    $assign->save();
                }
            }

            ReportSetting::where('report_id', $report->id)->delete();

            if (isset($request->selects) && count($request->selects)) {
                foreach ($request->selects as $select) {
                    $item = (object) $select;
                    $report_setting = new ReportSetting();
                    $report_setting->report_id = $report->id;
                    $report_setting->is_search = (isset($item->is_search) && $item->is_search === 'on' ? 'yes' : 'no');
                    $report_setting->label = $item->label;
                    $report_setting->field = $item->field;
                    $report_setting->condition = $item->condition;
                    $report_setting->save();
                }
            }
        });

        $name = $report->name;

        return redirect()->route('manage.reports.index')
            ->with('success', __('message.updated', ['name' => $name]));
    }

    public function destroy(Report $report)
    {
        $report_id = $report->id;
        $name = $report->name;

        ReportSetting::where('report_id', $report_id)->delete();
        UserReport::where('report_id', $report_id)->delete();

        $report->delete();

        return redirect()->route('manage.reports.index')
            ->with('success', __('message.deleted', ['name' => $name]));
    }

    public function show($uuid, Request $request)
    {
        $search = $request->input();
        $report = Report::whereUuid($uuid)->first();
        $table = $report->from;
        $where = $report->where;
        $query = DB::connection($report->connection)->table($table);
        if (!empty($where)) {
            $query->whereRaw($where);
        }
        if ($search) {
            $conditions = $report->settings->pluck('condition', 'field')->toArray();
            $statement = [];
            foreach ($search as $field => $value) {
                switch ($conditions[$field]) {
                    case 'LIKE':
                        $statement[] = "{$field} LIKE '%{$value}%'";
                        break;

                    default:
                        $statement[] = "{$field} = '{$value}'";
                        break;
                }
            }
            $searchStatement = implode(' AND ', $statement);
        }
        if (isset($searchStatement)) {
            $query->whereRaw($searchStatement);
        }
        $results = $query->get()->toArray();

        if (!count($report->settings)) {
            $ignoreStr = ['id', 'password', 'remember_token'];
            $patterns = ['_'];
            foreach (Schema::connection($report->connection)->getColumnListing($table) as $key => $field) {
                if (!in_array($field, $ignoreStr) && !preg_match("/_id/", $field)) {
                    $select['label'] = ucwords(str_replace($patterns, ' ', $field));
                    $select['field'] = $field;
                    $select['is_search'] = 'no';
                    $selects = (object) $select;
                    $report->settings->push($selects);
                }
            }
        }
        return view('site.reports.show', [
            'report' => $report,
            'results' => json_decode(json_encode($results), true)
        ]);
    }
}
