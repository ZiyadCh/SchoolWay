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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        //for the count
        if ($request->has('count')) {
            return response()->json([
                'total_students' => Student::count(),
            ]);
        }
        //for the filterign
        $query = Student::with(['user', 'inscriptions.schoolClasses.level']);


        if ($request->has('search')) {
            $search = $request->input('search');

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%")
                  ->orWhere('prenom', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('level_id')) {
            $levelId = $request->input('level_id');

            $query->whereHas('inscriptions.schoolClasses', function ($q) use ($levelId) {
                $q->where('level_id', $levelId);
            });
        }

        $students = $query->latest()->paginate(5);

        return response()->json($students);
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            if ($request->hasFile('file')) {
                $request->validate([
                    'file' => 'required|mimes:xlsx,xls,csv',
                ]);

                try {
                    Excel::import(new StudentsImport(), $request->file('file'));

                    return response()->json([
                        'message' => 'Importation groupée réussie !',
                    ], 201);

                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Erreur lors de l\'import : ' . $e,
                    ], 500);
                }
            }

            $request->validate([
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'email' => 'nullable|email|unique:users,email',
                'gender' => 'required|in:M,F',
                'photo' => 'nullable|image',
                'adress' => 'nullable|string',
                'birthday' => 'nullable|date',
                'birthplace' => 'nullable|string',
                'address' => 'nullable|string',
                'tel' => 'nullable|string|numeric',
            ]);
            //for the image
            $path = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('students', 'public');
            }

            //password genration
            $password = Str::random(8);

            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => bcrypt($password),
                'role' => 'student',
                'gender' => $request->gender,
                'photo' => $path,
                'adress' => $request->adress,
                'birthday' => $request->birthday,
                'birthplace' => $request->birthplace,
                'address' => $request->address,
                'tel' => $request->tel,
            ]);

            $year = Year::currentYear();

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

            $message = "Etudiant ajoute avec success, l'etudian doit recevoir une notification par email";

            if (!$year) {
                $message = "aucune annes courante!";
            }

            Mail::to($user->email)->send(new SendPasswordToUser($user, $password));

            return response()->json([
                'message' => $message,
                'data' => $student->load('user'),
            ], 201);
        });
    }

    public function show(Student $student)
    {
        return response()->json($student->load(['user','classes']));
    }

    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $request->validate([
            'nom' => 'nullable|string',
            'prenom' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $student->user->id,
            'password' => 'nullable|min:6',
            'gender' => 'in:M,F',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'adress' => 'nullable|string',
            'birthday' => 'nullable|date',
            'birthplace' => 'nullable|string',
            'tel' => 'nullable|string',
        ]);

        $photoPath = $student->user->photo;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('students', 'public');
        }

        $student->user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'gender' => $request->gender,
            'photo' => $photoPath,
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
