<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Devoir;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DevoirController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Devoir::query();

        if ($request->has('school_class_id')) {
            $query->where('school_class_id', $request->school_class_id);
        }

        return response()->json($query->with('schoolClass')->latest()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'title'           => 'required|string|max:255',
            'contenu'         => 'required|string',
            'deadline'        => 'required|date|after:today',
        ]);

        $devoir = Devoir::create($validated);

        return response()->json($devoir->load('schoolClass'), 201);
    }

    public function show(Devoir $devoir): JsonResponse
    {
        return response()->json($devoir->load('schoolClass'));
    }

    public function update(Request $request, Devoir $devoir): JsonResponse
    {
        $validated = $request->validate([
            'school_class_id' => 'sometimes|exists:school_classes,id',
            'title'           => 'sometimes|string|max:255',
            'contenu'         => 'sometimes|string',
            'deadline'        => 'sometimes|date',
        ]);

        $devoir->update($validated);

        return response()->json($devoir);
    }

    public function destroy(Devoir $devoir): JsonResponse
    {
        $devoir->delete();
        return response()->json(null, 204);
    }

    public function studentHomework(Request $request): JsonResponse
    {
        $classId = $request->user()->student->inscription->school_class_id;

        $devoirs = Devoir::where('school_class_id', $classId)
            ->orderBy('deadline', 'asc')
            ->get();

        return response()->json($devoirs);
    }
}
