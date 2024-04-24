<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Partner;
use App\Models\Department;
use App\Traits\DataTableTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    use DataTableTrait;

    public function fields($model = null)
    {
        $type = $model ? 'update' : 'create';

        $fields = [
            'type'            => $type,
            'name'            => old('name') ?? $model->name ?? '',
            'email'           => old('email') ?? $model->email ?? '',
            'username'        => old('username') ?? $model->username ?? Str::random(6),
            'contact_number'  => old('contact_number') ?? $model->contact_number ?? '',
            'partner_id'      => old('partner_id') ?? $model->partner_id ?? '',
            'department_id'   => old('department_id') ?? $model->department_id ?? '',
            'position'        => old('position') ?? $model->position ?? '',
            'role'            => old('role') ?? $model->role ?? '',
            'status'          => old('status') ?? $model->status ?? 'active',
        ];

        return $fields;
    }

    public static function columns()
    {
        return [
            ['title' => 'ชื่อ', 'data' => 'name'],
            ['title' => 'อีเมล', 'data' => 'email'],
            ['title' => 'ชื่อผู้ใช้งาน', 'data' => 'username'],
            ['title' => 'เบอร์ติดต่อ', 'data' => 'contact_number'],
            ['title' => 'Partner', 'data' => 'partner', 'ref' => ['name', 'keyword']],
            ['title' => 'Department', 'data' => 'department', 'ref' => ['name', 'keyword']],
            ['title' => 'ตำแหน่ง', 'data' => 'position'],
            ['title' => 'สิทธิ์', 'data' => 'role'],
            ['title' => 'ข้อมูลจาก', 'data' => 'from'],
            ['title' => 'สถานะ', 'data' => 'status'],
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $query = User::query();
            // $recordsTotal = $query->count();
            // $recordsFiltered = $recordsTotal;

            // if ($request->has('search') && !empty($request->search['value'])) {
            //     $searchValue = $request->search['value'];
            //     $query->where(function ($q) use ($searchValue) {
            //         $q->where('id', '=',  $searchValue);
            //         foreach (self::columns() as $column) {
            //             if (!isset($column['ref'])) {
            //                 $q->orWhere($column['data'], 'like', '%' . $searchValue . '%');
            //             }
            //         }
            //     });

            //     $data = $query->get();

            //     dd($data->slice($offset)->take($limit));
            // }

            $query = User::query();
            $recordsTotal = $query->count();
            $recordsFiltered = $request->length;

            $result = [
                "draw" => $request->draw,
                "recordsTotal" => intval($recordsTotal),
                "recordsFiltered" => intval($recordsFiltered),
            ];

            return json_encode($result);
        }

        return view('manage.users.index')->with([
            'columns' => self::columns()
        ]);
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
            'partner_id' => 'exists:partners,id',
            'department_id' => 'exists:departments,id',
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
            'partner_id' => 'exists:partners,id',
            'department_id' => 'exists:departments,id',
            'position' => 'required|in:admin,leader,staff',
            'role' => 'required|in:admin,moderator,user',
            'status' => 'required|in:active,inactive',
        ]);

        $user->fill($validated);
        $user->updated_by = Auth::id();
        $user->save();

        $name = $user->name;

        return redirect()->route("manage.users.index")
            ->with('success', __('message.updated', ['name' => $name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $data = [
            'name' => $user->name
        ];

        return view('components.views.view', [
            'title' => $user->name
        ])->with(compact('data'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        dd($request->all());
        $name = $user->name;
        $user->update(['status' => 'inactive']);

        return redirect()->route("manage.users.index")->with('success', __('message.disabled', ['name' => $name]));
    }
}
