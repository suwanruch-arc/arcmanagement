<?php

namespace App\Http\Controllers\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MapLinkController extends Controller
{
    public function index()
    {
        return view('manage.map-link.index');
    }
}
