<?php

namespace App\Imports;

use App\Mail\SendPasswordToUser;
use App\Models\User;
use App\Models\Student;
use App\Models\Year;
use App\Models\Inscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, WithSkipDuplicates
{
    use SkipsFailures;

    public function rules(): array
    {
        return [
            'nom'    => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email',
            'gender' => 'required|in:Masculin,Féminin,M,F',
            'tel'    => 'nullable|numeric',
        ];
    }

    public function model(array $row)
    {
        $year = Year::currentYear();
        if (!$year) {
            throw new \Exception("Aucune année scolaire active n'a été trouvée.");
        }

        return DB::transaction(function () use ($row, $year) {
            $password = Str::random(8);

            $user = User::create([
                'nom'      => $row['nom'],
                'prenom'   => $row['prenom'],
                'email'    => $row['email'],
                'role'     => 'student',
                'gender'   => $row['gender'],
                'tel'      => $row['tel'] ?? null,
                'password' => Hash::make($password),
            ]);

            $student = Student::create([
                'user_id' => $user->id,
            ]);

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

            Mail::to($user->email)->send(new SendPasswordToUser($user, $password));

            return $student;
        });
    }
}
