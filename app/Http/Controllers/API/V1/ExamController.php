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
    public function index(Request $request)
    {
        $query = Exam::with(['notes', 'inscriptions.student.user']);

        if ($request->inscription_id) {
            $query->whereHas('inscriptions', function ($q) use ($request) {
                $q->where('inscription_id', $request->inscription_id);
            });
        }

        if ($request->school_class_id) {
            $query->whereHas('inscriptions', function ($q) use ($request) {
                $q->where('school_class_id', $request->school_class_id);
            });
        }

        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        if ($request->title) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
        }

        $exams = $query->latest()->get();


        return response()->json([
            'message' => 'Liste des examens récupérée avec succès',
            'data'    => $exams,
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
