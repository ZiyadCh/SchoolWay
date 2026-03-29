<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Inscription;
use App\Models\Student;
use App\Models\User;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {

        //////////////////////
        // creates the student first
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6',
            'gender' => 'required|in:M,F',
            'photo' => 'nullable|string',
            'adress' => 'nullable|string',
            'birthday' => 'nullable|date',
            'birthplace' => 'nullable|string',
            'address' => 'nullable|string',
            'tel' => 'nullable|string',
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


        // declaring current active year
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
            $inscription->paiments()->create([
                'mois' => $start->translatedFormat('F Y'),
                'etatPayement' => false,
            ]);
            $start->addMonth();
        }

        return response()->json([
            'message' => 'Etudiant ajoute avec succes',
            'data' => $student->load('user'),
        ], 201);
    }

    public function show($id)
    {
        $student = Student::with('user')->findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:6',
            'gender' => 'required|in:M,F',
            'photo' => 'nullable|string',
            'adress' => 'nullable|string',
            'birthday' => 'nullable|date',
            'birthplace' => 'nullable|string',
            'tel' => 'nullable|integer',
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

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->user()->delete();
        $student->delete();

        return response()->json([
            'message' => 'Etudiant supprime avec succes',
        ]);
    }
}
