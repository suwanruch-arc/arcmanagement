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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function isAdmin()
    {
        // Implement your logic to determine if the user is an admin
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
