<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['user', 'subject'])->get();
        return response()->json($teachers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'gender' => 'required|in:M,F',
            'photo' => 'nullable|string',
            'adress' => 'nullable|string',
            'birthday' => 'nullable|date',
            'birthplace' => 'nullable|string',
            'tel' => 'nullable|integer',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
            'gender' => $request->gender,
            'photo' => $request->photo,
            'adress' => $request->adress,
            'birthday' => $request->birthday,
            'birthplace' => $request->birthplace,
            'tel' => $request->tel,
        ]);

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'subject_id' => $request->subject_id,
        ]);

        return response()->json([
            'message' => 'Teacher created successfully',
            'data' => $teacher->load(['user', 'subject']),
        ], 201);
    }

    public function show($id)
    {
        $teacher = Teacher::with(['user', 'subject'])->findOrFail($id);
        return response()->json($teacher);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:6',
            'gender' => 'required|in:M,F',
            'photo' => 'nullable|string',
            'adress' => 'nullable|string',
            'birthday' => 'nullable|date',
            'birthplace' => 'nullable|string',
            'tel' => 'nullable|integer',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $teacher->user->update([
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
                ? Hash::make($request->password)
                : $teacher->user->password,
        ]);

        $teacher->update([
            'subject_id' => $request->subject_id,
        ]);

        return response()->json([
            'message' => 'Teacher updated successfully',
            'data' => $teacher->load(['user', 'subject']),
        ]);
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        $teacher->user()->delete();
        $teacher->delete();

        return response()->json([
            'message' => 'Teacher deleted successfully',
        ]);
    }
}
