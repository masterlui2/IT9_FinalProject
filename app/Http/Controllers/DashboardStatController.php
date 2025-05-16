<?php

namespace App\Http\Controllers;

use App\Models\DashboardStat;
use Illuminate\Http\Request;

class DashboardStatController extends Controller
{
    public function getStats()
    {
        // Get or create the stats record
        $stats = DashboardStat::firstOrCreate([], [
            'population' => 11200,
            'male_percentage' => 58,
            'female_percentage' => 42,
            'residential' => 2240,
            'occupied_percentage' => 70,
            'vacant_percentage' => 30,
            'commercial' => 3424,
            'active_percentage' => 93,
            'inactive_percentage' => 7,
            'incidents' => 97,
            'closed_percentage' => 92,
            'open_percentage' => 8
        ]);

        return response()->json($stats);
    }

    public function incrementResidential()
    {
        $stats = DashboardStat::first();
        
        if (!$stats) {
            return response()->json(['error' => 'No stats record found'], 404);
        }

        // Increment residential count
        $stats->residential++;
        
        // Randomize percentages (65-75% occupied)
        $stats->occupied_percentage = min(95, max(65, 70 + rand(-5, 5)));
        $stats->vacant_percentage = 100 - $stats->occupied_percentage;
        
        $stats->save();
        
        return response()->json($stats);
    }
}