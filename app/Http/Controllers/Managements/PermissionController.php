<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use App\Traits\Search;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use Search;
    public function index()
    {
        $users = User::all()->pluck('name','id');
        $partners = Partner::all();

        return view('manage.permission.index', [
            'users' => $users,
            'partners' => $partners,
        ]);
    }

    public function getUser(Request $request)
    {
        $query = User::query();
        $query = Search::getData($query, [
            ['field' => 'name'],
        ]);
        $users = $query->paginate(10);

        return view('manage.permission.user-list',[
            'users' => $users
        ]);
    }
}
