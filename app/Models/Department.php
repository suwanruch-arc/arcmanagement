<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'partner_id',
        'name',
        'keyword',
        'file_id',
        'logo_width',
        'status'
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function getFilePath()
    {
        $file = $this->file;
        if ($file) {
            return Storage::disk('public')->url($file->path . '/' . $file->file_name);
        }
    }
}
