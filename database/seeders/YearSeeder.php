<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            [
                'title'          => '2023-2024',
                'beginning_date' => '2023-09-01',
                'end_date'       => '2024-06-30',
                'current'        => false,
                'selected'       => false,
            ],
            [
                'title'          => '2025-2026',
                'beginning_date' => '2025-09-01',
                'end_date'       => '2026-06-30',
                'current'        => true,
                'selected'       => true,
            ],
        ];

        foreach ($years as $year) {
            Year::firstOrCreate(
                ['title' => $year['title']],
                $year
            );
        }
    }
}
