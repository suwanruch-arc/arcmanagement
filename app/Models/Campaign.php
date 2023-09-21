<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_name',
        'name',
        'keyword',
        'template_type',
        'start_date',
        'end_date',
        'description',
        'owner_id',
        'created_by',
        'updated_by',
    ];

    public function owner()
    {
        return $this->belongsTo(Department::class);
    }

    public function uniques()
    {
        return $this->belongsTo(Uniques::class);
    }

    public function assign_lists()
    {
        return $this->hasMany(CampaignUser::class);
    }

    public function privileges()
    {
        return $this->hasMany(Privilege::class);
    }

}
