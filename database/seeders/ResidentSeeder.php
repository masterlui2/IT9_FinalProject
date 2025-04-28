<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;

class ResidentSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Resident::create([
                'full_name' => "Resident $i",
                'gender' => ['Male', 'Female'][rand(0, 1)],
                'birthdate' => now()->subYears(rand(18, 60))->subDays(rand(1, 365)),
                'household_id' => rand(1, 5),
                'relationship' => ['Head', 'Child', 'Parent', 'Sibling'][rand(0, 3)],
                'income_source' => ['Business', 'Employment', 'Freelance', 'None'][rand(0, 3)],
                'contact' => rand(9000000000, 9999999999),
            ]);
        }
    }
}
