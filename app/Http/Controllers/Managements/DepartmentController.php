<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Partner;
use App\Providers\FileServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Partner $partner): View
    {
        $this->authorize('create');

        return view('manage.departments._form', [
            'partner' => $partner,
            'model' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Partner $partner): RedirectResponse
    {
        $this->authorize('create');

        $validated = $request->validate([
            'name' => 'required|max:255',
            'keyword' => 'required|max:10|unique:departments,keyword',
            'logo_file' => 'nullable|image',
            'logo_width' => 'nullable'
        ]);

        $department = new Department;
        $department->fill($validated);
        $department->keyword = Str::upper($department->keyword);
        $department->partner_id = $partner->id;
        $department->is_main = 'no';
        $department->save();

        if ($request->hasFile('logo_file')) {
            $path = "departments/{$department->keyword}";
            $file = FileServiceProvider::store($path, $department, 'logo_file');
            $department->file_id = $file->id;
            $department->save();
        }


        return redirect()->route("manage.partners.index")
            ->with('success', __('message.created', ['name' => $department->name]));
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
    public function edit(Partner $partner, Department $department): View
    {
        $this->authorize('update', $department);

        return view('manage.departments._form', [
            'partner' => $partner,
            'model' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner, Department $department): RedirectResponse
    {
        $this->authorize('update', $department);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'keyword' => 'required|max:10|unique:departments,keyword,' . $department->id,
            'logo_file' => 'nullable|image',
            'logo_width' => 'nullable'
        ]);
        $department->fill($validated);
        $department->save();

        if ($request->hasFile('logo_file')) {
            $path = "departments/{$department->keyword}";
            $file = FileServiceProvider::store($path, $department, 'logo_file');
            $department->file_id = $file->id;
            $department->save();
        }

        return redirect()->route("manage.partners.index")
            ->with('success', __('message.updated', ['name' => $department->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner, Department $department): RedirectResponse
    {
        $this->authorize('delete', $department);

        $department->status = 'inactive';
        $department->save();
        $department->delete();

        return redirect()->to(url()->previous())
            ->with('success', __('message.deleted', ['name' => $department->name]));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        $department = Department::onlyTrashed()->find($id);
        if ($department) {
            $partner = $department->partner()->withTrashed()->first();
            if ($partner && $partner->trashed()) {
                $partner->restore();
            }

            if ($department->trashed()) {
                $department->restore();
            }
            Department::where('id', $id)->update(['status' => 'active']);

            return redirect()->to(url()->previous())
                ->with('success', __('message.restored', ['name' => $department->name]));
        }

        return redirect()->to(url()->previous())
            ->with('error', __('message.update_failed'));
    }
}
