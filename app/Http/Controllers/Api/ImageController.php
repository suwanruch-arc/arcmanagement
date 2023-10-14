<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Image;

class ImageController extends Controller
{
    public function getPartner($partner)
    {
        $partner = Str::lower($partner);
        $department = Department::where('keyword', $partner)->value('id');
        $res = Image::get($department, 'departments', 'logo') ?? "https://a.yllo.in/assets/img/logo/{$partner}.png?" . time();
        return  response()->json($res, 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
