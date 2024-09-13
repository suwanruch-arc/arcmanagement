<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Shop extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'name',
        'keyword',
        'tandc',
    ];

    public function template()
    {
        return $this->belongsTo(File::class, 'template_id');
    }

    public function banner()
    {
        return $this->belongsTo(File::class, 'banner_id');
    }

    public function getTemplateFilePath()
    {
        $file = $this->template;
        if ($file) {
            return Storage::disk('public')->url($file->path . '/' . $file->file_name);
        }
    }

    public function getBannerFilePath()
    {
        $file = $this->banner;
        if ($file) {
            return Storage::disk('public')->url($file->path . '/' . $file->file_name);
        }
    }
}
