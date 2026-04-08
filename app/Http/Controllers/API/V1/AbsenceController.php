<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Absence::with('inscription.student')->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inscription_id' => 'required|exists:inscriptions,id',
            'date'           => 'required|date',
            'justified'      => 'required|boolean',
        ]);

        $absence = Absence::create($validated);

        return response()->json([
            'message' => 'Absence enregistrée avec succès',
            'data'    => $absence->load('inscription.student'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Absence $absence)
    {
        return response()->json([
            'message' => 'Détails de l\'absence récupérés',
            'data'    => $absence->load('inscription.student'),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absence $absence)
    {
        $validated = $request->validate([
            'date'           => 'sometimes|required|date',
            'justified'      => 'sometimes|required|boolean',
        ]);

        $absence->update($validated);

        return response()->json([
            'message' => 'Absence mise à jour avec succès',
            'data'    => $absence->load('inscription.student'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absence $absence)
    {
        $absence->delete();

        return response()->json([
            'message' => 'Absence supprimée avec succès',
        ], 200);
    }
}
