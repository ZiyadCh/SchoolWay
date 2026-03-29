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
        $years = Year::all();
        return response()->json($years);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'beginning_date' => 'required|date',
            'end_date' => 'required|date|after:beginning_date',
            'current' => 'boolean',
        ]);

        return DB::transaction(function () use ($request) {
            if ($request->current) {
                Year::where('current', true)->update(['current' => false]);
            }

            $year = Year::create($request->all());

            return response()->json([
                'message' => 'Année scolaire créée avec succès',
                'data' => $year,
            ], 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Year $year)
    {
        return response()->json($year);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Year $year)
    {
        $request->validate([
            'label' => 'string|unique:years,label,' . $year->id,
            'beginning_date' => 'date',
            'end_date' => 'date|after:beginning_date',
            'current' => 'boolean',
        ]);

        return DB::transaction(function () use ($request, $year) {
            if ($request->current && !$year->current) {
                Year::where('current', true)->update(['current' => false]);
            }

            $year->update($request->all());

            return response()->json([
                'message' => 'Année scolaire mise à jour',
                'data' => $year,
            ]);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Year $year)
    {
        if ($year->inscriptions()->count() > 0) {
            return response()->json([
                'error' => "Impossible de supprimer une année contenant des inscriptions.",
            ], 422);
        }

        $year->delete();

        return response()->json([
            'message' => 'Année supprimée',
        ]);
    }
}
