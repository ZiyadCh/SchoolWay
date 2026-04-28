<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Teacher::with(['user']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $teachers = $query->latest()->paginate(5);

        return response()->json($teachers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'        => 'required|string',
            'prenom'     => 'required|string',
            'email'      => 'required|email|unique:users,email',
            'gender'     => 'required|in:M,F',
            'photo'      => 'nullable|string',
            'adress'     => 'nullable|string',
            'birthday'   => 'nullable|date',
            'birthplace' => 'nullable|string',
            'tel'        => 'nullable|string|numeric',
        ]);

        $password = Str::random(8);

        $user = User::create([
            'nom'        => $request->nom,
            'prenom'     => $request->prenom,
            'email'      => $request->email,
            'password'   => Hash::make($password),
            'role'       => 'teacher',
            'gender'     => $request->gender,
            'photo'      => $request->photo,
            'adress'     => $request->adress,
            'birthday'   => $request->birthday,
            'birthplace' => $request->birthplace,
            'tel'        => $request->tel,
        ]);

        $teacher = Teacher::create([
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Enseignant créé avec succès',
            'data'    => $teacher->load(['user']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return response()->json([
            'message' => 'Détails de l\'enseignant récupérés',
            'data'    => $teacher->load(['user', 'subject']),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'nom'        => 'required|string',
            'prenom'     => 'required|string',
            'email'      => 'required|email|unique:users,email,',
            'password'   => 'nullable|min:6',
            'gender'     => 'required|in:M,F',
            'photo'      => 'nullable|string',
            'adress'     => 'nullable|string',
            'birthday'   => 'nullable|date',
            'birthplace' => 'nullable|string',
            'tel'        => 'nullable|string|numeric',
            'subject_id' => 'sometimes|exists:subjects,id',
        ]);

        $teacher->user->update([
            'nom'        => $request->nom,
            'prenom'     => $request->prenom,
            'email'      => $request->email,
            'gender'     => $request->gender,
            'photo'      => $request->photo,
            'adress'     => $request->adress,
            'birthday'   => $request->birthday,
            'birthplace' => $request->birthplace,
            'tel'        => $request->tel,
            'password'   => $request->password ? Hash::make($request->password) : $teacher->user->password,
        ]);

        $teacher->update([
            'subject_id' => $request->subject_id,
        ]);

        return response()->json([
            'message' => 'Enseignant mis à jour avec succès',
            'data'    => $teacher->load(['user', 'subject']),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->user()->delete();
        $teacher->delete();

        return response()->json([
            'message' => 'Enseignant supprimé avec succès',
        ], 200);
    }
}
