<?php

namespace App\Imports;

use App\Mail\SendPasswordToUser;
use App\Models\Inscription;
use App\Models\Student;
use App\Models\Year;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $password = Str::random(8);

        $user = User::create([
            'nom'        => $row['nom'],
            'prenom'     => $row['prenom'],
            'email'      => $row['email'],
            'role'       => 'student',
            'gender'     => $row['gender'],
            'tel'        => $row['tel'] ?? null,
            'password'   => Hash::make($password),
        ]);

        $student = Student::create([
            'user_id' => $user->id,
        ]);

        $year = Year::currentYear();
        if ($year) {
            $inscription = Inscription::create([
                'student_id' => $student->id,
                'year_id'    => $year->id,
                'statut'     => 'active',
            ]);

            $start = Carbon::parse($year->beginning_date);
            $end = Carbon::parse($year->end_date);

            while ($start->lte($end)) {
                $inscription->payments()->create([
                    'mois' => $start->format('Y-m-01'),
                    'etatPaiement' => false,
                ]);
                $start->addMonth();
            }
        }

        Mail::to($user->email)->send(new SendPasswordToUser($user, $password));

        return $student;
    }
}
