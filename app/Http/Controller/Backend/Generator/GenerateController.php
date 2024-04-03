<?php

namespace App\Http\Controllers\Backend\Generator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenerateController extends Controller
{
    public function index()
    {
        return view('backend.generator.index');
    }
}
