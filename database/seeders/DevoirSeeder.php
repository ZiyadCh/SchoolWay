<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DevoirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Devoir::create([
            'school_class_id' => \App\Models\SchoolClass::first()->id,
            'title' => 'TP Laravel Migrations',
            'contenu' => 'Créer les seeders pour le projet SchoolWay.',
            'deadline' => now()->addDays(5),
        ]);
    }
}
