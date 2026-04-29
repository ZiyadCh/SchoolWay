@extends('layouts.app')
@section('title', 'Détails de la Classe')

@section('content')
@vite(['resources/js/classes/inspect.js'])

<div class="max-w-7xl mx-auto space-y-8 text-white pb-20 px-4">

    <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl">
        <div class="p-8 md:p-12 flex flex-col md:flex-row items-center gap-10">

            <div class="relative shrink-0">
                <div class="w-32 h-32 md:w-48 md:h-48 rounded-3xl overflow-hidden border-2 border-gray-800 p-1 bg-gray-800 shadow-xl">
                    <img id="teacher-avatar" src="/images/default.jpeg" class="w-full h-full object-cover rounded-2xl">
                </div>
                <div class="absolute -bottom-2 -right-2 bg-amber-500 text-black p-3 rounded-2xl shadow-lg">
                    <i class="fa-solid fa-graduation-cap text-xl"></i>
                </div>
            </div>

            <div class="flex-1 text-center md:text-left">
                <p id="class-subject" class="text-amber-500 font-black tracking-widest text-[10px] uppercase mb-3 opacity-90"></p>
                <h1 id="class-name" class="text-4xl md:text-6xl font-black uppercase tracking-tighter mb-4 leading-tight">CHARGEMENT...</h1>

                <div class="flex flex-wrap justify-center md:justify-start gap-x-10 gap-y-6 pt-6 border-t border-gray-800/60">
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mb-1">Effectif</p>
                        <div class="flex items-baseline gap-1">
                            <span id="student-count" class="text-2xl font-black text-amber-500">00</span>
                            <span class="text-[10px] text-gray-600 font-bold uppercase">Élèves</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mb-1">Enseignant</p>
                        <p id="teacher-name" class="text-sm md:text-base font-bold text-white uppercase italic">Chargement...</p>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mb-1">Niveau d'études</p>
                        <p id="level-name" class="text-sm font-semibold text-gray-400 italic">Chargement...</p>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mb-1">Contact</p>
                        <p id="teacher-email" class="text-sm font-semibold text-gray-400"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-500 bg-amber-500/5 w-fit px-4 py-2 rounded-lg border border-amber-500/10">
            Liste des Élèves Inscrits
        </h2>

        <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden">
            <div class="overflow-x-auto">
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
    </div>

    <template id="student-row-template">
        <tr class="border-b border-gray-800/50 hover:bg-gray-800/10 transition-all group">
            <td class="px-8 py-5">
                <div class="flex items-center gap-4">
                    <img class="student-photo w-10 h-10 rounded-xl object-cover grayscale group-hover:grayscale-0 transition-all border border-gray-800" src="" alt="">
                    <span class="student-name text-sm font-bold text-gray-300 group-hover:text-amber-500 transition-colors uppercase"></span>
                </div>
            </td>
            <td class="px-8 py-5 text-right">
                <a class="student-link inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-800 text-gray-500 hover:bg-amber-500 hover:text-black transition-all" href="">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            </td>
        </tr>
    </template>

</div>
@endsection
