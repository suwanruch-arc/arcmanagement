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
        'connection',
        'template_type',
        'start_date',
        'end_date',
        'description',
        'owner_id',
        'settings',
        'created_by',
        'updated_by',
    ];

    public function getButton($type)
    {
        $config = json_decode($this->settings);
        if ($type === 'ok') {
            $button = [
                'color' => $config->color->redeem,
                'text' => $config->button->redeem,
            ];
        } else if ($type === 'view') {
            $button = [
                'color' => $config->color->view,
                'text' => $config->button->view,
            ];
        } else if ($type === 'expire') {
            $button = [
                'color' => $config->color->expire,
                'text' => $config->button->expire,
            ];
        } else if ($type === 'already') {
            $button = [
                'color' => $config->color->already,
                'text' => $config->button->already,
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

    public function departments()
    {
        return $this->hasMany(Privilege::class);
    }
}
