<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nom' => 'Admin',
            'prenom' => 'System',
            'email' => 'admin@schoolway.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'gender' => 'M',
        ]);

        Year::create([
            'title' => '2025-2026',
            'beginning_date' => '2025-09-01',
            'end_date' => '2026-06-30',
            'current' => true,
        ]);

        $this->call([
            LevelSeeder::class,
            SubjectSeeder::class,
            YearSeeder::class,
            TeacherSeeder::class,
            SchoolClassSeeder::class,
            StudentSeeder::class,
            ExamSeeder::class,
            AbsenceSeeder::class,
            DevoirSeeder::class,
        ]);
    }
}
