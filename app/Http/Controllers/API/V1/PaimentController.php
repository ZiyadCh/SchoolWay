<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\Paiment;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Paiment::with(['inscription.student.user']);

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('inscription.student.user', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('nom', 'LIKE', "%{$search}%")
                        ->orWhere('prenom', 'LIKE', "%{$search}%");
                });
            });
        }

        if ($request->inscription_id) {
            $query->where('inscription_id', $request->inscription_id);
        }

        if ($request->etat) {
            $query->where('etatPaiement', $request->etat);
        }

        if ($request->mois) {
            $query->where('mois', $request->mois);
        }

        return response()->json([
            'message' => 'Liste des paiements récupérée avec succès',
            'data'    => $query->orderBy('mois')->get(),
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
            'mois'         => 'string',
            'etatPaiement' => 'boolean',
        ]);

        $paiment->update($validated);

        return response()->json([
            'message' => 'Paiement mis à jour avec succès',
            'data'    => $paiment->load(['inscription.student.user']),
        ], 200);
    }

    public function markAsPaid(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids) || !is_array($ids)) {
            return response()->json(['message' => 'Aucun paiement sélectionné'], 400);
        }

        Paiment::whereIn('id', $ids)->update([
            'etatPaiement' =>  DB::raw('NOT "etatPaiement"'),
        ]);

        return response()->json([
            'message' => 'Paiements mis à jour avec succès',
            'updated_ids' => $ids,
        ], 200);
    }

    //the function of calculating the payments stats of a student
    //(comparing the number of months from the beginning of ther year till now
    //with the number of months where etatPaiement = true . for each student)

    public function getPaymentStats(Request $request)
    {
        $activeYear = Year::currentYear();

        if (!$activeYear) {
            return response()->json(['message' => 'Aucune année active'], 404);
        }

        $start = Carbon::parse($activeYear->beginning_date)->startOfMonth();
        $now = Carbon::now()->startOfMonth();
        $monthsDue = $start->diffInMonths($now) + 1;

        $query = Inscription::where('year_id', $activeYear->id)
            ->with(['student.user'])
            ->withCount(['payments' => function ($q) {
                $q->where('etatPaiement', true);
            }]);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student.user', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('nom', 'LIKE', "%{$search}%")
                        ->orWhere('prenom', 'LIKE', "%{$search}%");
                });
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'paid') {
                $query->has('payments', '>=', $monthsDue, 'and', function ($q) {
                    $q->where('etatPaiement', true);
                });
            } elseif ($status === 'late') {
                $query->has('payments', '<', $monthsDue, 'and', function ($q) {
                    $q->where('etatPaiement', true);
                });
            }
        }

        $totalStudents = (clone $query)->count();
        $paidStudentsCount = (clone $query)->has('payments', '>=', $monthsDue, 'and', function ($q) {
            $q->where('etatPaiement', true);
        })->count();

        $percentagePaid = $totalStudents > 0
            ? round(($paidStudentsCount / $totalStudents) * 100, 2)
            : 0;

        $inscriptions = $query->paginate(5);

        $studentsStatus = $inscriptions->getCollection()->map(function ($inscription) use ($monthsDue) {
            $paidCount = $inscription->payments_count;
            $isUpToDate = $paidCount >= $monthsDue;

            return [
                'id' => $inscription->id,
                'student_name' => "{$inscription->student->user->nom} {$inscription->student->user->prenom}",
                'student_photo' => $inscription->student->user->photo,
                'paid_months'  => $paidCount,
                'total_due'    => $monthsDue,
                'status'       => $isUpToDate ? 'À Jour' : 'En Retard',
            ];
        });

        return response()->json([
            'months_reference' => $monthsDue,
            'percentage_paid' => $percentagePaid,
            'students'      => $studentsStatus,
            'current_page'  => $inscriptions->currentPage(),
            'last_page'     => $inscriptions->lastPage(),
            'next_page_url' => $inscriptions->nextPageUrl(),
            'prev_page_url' => $inscriptions->previousPageUrl(),
        ], 200);
    }
}
