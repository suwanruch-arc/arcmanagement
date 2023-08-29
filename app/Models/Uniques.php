<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uniques extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'refid',
        'lot',
        'register_date',
        'first_view_date',
        'redeem_date',
        'expire_date',
        'campaign_keyword',
        'privilege_keyword',
        'shop_keyword',
        'owner_keyword',
        'short_unique',
        'full_unique',
        'msisdn',
        'code',
        'info',
        'flag',
        'is_use',
        'campaign_id',
        'privilege_id',
        'shop_id',
        'owner_id',
    ];
}
