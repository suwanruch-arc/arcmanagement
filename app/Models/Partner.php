<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;


    public static function list()
    {
        $partner = Partner::all(); // Retrieve all users

        foreach ($partner as $item) {
            $partnerList[$item->id] = $item->name;
        }

        return $partnerList;
    }
}
