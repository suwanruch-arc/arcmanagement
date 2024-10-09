<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function departments_with_trashed()
    {
        return $this->hasMany(Department::class)->withTrashed();
    }

    public function departments()
    {
        return $this->hasMany(Department::class)->orderBy('name');
    }

    public function users()
    {
        return $this->hasMany(User::class)->orderBy('name');
    }
}
