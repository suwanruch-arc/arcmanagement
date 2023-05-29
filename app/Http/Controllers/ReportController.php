<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public static function getReportList()
    {
        return [];
    }

    public function fields($model = null)
    {

        $type = $model ? 'update' : 'create';
        $fields = [
            'type' => $type,
            'report_id' => $model->id ?? null,
            'uuid' => old('uuid') ?? ($model ? $model->uuid : ''),
            'connection' => old('connection') ?? ($model ? $model->connection : 'mysql'),
            'type_query' => old('type_query') ?? ($model ? $model->type_query : 'std'),
            'name' => old('name') ?? ($model ? $model->name : ''),
            'description' => old('description') ?? ($model ? $model->description : ''),
            'totalCol' => ($model ? count($model->columns) : 0),
        ];
        return $fields;
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
            'header' => 'Report',
            'route' => 'manage.reports',
            'fields' => $this->fields(),
            'cols' => 12,
        ]);
    }
}
