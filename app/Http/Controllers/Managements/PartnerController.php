<?php

namespace App\Http\Controllers\Managements;

use App\Models\Partner;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    public function fields($model = null)
    {
        $type = $model ? 'update' : 'create';
        $fields = [
            'type' => $type,
            'name' => old('name') ?? ($model ? $model->name : ''),
            'keyword' => old('keyword') ?? ($model ? $model->keyword : ''),
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
            'keyword' => 'required|max:5|unique:partners',
            'department_name' => 'nullable|max:255',
            'department_keyword' => 'nullable|max:5|unique:departments,keyword',
        ]);

        DB::transaction(function () use ($validated, $request, &$partner) {
            $partner = new Partner;
            $partner->name = $validated['name'];
            $partner->keyword = $validated['keyword'];
            $partner->save();

            $department = new Department;
            $department->partner_id = $partner->id;
            $department->name = $validated['department_name'] ?? 'main';
            $department->keyword = $validated['department_keyword'] ?? $partner->keyword;
            $department->is_main = 'yes';
            $department->save();

            if ($request->hasFile('logo')) {
                // FileService::store($request->file('logo'), "partner/{$partner->keyword}/logo", $partner->id, 'partners', 'logo');
            }
        });

        $name = $partner->name;
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
