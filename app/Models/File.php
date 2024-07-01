<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file_name',
        'origin_name',
        'extension',
        'path',
        'size',
        'table_id',
        'table_name',
        'type',
        'status',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
