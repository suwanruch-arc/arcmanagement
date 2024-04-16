<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecode extends Model
{
    use HasFactory;

    protected $table = 'warehouse_ecode';

    protected $fillable = [
        'date_lot',
        'number_lot',
        'type',
        'code',
        'value',
        'unique',
        'path',
        'full_path',
        'expire_date',
        'description',
        'owner_id',
        'shop_id',
        'created_by',
        'updated_by',
    ];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
    public function owner(){
        return $this->belongsTo(Department::class);
    }
}
