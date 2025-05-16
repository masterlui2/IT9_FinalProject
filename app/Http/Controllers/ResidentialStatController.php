<?php

namespace App\Http\Controllers;

use App\Models\ResidentialStat;
use Illuminate\Http\Request;

class ResidentialStatController extends Controller
{
    public function getStats()
    {
        return ResidentialStat::first();
    }

    public function incrementStats()
    {
        $stats = ResidentialStat::first();
        
        // Increment count
        $stats->count++;
        
        // Randomize percentages (65-75% occupied)
        $stats->occupied_percentage = min(95, max(65, 70 + rand(-5, 5)));
        $stats->vacant_percentage = 100 - $stats->occupied_percentage;
        
        $stats->save();
        
        return $stats;
    }
}