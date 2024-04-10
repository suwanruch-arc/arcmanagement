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
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function fields($model = null)
    {
        $type = $model ? 'update' : 'create';
        $fields = [
            'type' => $type,
            'id' => $model->id ?? '',
            'status' => old('status') ?? $model->status ?? 'active',
            'name' => old('name') ?? $model->name ?? '',
            'keyword' => old('keyword') ?? $model->keyword ?? '',
            'department_name' => old('department_name') ?? '',
            'department_keyword' => old('department_keyword') ?? '',
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
        $partners = Partner::all();
        return view('manage.partners.index')->with(compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('components.views.create', [
            'title' => 'Partner',
            'route' => 'manage.partners',
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
            'name' => 'required|max:255',
            'keyword' => 'required|max:10|unique:partners',
            'department_name' => 'nullable|max:255',
            'department_keyword' => 'nullable|max:10|unique:departments,keyword',
            'status' => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($validated, $request, &$partner) {
            $partner = new Partner;
            $partner->name = $validated['name'];
            $partner->keyword = Str::upper($validated['keyword']);
            $partner->save();

            $department = new Department;
            $department->partner_id = $partner->id;
            $department->name = $validated['department_name'] ?? "{$partner->name}-main";
            $department->keyword = Str::upper($validated['department_keyword'] ?? $partner->keyword);
            $department->is_main = 'yes';
            $department->logo_width = 40;
            $department->save();

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $field = 'logo';

                $path_file = "partner/{$partner->keyword}/logo";
                $id = $department->id;
                $table = $department->getTable();
                FileServiceProvider::store($file, $path_file, $id, $table,  $field);
            }
        });

        $name = $partner->name;

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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        return view('components.views.update', [
            'params' => ['partner' => $partner->id],
            'title' => 'Partner',
            'route' => 'manage.partners',
            'fields' => $this->fields($partner),
        ])->with(compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'keyword' => 'required|max:10|unique:partners,id,' . $partner->id,
            'status' => 'required|in:active,inactive',
        ]);

        DB::transaction(function () use ($validated, $request, &$partner) {
            $partner->fill($validated);
            $partner->keyword = Str::upper($partner->keyword);
            $partner->status = $request->status;
            $partner->save();

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $field = 'logo';

                $department = Department::firstWhere(['partner_id' => $partner->id, 'is_main' => 'yes']);
                $path_file = "partner/{$partner->keyword}/logo";
                $id = $department->id;
                $table = $department->getTable();

                FileServiceProvider::update($file, $path_file, $id, $table,  $field);
            }
        });

        $name = $partner->name;

        return redirect()->route("manage.partners.index")
            ->with('success', __('message.updated', ['name' => $name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        $name = $partner->name;
        $partner->departments()->update(['status' => 'inactive']);
        $partner->update(['status' => 'inactive']);

        return redirect()->route("manage.partners.index")->with('success', __('message.disabled', ['name' => $name]));
    }
}
