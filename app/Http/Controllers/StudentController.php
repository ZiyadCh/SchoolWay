<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {
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
            'tel' => 'nullable|integer',
            'code' => 'required',
            'note_final' => 'nullable|numeric',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student',
            'gender' => $request->gender,
            'photo' => $request->photo,
            'adress' => $request->adress,
            'birthday' => $request->birthday,
            'birthplace' => $request->birthplace,
            'tel' => $request->tel,
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'code' => $request->code,
            'note_final' => $request->note_final,
        ]);

        return response()->json([
            'message' => 'Student created successfully',
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
            'email' => 'nullable|email|unique:users,email,' . $student->user->id,
            'password' => 'nullable|min:6',
            'gender' => 'required|in:M,F',
            'photo' => 'nullable|string',
            'adress' => 'nullable|string',
            'birthday' => 'nullable|date',
            'birthplace' => 'nullable|string',
            'tel' => 'nullable|integer',
            'code' => 'required',
            'note_final' => 'nullable|numeric',
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
            'code' => $request->code,
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
            'message' => 'Student deleted successfully',
        ]);
    }
}
