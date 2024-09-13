<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        $query = Partner::query()->withTrashed();
        $partners = $query->orderBy('name')->paginate(25);

        return view('manage.partners.index', compact('partners'));
    }
    
    public function create(): View
    {
        $this->authorize('create');

        return view('manage.partners._form', [
            'model' => null
        ]);
    }
    
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create');

        $validated = $request->validate([
            'partner_name' => 'required|max:255|unique:partners,name',
            'department_name' => 'nullable|max:255',
            'department_keyword' => 'nullable|min:3|max:10|unique:departments,keyword',
        ]);

        $partner = new Partner;
        $partner->name = $validated['partner_name'];
        $partner->save();

        if ($partner) {
            $department = new Department;
            $department->partner_id = $partner->id;
            $department->name = $validated['department_name'];
            $department->keyword = Str::upper($validated['department_keyword']);
            $department->is_main = 'yes';
            $department->logo_width = 35;
            $department->save();
        }

        return redirect()->route("manage.partners.index")
            ->with('success', __('message.created', ['name' => $partner->name]));
    }
    
    public function show($id)
    {
        //
    }
    
    public function edit(Partner $partner): View
    {
        $this->authorize('update', $partner);

        return view('manage.partners._form', [
            'model' => $partner
        ]);
    }
    
    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $this->authorize('update', $partner);

        $validated = $request->validate([
            'partner_name' => 'required|max:255|unique:partners,name,' . $partner->id,
        ]);

        $partner->name = $validated['partner_name'];
        $partner->save();

        return redirect()->route("manage.partners.index")
            ->with('success', __('message.updated', ['name' => $partner->name]));
    }
    
    public function destroy(Partner $partner): RedirectResponse
    {
        $this->authorize('delete', $partner);

        $departments = $partner->departments();
        $departments->update(['status' => 'inactive']);
        $departments->delete();

        $partner->save();
        $partner->delete();

        return redirect()->to(url()->previous())
            ->with('success', __('message.deleted', ['name' => $partner->name]));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        $partner = Partner::onlyTrashed()->find($id);
        if ($partner) {

            if ($partner->trashed()) {
                $partner->restore();
            }
            
            return redirect()->to(url()->previous())
                ->with('success', __('message.restored', ['name' => $partner->name]));
        }

        return redirect()->to(url()->previous())
            ->with('error', __('message.update_failed'));
    }
}
