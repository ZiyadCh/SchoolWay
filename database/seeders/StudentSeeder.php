<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Year;
use App\Models\Inscription;
use App\Models\SchoolClass;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $year = Year::firstOrCreate(
            ['title' => '2025-2026'],
            [
                'beginning_date' => '2025-09-01',
                'end_date' => '2026-06-30',
                'current' => true,
            ]
        );

        $class = SchoolClass::first();

        User::factory(30)
            ->create([
                'role' => 'student',
                'password' => Hash::make('password'),
            ])
            ->each(function ($user) use ($year, $class) {
                // 1. Créer le profil Student
                $student = Student::create([
                    'user_id' => $user->id,
                ]);

                $inscription = Inscription::create([
                    'student_id' => $student->id,
                    'year_id' => $year->id,
                    'school_class_id' => $class ? $class->id : null,
                    'statut' => 'active',
                ]);

                $start = Carbon::parse($year->beginning_date);
                $end = Carbon::parse($year->end_date);
                $paymentsData = [];

                while ($start->lte($end)) {
                    $paymentsData[] = [
                        'inscription_id' => $inscription->id,
                        'mois' => $start->format('Y-m-01'),
                        'etatPaiement' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $start->addMonth();
                }

                $inscription->payments()->insert($paymentsData);
            });

        $this->command->info("Succès : 30 étudiants avec des noms réels et leurs paiements ont été créés.");
    }
}
