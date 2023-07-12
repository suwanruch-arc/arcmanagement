<?php

namespace App\Models;

use App\Models\ReportSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'connection',
        'type_query',
        'name',
        'description',
        'sql',
        'from',
        'where',
        'created_by',
        'updated_by',
    ];

    public function settings()
    {
        return $this->hasMany(ReportSetting::class);
    }

    public function assign_lists()
    {
        return $this->hasMany(UserReport::class);
    }
}
