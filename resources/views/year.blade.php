@extends('layouts.app')
@section('title', 'Années Scolaires')
@section('content')
@vite('resources/js/core/years.js')

<div class="max-w-5xl mx-auto space-y-10 pb-20 text-white">

    <div>
        <h1 class="text-4xl font-black uppercase tracking-tighter">Années Scolaires</h1>
        <p class="text-amber-500 text-sm mt-1 font-bold uppercase tracking-widest">Gestion • Direction</p>
    </div>

    {{-- Current Year Status --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
            <h2 class="text-sm font-black uppercase tracking-widest text-gray-400">Année en cours</h2>
        </div>

        <div id="current-year-info" class="animate-pulse text-gray-500 text-xs uppercase font-black tracking-widest">
            Chargement...
        </div>

        <button id="btn-end-year" class="hidden px-6 py-3 bg-red-500/10 border border-red-500/30 text-red-400 hover:bg-red-500 hover:text-white text-[11px] font-black uppercase tracking-widest rounded-xl transition-all">
            Clôturer l'année en cours
        </button>
    </div>

    {{-- Rollover Section --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-1 h-5 bg-blue-500 rounded-full"></div>
            <h2 class="text-sm font-black uppercase tracking-widest text-gray-400">Réinscrire vers une autre année</h2>
        </div>

        <div id="rollover-section">
            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest mb-4">Choisir l'année cible</p>
            <select id="rollover-year-select" class="bg-gray-800 border border-gray-700 text-white text-sm font-bold rounded-lg px-4 py-3 outline-none focus:border-amber-500 transition-colors w-full max-w-sm mb-6">
                <option value="">-- Sélectionner une année --</option>
            </select>

            <div class="mb-4 flex items-center justify-between">
                <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Étudiants à réinscrire</p>
                <div class="flex gap-3">
                    <button id="btn-check-all" class="text-[9px] font-black uppercase tracking-widest text-amber-500 hover:text-amber-400 transition-colors">Tout sélectionner</button>
                    <button id="btn-uncheck-all" class="text-[9px] font-black uppercase tracking-widest text-gray-500 hover:text-white transition-colors">Tout désélectionner</button>
                </div>
            </div>

            <input id="student-search" type="text" placeholder="Rechercher un élève..." class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors mb-3">

            <div id="students-rollover-list" class="max-h-96 overflow-y-auto space-y-1 border border-gray-800 rounded-xl p-3 mb-6">
                <p class="text-center text-gray-500 text-xs uppercase font-black p-4">Chargement...</p>
            </div>

            <p id="rollover-message" class="text-[11px] font-bold text-center hidden mb-4"></p>

            <button id="btn-rollover" class="px-6 py-3 bg-blue-500/10 border border-blue-500/30 text-blue-400 hover:bg-blue-500 hover:text-white text-[11px] font-black uppercase tracking-widest rounded-xl transition-all">
                Réinscrire les étudiants sélectionnés
            </button>
        </div>
    </div>

    {{-- Create New Year --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 space-y-6">
        <div class="flex items-center gap-3">
            <div class="w-1 h-5 bg-emerald-500 rounded-full"></div>
            <h2 class="text-sm font-black uppercase tracking-widest text-gray-400">Créer une nouvelle année</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Titre</label>
                <input id="new-year-title" type="text" placeholder="Ex: 2026-2027" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Date de début</label>
                <input id="new-year-start" type="date" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Date de fin</label>
                <input id="new-year-end" type="date" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors">
            </div>
        </div>

        <p id="create-year-message" class="text-[11px] font-bold hidden"></p>

        <button id="btn-create-year" class="px-6 py-3 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 hover:bg-emerald-500 hover:text-white text-[11px] font-black uppercase tracking-widest rounded-xl transition-all">
            Créer l'année scolaire
        </button>
    </div>

</div>

{{-- Confirm End Year Modal --}}
<div id="end-year-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8">
        <h3 class="text-sm font-black uppercase tracking-widest text-white mb-4">Confirmer la clôture</h3>
        <p class="text-sm text-gray-400 mb-6">Cette action marquera toutes les inscriptions comme <span class="text-red-400 font-bold">terminées</span> et clôturera l'année en cours. Cette action est irréversible.</p>
        <div class="flex gap-3">
            <button id="confirm-end-year" class="flex-1 py-3 bg-red-500 hover:bg-red-400 text-white text-[11px] font-black uppercase tracking-widest rounded-lg transition-colors">
                Confirmer la clôture
            </button>
            <button id="cancel-end-year" class="flex-1 py-3 border border-gray-700 text-gray-400 hover:text-white text-[11px] font-black uppercase tracking-widest rounded-lg transition-colors">
                Annuler
            </button>
        </div>
    </div>
</div>
@endsection
