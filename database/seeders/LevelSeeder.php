<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = ['Tronc Commun', '1ère Année Bac', '2ème Année Bac'];
        foreach ($levels as $level) {
            Level::firstOrCreate(['name' => $level]);
        }
    }
}
