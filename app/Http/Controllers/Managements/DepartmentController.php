<?php

namespace App\Http\Controllers\Managements;

use App\Models\File;
use App\Models\Partner;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Providers\FileServiceProvider;

class DepartmentController extends Controller
{
    public function fields($model = null)
    {
        $type = $model ? 'update' : 'create';
        $fields = [
            'type' => $type,
            'id' => $model ? $model->id : '',
            'status' => old('status') ?? ($model ? $model->status : ''),
            'name' => old('name') ?? ($model ? $model->name : ''),
            'keyword' => old('keyword') ?? ($model ? $model->keyword : ''),
        ];

        return $fields;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Partner $partner)
    {
        return view('components.views.create', [
            'title' => 'Department - ' . $partner->name,
            'route' => 'manage.partners.departments',
            'params' => ['partner' => $partner->id],
            'fields' => $this->fields(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'keyword' => 'required|max:5|unique:departments,keyword',
            'status' => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($validated, $request, &$partner, &$department) {
            $department = new Department;
            $department->fill($validated);
            $department->keyword = Str::upper($department->keyword);
            $department->partner_id = $partner->id;
            $department->is_main = 'no';
            $department->save();

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $path_file = "partner/{$partner->keyword}/logo";
                $id = $department->id;
                $table = $department->getTable();
                $field = 'logo';
                FileServiceProvider::store($file, $path_file, $id, $table,  $field);
            }
        });

        $name = $department->name;

        return redirect()->route("manage.partners.index")
            ->with('success', __('message.created', ['name' => $name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner, Department $department)
    {
        return view('components.views.update', [
            'params' => ['partner' => $partner->id, 'department' => $department->id],
            'title' => "{$department->name} - {$partner->name}",
            'route' => 'manage.partners.departments',
            'fields' => $this->fields($department),
        ])->with(compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'keyword' => 'required|max:5|unique:departments,id,' . $department->id,
            'status' => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($validated, $request, &$partner, &$department) {
            $department->fill($validated);
            $department->save();

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $path_file = "partner/{$partner->keyword}/logo";
                $id = $department->id;
                $table = $department->getTable();
                $field = 'logo';
                FileServiceProvider::update($file, $path_file, $id, $table,  $field);
            }
        });

        $name = $department->name;

        return redirect()->route("manage.partners.index")
            ->with('success', __('message.update', ['name' => $name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner, Department $department)
    {
        $name = $partner->name;

        $department->update(['status' => 'inactive']);

        return redirect()->route("manage.partners.index")->with('success', __('message.deleted', ['name' => $name]));
    }
}
