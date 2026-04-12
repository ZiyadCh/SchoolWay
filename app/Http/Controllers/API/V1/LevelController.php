<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollementController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'classe_id'  => 'required|exists:classes,id',
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $student->classe()->associate($validated['classe_id']);
        $student->save();

        return response()->json([
            'message' => 'Student enrolled successfully',
            'data'    => $student->load('user', 'classe'),
        ], 201);
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
            'data'    => $student->load('user', 'classe'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->classe()->dissociate();
        $student->save();

        return response()->json([
            'message' => 'Enrollment removed successfully',
        ], 200);
    }
}
