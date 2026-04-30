@extends('layouts.student')
@section('title', 'Mes Absences - School-Way')

@section('content')
@vite(['resources/js/student/absences.js'])
<div class="w-full h-full p-6 md:p-12 text-white">
    <div class="max-w-5xl mx-auto space-y-8">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between items-center min-h-32">
                <p class="text-xs font-black text-gray-500 uppercase">Total Absences</p>
                <p id="total-absences" class="text-5xl font-black text-white">--</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between items-center min-h-32">
                <p class="text-xs font-black text-gray-500 uppercase">Justifiées</p>
                <p id="justified-count" class="text-5xl font-black text-emerald-500">--</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-center items-center min-h-32">
                <p class="text-xs font-black text-gray-500 uppercase">Non Justifiées</p>
                <p id="unjustified-count" class="text-5xl font-black text-red-500">--</p>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-950 border-b border-gray-800">
                            <th class="p-6 text-xs font-black uppercase text-gray-500">Date de l'absence</th>
                            <th class="p-6 text-xs font-black uppercase text-gray-500 text-right">Statut Justification</th>
                        </tr>
                    </thead>
                    <tbody id="absences-table-body" class="divide-y divide-gray-800">
                        <!-- Chargement via JS -->
                        <tr>
                            <td colspan="2" class="p-10 text-center animate-pulse text-gray-500 uppercase font-black text-xs tracking-widest">
                                Récupération des données...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
