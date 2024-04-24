<?php

namespace App\Models;

use App\Models\Partner;
use App\Models\Department;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'contact_number',
        'password',
        'partner_id',
        'department_id',
        'position',
        'role',
        'status',
        'from',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class) ;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
