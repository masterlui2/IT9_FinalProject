<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'population', 'male_percentage', 'female_percentage',
        'residential', 'occupied_percentage', 'vacant_percentage',
        'commercial', 'active_percentage', 'inactive_percentage',
        'incidents', 'closed_percentage', 'open_percentage'
    ];
}