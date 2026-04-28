<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Level;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
        SchoolClass::create([
            'name' => 'Génie Logiciel - Groupe A',
            'level_id' => Level::first()->id,
            'teacher_id' => Teacher::first()->id,
            'subject_id' => Subject::where('name', 'Informatique')->first()->id,
            'nbr_students' => 10,
        ]);
    }
}
