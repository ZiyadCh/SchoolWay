<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnrollementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'classe_id' => 'required|exists:classes,id',
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $student->classe()->associate($validated['classe_id']);
        $student->save();

        return response()->json([
            'message' => 'Student enrolled successfully',
            'data' => $student->load('user', 'classe'),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
        ]);

        $student->classe()->associate($validated['classe_id']);
        $student->save();

        return response()->json([
            'message' => 'Enrollment updated successfully',
            'data' => $student->load('user', 'classe'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->classe()->dissociate();
        $student->save();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
