<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Partner;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\User;
use App\Traits\Search;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    use Search;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $query = User::query()->withTrashed();
        $query = Search::getData($query, [
            ['field' => 'name'],
            ['field' => 'email'],
            ['field' => 'username'],
            ['field' => 'contact_number'],
            ['field' => 'position'],
            ['field' => 'role'],
            ['field' => 'name', 'ref' => 'partner'],
            ['field' => ['name', 'keyword'], 'ref' => 'department']
        ]);

        $users = $query->orderByRaw("id = ? DESC", [auth()->user()->id])->orderBy('status')->orderByDesc('created_at')->paginate(25);

        return view('manage.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $this->authorize('create');

        $partners = Partner::with([
            'departments' => function ($query) {
                $query->where('status', 'active');
            }
        ])->get();

        $partner_lists = $partners->mapWithKeys(function ($partner) {
            $departments = $partner->departments->mapWithKeys(function ($department) {
                return [$department->id => $department->name];
            });

            return [$partner->name => $departments];
        })->toArray();

        return view('manage.users._form', [
            'model' => null,
            'partner_lists' => $partner_lists
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'username' => 'required|unique:users|min:8|max:255',
            'contact_number' => 'required|max:255',
            'password' => 'required|min:6|max:16',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|in:admin,leader,employee',
            'role' => 'required|in:admin,moderator,user'
        ]);

        $user = new User;
        $user->fill($validated);
        $user->password = Hash::make($request->password);
        $user->from = 'ecp';
        $user->remember_token = Str::random(10);
        $department = Department::find($validated['department_id']);
        $user->partner_id = $department->partner_id;
        $user->department_id = $department->id;
        $user->save();

        return redirect()->route('manage.users.index')
            ->with('success', __('message.created', ['name' => $user->name]));
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
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        $partners = Partner::with([
            'departments' => function ($query) {
                $query->where('status', 'active');
            }
        ])->get();

        $partner_lists = $partners->mapWithKeys(function ($partner) {
            $departments = $partner->departments->mapWithKeys(function ($department) {
                return [$department->id => $department->name];
            });

            return [$partner->name => $departments];
        })->toArray();

        return view('manage.users._form', [
            'model' => $user,
            'partner_lists' => $partner_lists
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'contact_number' => 'required|max:255',
            'department_id' => 'exists:departments,id',
            'position' => 'required|in:admin,leader,employee',
            'role' => 'required|in:admin,moderator,user'
        ]);

        $user->fill($validated);
        $department = Department::find($validated['department_id']);
        $user->partner_id = $department->partner_id;
        $user->department_id = $department->id;
        $user->save();

        return redirect()->route('manage.users.index')
            ->with('success', __('message.updated', ['name' => $user->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->status = 'inactive';
        $user->save();
        $user->delete();

        return redirect()->to(url()->previous())
            ->with('success', __('message.deleted', ['name' => $user->name]));
    }

    public function restore(Request $request)
    {
        $id = $request->id;
        $user = User::onlyTrashed()->find($id);
        if ($user) {
            if ($user->trashed()) {
                $user->restore();
            }
            User::where('id', $id)->update(['status' => 'active']);

            return redirect()->to(url()->previous())
                ->with('success', __('message.restored', ['name' => $user->name]));
        }

        return redirect()->to(url()->previous())
            ->with('error', __('message.update_failed'));
    }

    public function resetPassword(Request $request)
    {
        $user = User::find($request->id);
        $user->password = Hash::make('P@ssw0rd');
        $user->save();

        return redirect()->to(url()->previous())
            ->with('success', __('message.reset-password', ['name' => $user->name]));
    }
}
