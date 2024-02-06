<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'shop_id',
        'title',
        'keyword',
        'description',
        'value',
        'lot',
        'start_date',
        'end_date',
        'has_timer',
        'timer_value',
        'can_view',
        'default_code',
        'has_detail',
        'detail',
        'tandc',
        'setting',
        'status',
        'created_by',
        'updated_by',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
