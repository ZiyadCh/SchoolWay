<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mathématiques', 'coefficient' => 7],
            ['name' => 'Physique-Chimie', 'coefficient' => 5],
            ['name' => 'Informatique', 'coefficient' => 2],
            ['name' => 'Français', 'coefficient' => 4],
        ];
        foreach ($subjects as $subject) {
            Subject::firstOrCreate(['name' => $subject['name']], $subject);
        }
    }
}
