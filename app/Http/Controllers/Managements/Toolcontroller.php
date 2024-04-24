<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Toolcontroller extends Controller
{
    public function dashboard(Request $request)
    {
        // if ($request->ajax()) {
        //     $draw = $request->draw;
        //     $start = $request->start;
        //     $length = $request->length;
        //     $data = User::select('name', 'email')->offset($start)->limit($length)->get()->toArray();

        //     return ["data" => $data];
        // }

        return view('manage.tools.index')->with([
            'columns' => [
                ['label' => 'ชื่อ', 'field' => 'name']
            ]
        ]);
    }

    public function upload()
    {
        return view('manage.tools.upload');
    }
}
