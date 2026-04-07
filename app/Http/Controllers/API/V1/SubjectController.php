<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubjectController extends Controller
{
    /**
     * Display a listing of subjects.
     */
    public function index()
    {
        $subjects = Subject::all();
        return response()->json($subjects);
    }

    /**
     * Store a newly created subject in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:subjects,name|max:255',
            'coefficient' => 'required|integer',
        ]);

        $subject = Subject::create($validated);

        return response()->json([
            'message' => 'Subject cree avec success',
            'data' => $subject,
        ], 201);
    }

    /**
     * Display the specified subject.
     */
    public function show(Subject $subject)
    {
        return response()->json($subject->load('teachers.user'));
    }

    /**
     * Update the specified subject in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
        ]);

        $subject->update($validated);

        return response()->json([
            'message' => 'Subject updated successfully',
            'data' => $subject,
        ]);
    }

    /**
     * Remove the specified subject from storage.
     */
    public function destroy(Subject $subject)
    {
        if ($subject->teachers()->count() > 0) {
            return response()->json([
                'message' => 'il ya deja des ensaignant avec cette maitere!',
            ], 409);
        }

        $subject->delete();

        return response()->json([
            'message' => 'Subject deleted successfully',
        ], 200);
    }
}
