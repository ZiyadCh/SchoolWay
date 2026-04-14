<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SchoolClass::with(['level', 'teacher.user']);

        if ($request->level_id) {
            $query->where('level_id', $request->level_id);
        }

        if ($request->teacher_id) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->nbr) {
            $query->orderBy('nbr_students', 'desc');
        }

        return response()->json($query->paginate(2));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255|unique:school_classes,name',
            'level_id'   => 'required|exists:levels,id',
            'teacher_id' => 'sometimes|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $schoolClass = SchoolClass::create($validated);

        return response()->json([
            'message' => 'Classe créée avec succès',
            'data'    => $schoolClass->load(['level', 'teacher.user']),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $schoolClass)
    {
        return response()->json([
            'message' => 'Classe récupérée avec succès',
            'data'    => $schoolClass->load(['level', 'teacher.user']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'name'       => 'sometimes|string|max:255|unique:school_classes,name,' . $schoolClass->id,
            'level_id'   => 'sometimes|exists:levels,id',
            'teacher_id' => 'sometimes|exists:teachers,id',
            'subject_id' => 'sometimes|exists:subjects,id',
        ]);

        $schoolClass->update($validated);

        return response()->json([
            'message' => 'Classe mise à jour avec succès',
            'data'    => $schoolClass->load(['level', 'teacher.user']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $schoolClass)
    {

        $schoolClass->inscriptions()->detach();
        $schoolClass->delete();

        return response()->json([
            'message' => 'Classe supprimée avec succès',
        ], 200);
    }
}
