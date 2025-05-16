<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialStat extends Model
{
    use HasFactory;

    protected $fillable = ['count', 'occupied_percentage', 'vacant_percentage'];
}