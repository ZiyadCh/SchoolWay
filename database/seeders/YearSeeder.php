<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Year::create([
            'year' => '2024-2025',
            'beginning_date' => Carbon::create(2024, 9, 1),
            'end_date' => Carbon::create(2025, 6, 30),
            'statut' => 'active',
        ]);

        Year::create([
            'year' => '2023-2024',
            'beginning_date' => Carbon::create(2023, 9, 1),
            'end_date' => Carbon::create(2024, 6, 30),
            'statut' => 'inactive',
        ]);

        Year::create([
            'year' => '2025-2026',
            'beginning_date' => Carbon::create(2025, 9, 1),
            'end_date' => Carbon::create(2026, 6, 30),
            'statut' => 'inactive',
        ]);
    }
}
