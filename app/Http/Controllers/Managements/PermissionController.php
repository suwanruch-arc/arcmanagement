<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('name')->get();

        return view('manage.permission.index', [
            'partners' => $partners,
        ]);
    }

    public function getUsers(Request $request, $department)
    {
        $user_query = User::query();

        if ($department !== 'all') {
            $user_query->where('department_id', $department);
        }

        $users = $user_query->where('role', '!=', 'admin')->orderBy('name')->get(['id', 'name', 'department_id']);

        return response()->json($users);
    }

    public function getPermission(Request $request, $menu)
    {
        $permissions = Permission::where('menu_name', $menu)->with(['user:id,name,department_id'])->get();

        return response()->json($permissions);
    }

    public function saveUsers(Request $request, $menu)
    {
        Permission::where(['menu_name' => $menu])->delete();

        if ($request->user_id) {
            foreach ($request->user_id as $user_id) {
                $permission = new Permission;
                $permission->user_id = $user_id;
                $permission->menu_name = $menu;
                $permission->assigned_by = auth()->id();
                $permission->save();
            }
        }

        return response()->json(['message' => 'Permissions saved successfully'], 200);
    }
}
