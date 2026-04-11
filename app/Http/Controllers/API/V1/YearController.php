<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Liste des années scolaires récupérée avec succès',
            'data'    => Year::latest()->get(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|unique:academic_year,title',
            'beginning_date' => 'required|date',
            'end_date'       => 'required|date|after:beginning_date',
            'current'        => 'boolean',
        ]);

        return DB::transaction(function () use ($request) {
            if ($request->current) {
                Year::where('current', true)->update(['current' => false]);
            }

            $year = Year::create($request->all());

            return response()->json([
                'message' => 'Année scolaire créée avec succès',
                'data'    => $year,
            ], 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Year $year)
    {
        return response()->json([
            'message' => 'Détails de l\'année scolaire récupérés',
            'data'    => $year,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Year $year)
    {
        $request->validate([
            'title'          => 'sometimes|required|string|unique:academic_year,title,' . $year->id,
            'beginning_date' => 'sometimes|required|date',
            'end_date'       => 'sometimes|required|date|after:beginning_date',
            'current'        => 'boolean',
        ]);

        return DB::transaction(function () use ($request, $year) {
            if ($request->current && !$year->current) {
                Year::where('current', true)->update(['current' => false]);
            }

            $year->update($request->all());

            return response()->json([
                'message' => 'Année scolaire mise à jour avec succès',
                'data'    => $year,
            ], 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Year $year)
    {
        if ($year->inscriptions()->count() > 0) {
            return response()->json([
                'message' => 'Impossible de supprimer une année contenant des inscriptions.',
            ], 422);
        }

        $year->delete();

        return response()->json([
            'message' => 'Année scolaire supprimée avec succès',
        ], 200);
    }
}
