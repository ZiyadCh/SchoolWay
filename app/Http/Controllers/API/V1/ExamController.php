<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Note;
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
            'school_class_id' => 'required|integer|exists:school_classes,id',
            'title'           => 'required|string|max:255',
            'date'            => 'required|date',
            'notes'           => 'required|array',
        ]);

        $exam = Exam::create([
            'title' => $validated['title'],
            'date'  => $validated['date'],
        ]);

        foreach ($request->notes as $student) {
            Note::create([
                'exam_id'        => $exam->id,
                'inscription_id' => $student['inscription_id'],
                'valeur'         => $student['valeur'],
            ]);
        }

        return response()->json([
            'message' => 'Examen enregistré avec succès',
            'data'    => $exam->load('inscriptions.student'),
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
