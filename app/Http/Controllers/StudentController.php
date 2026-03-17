<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function profile()
    {
        $student = Student::where('user_id', auth()->id())->firstOrFail();
        return view('students.profile', compact('student'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $user->id,
            'code' => $request->code,
            'note_final' => $request->note_final,
        ]);

        return redirect()->back()->with('success', 'Student created successfully!');
    }
}
