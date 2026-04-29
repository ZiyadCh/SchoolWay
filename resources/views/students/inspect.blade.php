@extends('layouts.app')
@section('title', 'Profil Étudiant')

@section('content')
@vite(['resources/js/tab.js','resources/js/student/inspect.js'])

<div class="max-w-7xl mx-auto space-y-8 text-white pb-20 scrollbar-hide px-4">

    <div class="max-w-8xl mx-auto bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="flex flex-col lg:flex-row items-center lg:items-start gap-12">

                <div class="relative shrink-0">
                    <div class="w-32 h-32 md:w-44 md:h-44 rounded-3xl overflow-hidden bg-gray-800 border-2 border-gray-800 p-1 shadow-2xl">
                        <img id="user-avatar" src="" alt="pfp" class="w-full h-full object-cover rounded-2xl bg-gray-900">
                    </div>
                </div>

                <div class="flex-1 w-full">
                    <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-6 mb-10">
                        <div class="text-center lg:text-left">
                            <h2 id="user-fullname" class="text-4xl md:text-6xl font-black uppercase tracking-tight text-white leading-none">
                                CHARGEMENT...
                            </h2>
                            <p class="text-amber-500 font-medium tracking-[0.3em] text-[10px] uppercase mt-2 opacity-80">Statut Étudiant Académique</p>
                        </div>

                        <a href="{ route('student-classes' ) }}" class="group flex items-center gap-3 px-6 py-3.5 bg-gray-800/50 border border-gray-700 rounded-2xl hover:border-amber-500/50 transition-all duration-300">
                            <span class="text-gray-300 ">
                                <i class="fa-solid fa-chalkboard-user text-gray-300"></i>
                            </span>
                            <span class="text-[11px] font-bold uppercase tracking-widest text-white ">Classes</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-y-10 gap-x-6 border-t border-gray-800/60 pt-10">
                        <div class="space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Né(e) le</p>
                            <p id="user-birth-info" class="text-base font-semibold text-gray-100"></p>
                        </div>

                        <div class="space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Genre</p>
                            <p id="user-gender" class="text-base font-semibold text-gray-100 uppercase"></p>
                        </div>

                        <div class="space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Téléphone</p>
                            <p id="user-phone" class="text-base font-semibold text-gray-100"></p>
                        </div>

                        <div class="space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Ville</p>
                            <p id="user-address" class="text-base font-semibold text-gray-100 uppercase"></p>
                        </div>

                        <div class="col-span-2 space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Email Académique</p>
                            <p id="user-email" class="text-base font-bold text-amber-500/90 truncate"></p>
                        </div>

                        <div class="col-span-2 space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Date d'inscription</p>
                            <p id="user-joined" class="text-base font-semibold text-gray-400 italic"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center w-full">
        <div class="flex w-full md:w-fit bg-gray-950 p-1.5 rounded-2xl border border-gray-900 shadow-inner">
            <button onclick="switchTab(event, 'notes')"
                class="tab-btn flex-1 md:flex-none px-4 md:px-12 py-3.5 rounded-xl font-black text-[10px] md:text-[11px] uppercase tracking-[0.2em] transition-all bg-amber-500 text-black shadow-lg">
                Notes
            </button>
            <button onclick="switchTab(event, 'absence')"
                class="tab-btn flex-1 md:flex-none px-4 md:px-12 py-3.5 rounded-xl font-black text-[10px] md:text-[11px] uppercase tracking-[0.2em] transition-all text-gray-500 hover:text-white">
                Absence
            </button>
            <button onclick="switchTab(event, 'devoir')"
                class="tab-btn flex-1 md:flex-none px-4 md:px-12 py-3.5 rounded-xl font-black text-[10px] md:text-[11px] uppercase tracking-[0.2em] transition-all text-gray-500 hover:text-white">
                Devoir
            </button>
        </div>
    </div>

    <div id="tab-container" class="mt-4">
        <div id="notes" class="tab-content transition-all duration-300">
            <div id="notes-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="animate-pulse bg-gray-900/50 h-44 rounded-2xl border border-gray-800"></div>
            </div>
        </div>

        <div id="absence" class="tab-content hidden opacity-0 transition-all duration-300">
            <div class="bg-gray-900 border border-gray-800 p-8 rounded-3xl w-full shadow-xl">
                <div class="flex items-center justify-between mb-10 pb-6 border-b border-gray-800/50">
                    <button id="prev-month" class="p-3 hover:bg-gray-800 rounded-xl transition-all text-amber-500 border border-transparent hover:border-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <span id="current-month-display" class="text-xs font-black uppercase tracking-[0.4em] text-white"></span>

                    <button id="next-month" class="p-3 hover:bg-gray-800 rounded-xl transition-all text-amber-500 border border-transparent hover:border-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <div id="absence-calendar" class="grid grid-cols-7 gap-4"></div>

                <div class="mt-10 pt-8 border-t border-gray-800/50 flex gap-8">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.4)]"></span>
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Injustifié</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.4)]"></span>
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Justifié</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="devoir" class="tab-content hidden opacity-0 transition-all duration-300">
            <div id="devoirs-container" class="grid grid-cols-1 lg:grid-cols-2 gap-8"></div>
        </div>
    </div>
</div>
@endsection
