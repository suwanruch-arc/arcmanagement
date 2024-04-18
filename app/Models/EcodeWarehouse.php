<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcodeWarehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_lot',
        'number_lot',
        'type',
        'code',
        'value',
        'unique',
        'file_name',
        'path',
        'expire_date',
        'description',
        'shop_id',
        'campaign_id',
        'import_by',
    ];
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
