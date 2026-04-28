<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Year;
use App\Models\Inscription;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        $studentsCount = 10;

        for ($i = 1; $i <= $studentsCount; $i++) {
            $user = User::create([
                'nom' => "Nom$i",
                'prenom' => "Prenom$i",
                'email' => "student$i@schoolway.com",
                'password' => Hash::make('password'),
                'role' => 'student',
                'gender' => $i % 2 == 0 ? 'M' : 'F',
                'photo' => null,
                'adress' => "$i Rue des Écoles, Casablanca",
                'birthday' => now()->subYears(15)->format('Y-m-d'),
                'birthplace' => 'Casablanca',
                'tel' => '061234567' . $i,
            ]);

            $student = Student::create([
                'user_id' => $user->id,
            ]);

            $inscription = Inscription::create([
                'student_id' => $student->id,
                'year_id' => $year->id,
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
        }

        $this->command->info("Succès : $studentsCount étudiants et leurs échéanciers ont été créés.");
    }
}
