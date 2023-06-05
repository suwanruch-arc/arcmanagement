<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'keyword',
        'keyword'
    ];

    public static function list()
    {
        $partner = Partner::all(); // Retrieve all partners

        foreach ($partner as $item) {
            $partnerList[$item->id] = $item->name;
        }

        return $partnerList;
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
