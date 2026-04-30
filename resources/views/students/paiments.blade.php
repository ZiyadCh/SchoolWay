@extends('layouts.student')
@section('title', 'Mes Paiements - School-Way')
@section('content')
@vite(['resources/js/student/paiements.js'])
<div class="w-full h-full p-6 md:p-12 text-white">
    <div class="max-w-5xl mx-auto space-y-6">
        <h2 class="text-xl font-black uppercase tracking-tighter">Historique des Paiements</h2>
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-950/50 border-b border-gray-800">
                        <th class="p-5 text-[14px] font-black uppercase tracking-widest text-gray-500">Mois</th>
                        <th class="p-5 text-[14px] font-black uppercase tracking-widest text-gray-500 text-right">Statut</th>
                    </tr>
                </thead>
                <tbody id="paiements-container" class="divide-y divide-gray-800/50">
                    <tr>
                        <td colspan="2" class="p-10 text-center animate-pulse text-gray-500 uppercase font-black text-xs tracking-widest">
                            Vérification des transactions...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
