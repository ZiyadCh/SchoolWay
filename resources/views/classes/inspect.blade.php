@extends('layouts.app')
@section('title', 'Détails de la Classe')

@section('content')
@vite(['resources/js/classes/inspect.js'])

<div class="max-w-7xl mx-auto space-y-8 text-white pb-20 px-4">

    <div class="relative bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 p-8">
            <div class="flex flex-col items-end">
                <p id="student-count" class="text-5xl font-black text-amber-500 leading-none">00</p>
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mt-2">Élèves inscrits</p>
            </div>
        </div>

        <div class="p-8 md:p-12 flex flex-col md:flex-row items-center gap-10">
            <div class="relative">
                <div class="w-32 h-32 md:w-48 md:h-48 rounded-3xl overflow-hidden border-2 border-gray-800 p-1 bg-gray-800 shadow-xl">
                    <img id="teacher-avatar" src="/images/default.jpeg" class="w-full h-full object-cover rounded-2xl">
                </div>
                <div class="absolute -bottom-2 -right-2 bg-amber-500 text-black p-3 rounded-2xl shadow-lg">
                    <i class="fa-solid fa-graduation-cap text-xl"></i>
                </div>
            </div>

            <div class="flex-1 text-center md:text-left">
                <p id="class-subject" class="text-amber-500 font-black tracking-widest text-[10px] uppercase mb-3 opacity-90"></p>
                <h1 id="class-name" class="text-4xl md:text-6xl font-black uppercase tracking-tighter mb-4">CHARGEMENT...</h1>

                <div class="flex flex-wrap justify-center md:justify-start gap-6 pt-6 border-t border-gray-800/60">
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mb-1">Enseignant Responsable</p>
                        <p id="teacher-name" class="text-lg font-bold text-white uppercase italic">Chargement...</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mb-1">Niveau d'études</p>
                        <p id="level-name" class="text-sm font-semibold text-gray-400">Chargement...</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mb-1">Contact</p>
                        <p id="teacher-email" class="text-sm font-semibold text-gray-400"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-2 bg-gray-900/50 p-1 rounded-2xl border border-gray-800 w-fit mx-auto md:mx-0">
        <button onclick="switchTab(event, 'students')" class="tab-btn px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all bg-amber-500 text-black">
            Liste des Élèves
        </button>
        <button onclick="switchTab(event, 'assignments')" class="tab-btn px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-gray-500 hover:text-white">
            Travaux & Devoirs
        </button>
    </div>

    <div id="students" class="tab-content transition-all duration-300">
        <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-800/30 border-b border-gray-800">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-500">Élève</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Profil</th>
                    </tr>
                </thead>
                <tbody id="students-list"></tbody>
            </table>
        </div>
    </div>

    <div id="assignments" class="tab-content hidden opacity-0 transition-all duration-300">
        <div id="devoirs-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
    </div>
</div>
@endsection
