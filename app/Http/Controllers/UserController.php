<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Partner;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function fields($model = null)
    {
        $type = $model ? 'update' : 'create';
        $fields = [
            'type'            => $type,
            'name'            => old('name') ?? ($model ? $model->name : ''),
            'email'           => old('email') ?? ($model ? $model->email : ''),
            'username'        => old('username') ?? ($model ? $model->username : Str::random(6)),
            'contact_number'  => old('contact_number') ?? ($model ? $model->contact_number : ''),
            'partner_id'      => old('partner_id') ?? ($model ? $model->partner_id : ''),
            'department_id'   => old('department_id') ?? ($model ? $model->department_id : ''),
            'position'        => old('position') ?? ($model ? $model->position : ''),
            'role'            => old('role') ?? ($model ? $model->role : ''),
            'status'          => old('status') ?? ($model ? $model->status : 'active'),
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
        $users = User::all();

        return view('manage.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('components.views.create', [
            'title' => 'User',
            'route' => 'manage.users',
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
            'email' => 'required|max:255',
            'username' => 'required|unique:users|max:255',
            'contact_number' => 'required|max:255',
            'password' => 'required|min:6|max:16',
            'partner_id' => 'required|exists:partners,id',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|in:admin,leader,staff',
            'role' => 'required|in:admin,moderator,user',
            'status' => 'required|in:active,inactive',
        ]);
        $user = new User;
        $user->fill($validated);
        $user->password = Hash::make($request->password);
        $user->from = 'ecp';
        $user->remember_token = Str::random(10);
        $user->created_by = Auth::id();
        $user->updated_by = Auth::id();
        $user->save();

        $name = $user->name;

        return redirect()->route('manage.users.index')
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
    public function edit(User $user)
    {
        return view('components.views.update', [
            'title' => $user->name,
            'route' => 'manage.users',
            'params' => ['user' => $user],
            'fields' => $this->fields($user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'contact_number' => 'required|max:255',
            'partner_id' => 'required|exists:partners,id',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|in:admin,leader,staff',
            'role' => 'required|in:admin,moderator,user',
            'status' => 'required|in:active,inactive',
        ]);

        $user->fill($validated);
        $user->from = 'ecp';
        $user->updated_by = Auth::id();
        $user->save();

        $name = $user->name;

        return redirect()->route("manage.users.index")
            ->with('success', __('message.updated', ['name' => $name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        return redirect()->route("manage.users.index")->with('success', __('message.deleted', ['name' => $name]));
    }
}
