<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class EnrollementController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_ids'   => 'required|array',
            'inscription_ids.*' => 'exists:inscriptions,id',
            'classe_id'         => 'required|exists:school_classes,id',
        ]);

        $classe = SchoolClass::findOrFail($validated['classe_id']);
        $added = 0;

        foreach ($validated['inscription_ids'] as $inscriptionId) {
            $inscription = Inscription::findOrFail($inscriptionId);
            $alreadyEnrolled = $inscription->schoolClasses()->where('school_class_id', $validated['classe_id'])->exists();
            if (!$alreadyEnrolled) {
                $inscription->schoolClasses()->syncWithoutDetaching([$validated['classe_id']]);
                $added++;
            }
        }

        $classe->increment('nbr_students', $added);

        return response()->json([
            'message' => "{$added} étudiant(s) inscrit(s) à la classe avec succès",
            'data'    => $classe->load('inscriptions.student.user'),
        ], 201);
    }

    public function destroy(Request $request, Inscription $inscription)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:school_classes,id',
        ]);

        $inscription->schoolClasses()->detach($validated['classe_id']);
        SchoolClass::where('id', $validated['classe_id'])->decrement('nbr_students');

        return response()->json([
            'message' => 'Étudiant retiré de la classe avec succès',
        ], 200);
    }
}
