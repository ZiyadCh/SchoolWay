<?php

namespace App\Http\Controllers\API\V1;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of all school classes.
     */
    public function index()
    {
        $classes = SchoolClass::with('level')->get();

        return response()->json([
            'message' => 'Liste des classes',
            'data'    => $classes,
        ]);
    }

    /**
     * Store a newly created school class.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255|unique:school_classes,name',
            'level_id' => 'required|exists:levels,id',
            'teacher_id' => 'sometimes|exists:teachers,id',
        ]);

        $class = SchoolClass::create($validated);

        return response()->json([
            'message' => 'School class created successfully.',
            'data'    => $class->load('level'),
        ], 201);
    }

    /**
     * Display the specified school class.
     */
    public function show(SchoolClass $schoolClass)
    {
        return response()->json([
            'message' => 'School class retrieved successfully.',
            'data'    => $schoolClass->load('level'),
        ]);
    }

    /**
     * Update the specified school class.
     */
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255|unique:school_classes,name,' . $schoolClass->id,
            'level_id' => 'sometimes|exists:levels,id',
            'teacher_id' => 'sometimes|exists:teachers,id',
        ]);

        $schoolClass->update($validated);

        return response()->json([
            'message' => 'School class updated successfully.',
            'data'    => $schoolClass->load('level'),
        ]);
    }

    /**
     * Remove the specified school class.
     */
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();

        return response()->json([
            'message' => 'School class deleted successfully.',
        ]);
    }

    /**
     * Display all students enrolled in the specified school class.
     */
    public function students(SchoolClass $schoolClass)
    {
        $students = $schoolClass->students()
            ->with('user')
            ->get();

        return response()->json([
            'message' => "Students in class '{$schoolClass->name}' retrieved successfully.",
            'class'   => $schoolClass->name,
            'count'   => $students->count(),
            'data'    => $students,
        ]);
    }
}
