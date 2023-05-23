<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public static function list()
    {
        $department = Department::all(); // Retrieve all users

        foreach ($department as $item) {
            $departmentList[$item->partner->name][$item->id] = $item->name;
        }

        return $departmentList;
    }
}
