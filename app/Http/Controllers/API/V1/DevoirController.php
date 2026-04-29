<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Devoir;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DevoirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Devoir::query();

        if ($request->has('school_class_id')) {
            $query->where('school_class_id', $request->school_class_id);
        }

        if ($request->inscription_id) {
            $query->whereHas('inscriptions', function ($q) use ($request) {
                $q->where('inscription_id', $request->inscription_id);
            });
        }

        return response()->json([
            'message' => 'Liste des devoirs récupérée avec succès',
            'data'    => $query->with('schoolClass')->latest()->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'title'           => 'required|string|max:255',
            'contenu'         => 'required|string',
            'deadline'        => 'required|date|after:today',
        ]);

        $devoir = Devoir::create($validated);

        return response()->json([
            'message' => 'Devoir créé avec succès',
            'data'    => $devoir->load('schoolClass'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Devoir $devoir): JsonResponse
    {
        return response()->json([
            'message' => 'Détails du devoir récupérés',
            'data'    => $devoir->load('schoolClass'),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Devoir $devoir): JsonResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'sometimes|exists:school_classes,id',
            'title'           => 'sometimes|string|max:255',
            'contenu'         => 'sometimes|string',
            'deadline'        => 'sometimes|date',
        ]);

        $devoir->update($validated);

        return response()->json([
            'message' => 'Devoir mis à jour avec succès',
            'data'    => $devoir->load('schoolClass'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Devoir $devoir): JsonResponse
    {
        $devoir->delete();

        return response()->json([
            'message' => 'Devoir supprimé avec succès',
        ], 200);
    }


}
