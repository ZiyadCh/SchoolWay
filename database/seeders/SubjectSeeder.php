<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mathématiques' ],
            ['name' => 'Physique-Chimie' ],
            ['name' => 'Informatique' ],
            ['name' => 'Français' ],
        ];
        foreach ($subjects as $subject) {
            Subject::firstOrCreate(['name' => $subject['name']], $subject);
        }
    }
}
