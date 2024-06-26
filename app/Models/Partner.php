<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
