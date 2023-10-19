<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function getListParent(string $name)
    {
        switch ($name) {
            case 'users':
                # code...
                break;

            default:
                # code...
                break;
        }
    }

    public function detail()
    {
    }
    public function disable(Request $request)
    {
        dd($request->all());
    }
    public function reactive(Request $request)
    {
        dd($request->all());
    }
}
