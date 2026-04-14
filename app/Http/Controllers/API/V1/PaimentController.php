<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Paiment;
use Illuminate\Http\Request;

class PaimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Paiment::with(['inscription.student.user', 'inscription.schoolClass']);

        if ($request->inscription_id) {
            $query->where('inscription_id', $request->inscription_id);
        }

        if ($request->etat) {
            $query->where('etatPayement', $request->etat);
        }

        if ($request->mois) {
            $query->where('mois', $request->mois);
        }

        return response()->json([
            'message' => 'Liste des paiements récupérée avec succès',
            'data'    => $query->latest()->get(),
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(Paiment $paiment)
    {
        return response()->json([
            'message' => 'Détails du paiement récupérés',
            'data'    => $paiment->load(['inscription.student.user', 'inscription.schoolClass']),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paiment $paiment)
    {
        $validated = $request->validate([
            'mois'         => 'sometimes|string',
            'etatPayement' => 'sometimes|boolean',
        ]);

        $paiment->update($validated);

        return response()->json([
            'message' => 'Paiement mis à jour avec succès',
            'data'    => $paiment->load(['inscription.student.user']),
        ], 200);
    }

    public function markAsPaid(Paiment $paiment)
    {
        $paiment->update([
            'etatPaiement' => !$paiment->etatPaiement,
        ]);

        return response()->json([
            'message' => 'Mois marqué comme payé avec succès',
            'data'    => $paiment->load(['inscription.student.user']),
        ], 200);
    }

}
