<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function getImage($partner)
    {
        $partner = Str::lower($partner);
        $path = public_path("imgs/logo/{$partner}.png");
        return Response::download($path);
    }
}
