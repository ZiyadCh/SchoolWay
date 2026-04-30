@extends('layouts.app')
@section('title', 'Scolarité 2026')

@section('content')
@vite('resources/js/core/dashboard.js')

<div class="min-h-screen flex flex-col space-y-10 pb-16">
    <div class="mb-4">
        <h1 class="text-4xl text-white">Scolarité 2026</h1>
        <p class="text-amber-500 text-sm mt-1">Tableau de bord • Direction</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 flex items-center gap-6 hover:border-amber-500/40 transition-all group shadow-lg">
            <div class="bg-gray-900 w-16 h-16 rounded-xl border border-gray-700 flex items-center justify-center text-amber-500">
                <i class="fa-solid fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-400 uppercase">Élèves Inscrits</p>
                <div id="students-count" class="text-5xl text-white mt-1 animate-pulse">---</div>
            </div>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 flex items-center gap-6 hover:border-amber-500/40 transition-all group shadow-lg">
            <div class="bg-gray-900 w-16 h-16 rounded-xl border border-gray-700 flex items-center justify-center text-amber-500">
                <i class="fa-solid fa-user-tie text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-400 uppercase">Enseignants</p>
                <div id="teachers-count" class="text-5xl text-white mt-1 animate-pulse">---</div>
            </div>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 flex items-center gap-6 hover:border-amber-500/40 transition-all group shadow-lg">
            <div class="bg-gray-900 w-16 h-16 rounded-xl border border-gray-700 flex items-center justify-center text-amber-500">
                <i class="fa-solid fa-chalkboard-user text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-400 uppercase">Total Classes</p>
                <div id="classes-count" class="text-5xl text-white mt-1 animate-pulse">---</div>
            </div>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 flex items-center gap-6 hover:border-amber-500/40 transition-all group shadow-lg">
            <div class="bg-gray-900 w-16 h-16 rounded-xl border border-gray-700 flex items-center justify-center text-amber-500">
                <i class="fa-solid fa-hand-holding-dollar text-2xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-400 uppercase">Paiements</p>
                <div id="payments-count" class="text-5xl text-white mt-1 animate-pulse">---</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 flex flex-col h-full shadow-2xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
                <h3 class="text-sm uppercase text-gray-400">Liste des Niveaux</h3>
            </div>
            <div id="levels-list" class="grow max-h-80 overflow-y-auto pr-2 mb-8 space-y-3 text-white">
                <!-- Filled by JS -->
            </div>
            <button class="w-full py-4 bg-gray-700 hover:bg-amber-500 text-amber-500 hover:text-gray-900 text-sm uppercase rounded-xl transition-all border border-gray-600 font-bold">Gérer</button>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 flex flex-col h-full shadow-2xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
                <h3 class="text-sm uppercase text-gray-400">Liste des Matières</h3>
            </div>
            <div id="subjects-list" class="grow max-h-80 overflow-y-auto pr-2 mb-8 space-y-3 text-white">
                <!-- Filled by JS -->
            </div>
            <button class="w-full py-4 bg-gray-700 hover:bg-amber-500 text-amber-500 hover:text-gray-900 text-sm uppercase rounded-xl transition-all border border-gray-600 font-bold">Gérer</button>
        </div>

        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 flex flex-col h-full shadow-2xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1 h-5 bg-red-500 rounded-full"></div>
                <h3 class="text-sm uppercase text-gray-400">Absences Aujourd'hui</h3>
            </div>
            <div id="absences-list" class="grow max-h-80 overflow-y-auto pr-2 mb-8 space-y-3 text-white">
                <!-- Filled by JS -->
            </div>
        </div>
    </div>

    <div class="pt-8 flex justify-center">
        <button class="flex items-center gap-4 bg-gray-800 border border-gray-700 hover:border-amber-500 px-10 py-5 rounded-xl transition-all group shadow-lg">
            <i class="fa-solid fa-calendar-days text-amber-500 text-lg"></i>
            <span class="text-sm uppercase text-white group-hover:text-amber-500 font-bold">Options d'Années Scolaires</span>
        </button>
    </div>
</div>
@endsection
