<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Partner;
use App\Models\Department;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Searchable, CreatedUpdatedBy;

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
    ];

    protected $attributes = [
        'status' => 'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ตรวจสอบว่าผู้ใช้งานเป็นผู้ดูแลระบบหรือไม่
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * กำหนดความสัมพันธ์กับตาราง Partner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * กำหนดความสัมพันธ์กับตาราง Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
