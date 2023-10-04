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
        'title_alert',
        'desc_alert',
        'main_color',
        'secondary_color',
        'redeem_color',
        'redeem_btn',
        'view_color',
        'view_btn',
        'expire_color',
        'expire_btn',
        'already_color',
        'already_btn',
    ];

    public function getButton($type)
    {
        if ($type === 'ok') {
            $button = [
                'color' => $this->redeem_color,
                'text' => $this->redeem_btn,
            ];
        } else if ($type === 'view') {
            $button = [
                'color' => $this->view_color,
                'text' => $this->view_btn,
            ];
        } else if ($type === 'expire') {
            $button = [
                'color' => $this->expire_color,
                'text' => $this->expire_btn,
            ];
        } else if ($type === 'already') {
            $button = [
                'color' => $this->already_color,
                'text' => $this->already_btn,
            ];
        }

        return $button;
    }

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
