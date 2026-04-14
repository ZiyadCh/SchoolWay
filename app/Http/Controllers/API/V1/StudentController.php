<?php

namespace App\Http\Controllers\API\V1;

use App\Imports\StudentsImport;
use App\Mail\SendPasswordToUser;
use App\Models\Inscription;
use App\Models\Student;
use App\Models\User;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user','inscriptions.schoolClasses.level'])->paginate(2);
        return response()->json($students);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:10240',
            ]);

            try {
                Excel::import(new StudentsImport(), $request->file('file'));

                return response()->json([
                    'message' => 'Importation groupée réussie !',
                ], 201);

            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Erreur lors de l\'import : ' . $e->getMessage(),
                ], 500);
            }
        } else {
            //////////////////////
            // creates the student first
            $request->validate([
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'email' => 'nullable|email|unique:users,email',
                'gender' => 'required|in:M,F',
                'photo' => 'nullable|string',
                'adress' => 'nullable|string',
                'birthday' => 'nullable|date',
                'birthplace' => 'nullable|string',
                'address' => 'nullable|string',
                'tel' => 'nullable|string|numeric',
            ]);

            $password = Str::random(8);

            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => bcrypt($password),
                'role' => 'student',
                'gender' => $request->gender,
                'photo' => $request->photo,
                'adress' => $request->adress,
                'birthday' => $request->birthday,
                'birthplace' => $request->birthplace,
                'address' => $request->address,
                'tel' => $request->tel,
            ]);


            // getting current active year
            $year = Year::currentYear();

            $student = Student::create([
                'user_id' => $user->id,
            ]);

            //////////////////////
            //create the inscription
            $inscription = Inscription::create([
                'student_id' => $student->id,
                'year_id' => $year->id,
                'statut' => 'active',
            ]);

            //////////////////////
            //create the paiment months rows based on the months decalred in the acedemic year
            $start = Carbon::parse($year->beginning_date);
            $end = Carbon::parse($year->end_date);

            while ($start->lte($end)) {
                $inscription->payments()->create([
                    'mois' => $start->translatedFormat('F Y'),
                    'etatPaiement' => false,
                ]);
                $start->addMonth();
            }


            $message = "Etudiant ajoute avec success, l'etudian doit recevoir une notification par email";
            if (!$year) {
                $message = "aucune annes courante!";
            }

            //////////////////////
            //sending the mail
            Mail::to($user->email)->send(new SendPasswordToUser($user, $password));


        }
        return response()->json([
            'message' => $message,
            'data' => $student->load('user'),
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json($student->load('user'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $request->validate([
            'nom' => 'string',
            'prenom' => 'string',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:6',
            'gender' => 'in:M,F',
            'photo' => 'nullable|string',
            'adress' => 'nullable|string',
            'birthday' => 'nullable|date',
            'birthplace' => 'nullable|string',
            'tel' => 'nullable|string|numeric',
        ]);

        $student->user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'gender' => $request->gender,
            'photo' => $request->photo,
            'adress' => $request->adress,
            'birthday' => $request->birthday,
            'birthplace' => $request->birthplace,
            'tel' => $request->tel,
            'password' => $request->password
                ? bcrypt($request->password)
                : $student->user->password,
        ]);

        $student->update([
            'note_final' => $request->note_final,
        ]);

        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $student->load('user'),
        ]);
    }

    public function destroy(Student $student)
    {
        $student->user()->delete();
        $student->delete();

        return response()->json([
            'message' => 'Etudiant supprime avec succes',
        ], 200);
    }
}
