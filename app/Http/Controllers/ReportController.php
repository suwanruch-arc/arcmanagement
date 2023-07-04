<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\UserReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public static function getReportList()
    {
        return [];
    }

    public function fields($model = null)
    {
        if ($model) {
            $assign_users_collection = UserReport::where('report_id', $model->id)->get();
            $assign_users = $assign_users_collection->pluck('id')->toArray();
        }
        $type = $model ? 'update' : 'create';
        $fields = [
            'type' => $type,
            'report_id' => $model->id ?? null,
            'uuid' => old('uuid') ?? ($model ? $model->uuid : ''),
            'connection' => old('connection') ?? ($model ? $model->connection : 'mysql'),
            'type_query' => old('type_query') ?? ($model ? $model->type_query : 'std'),
            'name' => old('name') ?? ($model ? $model->name : ''),
            'description' => old('description') ?? ($model ? $model->description : ''),
            // 'totalCol' => ($model ? count($model->columns) : 0),
            'assign_users' => $assign_users ?? []
        ];
        return $fields;
    }

    public function getForm(Request $request)
    {
        $type_query = $request->type_query;
        switch ($type_query) {
            case 'std':
                return view('manage.reports._standard-form');
                break;
            case 'raw':
                return view('manage.reports._sql-form');
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
        print_r($request->all());
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
}
