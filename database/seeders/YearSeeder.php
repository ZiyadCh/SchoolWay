<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    public function run(): void
    {
        Year::firstOrCreate(
            ['title' => '2025-2026'],
            [
                'beginning_date' => '2025-09-01',
                'end_date' => '2026-06-30',
                'current' => true,
            ]
        );
    }
}
