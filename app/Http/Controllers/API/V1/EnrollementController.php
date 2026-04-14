<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use Illuminate\Http\Request;

class EnrollementController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'classe_id'      => 'required|exists:school_classes,id',
        ]);

        $inscription = Inscription::findOrFail($validated['inscription_id']);

        $inscription->schoolClasses()->syncWithoutDetaching([$validated['classe_id']]);
        $inscription->schoolClasses()->increment('nbr_students');

        return response()->json([
            'message' => 'Étudiant inscrit à la classe avec succès',
            'data'    => $inscription->load('student.user', 'schoolClasses'),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Inscription $inscription)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:school_classes,id',
        ]);

        $inscription->schoolClasses()->detach($validated['classe_id']);
        $inscription->schoolClasses()->decrement('nbr_students');

        return response()->json([
            'message' => 'Étudiant retiré de la classe avec succès',
        ], 200);
    }
}
