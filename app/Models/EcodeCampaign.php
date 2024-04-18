<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcodeCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'created_by',
        'updated_by',
    ];
    public function owner()
    {
        return $this->belongsTo(Department::class);
    }
}
