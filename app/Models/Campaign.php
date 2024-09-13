<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'table_name',
        'name',
        'keyword',
        'connection',
        'template_type',
        'start_date',
        'end_date',
        'description',
        'owner_id',
        'settings',
    ];
}
