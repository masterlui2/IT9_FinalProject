<?php

namespace Database\Seeders;

use App\Models\Household;
use Illuminate\Database\Seeder;

class HouseholdSeeder extends Seeder
{
    public function run()
    {
        $households = [
            ['purok' => 'Purok 1', 'address' => '123 Main St', 'household_number' => 'HH-001'],
            ['purok' => 'Purok 2', 'address' => '456 Oak Ave', 'household_number' => 'HH-002'],
            ['purok' => 'Purok 3', 'address' => '789 Pine Rd', 'household_number' => 'HH-003'],
        ];

        foreach ($households as $household) {
            Household::create($household);
        }
    }
}