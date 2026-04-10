<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Liste des examens récupérée avec succès',
            'data'    => Exam::with('inscription.student')->latest()->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'school_class_id'          => 'required|integer',
            'title'          => 'required|string|max:255',
            'date'           => 'required|date',
        ]);

        $schoolClass= SchoolClass::findOrFail($validated['school_class_id'])

        foreach($schoolClass->inscriptions as inscription){
            Note::create([
                'inscription_id' => inscription->id,
                'note' => inscription->id,
                'school_class_id' => inscription->id,
            ])
        }

        $exam = Exam::create($validated)


        return response()->json([
            'message' => 'Examen enregistré avec succès',
            'data'    => $exam->load('inscription.student'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        return response()->json([
            'message' => 'Détails de l\'examen récupérés',
            'data'    => $exam->load('inscription.student'),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title'          => 'sometimes|required|string|max:255',
            'date'           => 'sometimes|required|date',
        ]);

        $exam->update($validated);

        return response()->json([
            'message' => 'Examen mis à jour avec succès',
            'data'    => $exam->load('inscription.student'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return response()->json([
            'message' => 'Examen supprimé avec succès',
        ], 200);
    }
}
