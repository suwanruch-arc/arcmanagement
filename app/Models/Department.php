<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'name',
        'keyword',
        'status'
    ];

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

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class,'owner_id');
    }
}
