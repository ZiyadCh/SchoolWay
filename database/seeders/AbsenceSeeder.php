<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Absence::create([
            'inscription_id' => \App\Models\Inscription::first()->id,
            'date' => now()->subDays(2),
            'justifié' => false,
        ]);
    }
}
