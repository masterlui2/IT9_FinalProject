<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    protected $fillable = [
        'purok',
        'barangay',
        'city',
        'head_name'
    ];

    public function members()
    {
        return $this->hasMany(Resident::class);
    }
}