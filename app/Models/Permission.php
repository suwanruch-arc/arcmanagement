<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'menu_name'];

    // Define relationships if necessary
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
