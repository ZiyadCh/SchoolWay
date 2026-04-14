<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Liste des niveaux récupérée avec succès',
            'data'    => Level::latest()->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:levels,name',
        ]);

        $level = Level::create($validated);

        return response()->json([
            'message' => 'Niveau créé avec succès',
            'data'    => $level,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        return response()->json([
            'message' => 'Détails du niveau récupérés',
            'data'    => $level,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:levels,name,' . $level->id,
        ]);

        $level->update($validated);

        return response()->json([
            'message' => 'Niveau mis à jour avec succès',
            'data'    => $level,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level)
    {
        $level->delete();

        return response()->json([
            'message' => 'Niveau supprimé avec succès',
        ], 200);
    }
}
