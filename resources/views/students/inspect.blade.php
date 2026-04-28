@extends('layouts.app')
@section('title', 'Profil Étudiant')

@section('content')
@vite(['resources/js/tab.js','resources/js/student/inspect.js'])

<div class="max-w-7xl mx-auto space-y-8 text-white pb-20 scrollbar-hide">

    <div class="max-w-8xl mx-auto bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl">
        <div class="p-8 md:p-12">
            <div class="flex flex-col lg:flex-row items-center lg:items-start gap-10">

                <div class="shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden bg-gray-800 border border-gray-700 p-1">
                        <img id="user-avatar" src="" alt="pfp" class="w-full h-full object-cover rounded-xl bg-gray-800">
                    </div>
                </div>

                <div class="flex-1 w-full">
                    <div class="mb-8 text-center lg:text-left">
                        <h2 id="user-fullname" class="text-4xl md:text-5xl font-black uppercase tracking-tighter text-white">CHARGEMENT...</h2>
                        <p class="text-amber-500 text-xs font-black uppercase tracking-widest mt-2 italic">
                            <span id="user-class"></span> <span id="user-id-prefix">MATRICULE: #</span><span id="user-id"></span>
                        </p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-y-8 gap-x-4 border-t border-gray-800 pt-8">
                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Né(e) le</p>
                            <p id="user-birth-info" class="text-sm md:text-base font-bold text-gray-200"></p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Genre</p>
                            <p id="user-gender" class="text-sm md:text-base font-bold text-gray-200 uppercase"></p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Téléphone</p>
                            <p id="user-phone" class="text-sm md:text-base font-bold text-gray-200"></p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Ville</p>
                            <p id="user-address" class="text-sm md:text-base font-bold text-gray-200 uppercase"></p>
                        </div>

                        <div class="col-span-2 space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Email Académique</p>
                            <p id="user-email" class="text-sm md:text-base font-bold text-amber-500/90 truncate uppercase tracking-tight"></p>
                        </div>

                        <div class="col-span-2 space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Date d'inscription</p>
                            <p id="user-joined" class="text-sm md:text-base font-bold text-gray-200 uppercase italic"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center w-full">
        <div class="flex gap-2 bg-gray-950 p-1.5 rounded-xl border border-gray-900 w-fit">
            <button onclick="switchTab(event, 'notes')" class="tab-btn px-10 py-3 rounded-lg font-black text-[11px] uppercase tracking-[0.2em] transition-all bg-amber-500 text-black">
                Notes
            </button>
            <button onclick="switchTab(event, 'absence')" class="tab-btn px-10 py-3 rounded-lg font-black text-[11px] uppercase tracking-[0.2em] transition-all text-gray-500 hover:text-white">
                Absence
            </button>
            <button onclick="switchTab(event, 'devoir')" class="tab-btn px-10 py-3 rounded-lg font-black text-[11px] uppercase tracking-[0.2em] transition-all text-gray-500 hover:text-white">
                Devoir
            </button>
        </div>
    </div>

    <div id="tab-container">

        <div id="notes" class="tab-content transition-all duration-300">
            <div id="notes-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="animate-pulse bg-gray-900/50 h-40 rounded-xl border border-gray-800"></div>
            </div>
        </div>

        <div id="absence" class="tab-content hidden opacity-0 transition-all duration-300">
            <div class="bg-gray-900 border border-gray-800 p-8 rounded-xl w-full">
                <div id="absence-calendar" class="grid grid-cols-7 gap-3">
                    @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                        <div class="text-center text-[10px] font-black text-gray-700 uppercase tracking-[0.2em] mb-4">{{ $day }}</div>
                    @endforeach
                </div>

                <div class="mt-8 pt-6 border-t border-gray-800/50 flex justify-between items-center">
                    <div class="flex gap-6">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            <span class="text-[9px] font-black text-gray-600 uppercase tracking-widest">Injustifié</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span class="text-[9px] font-black text-gray-600 uppercase tracking-widest">Justifié</span>
                        </div>
                    </div>
                    <span id="current-month-display" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500"></span>
                </div>
            </div>
        </div>

        <div id="devoir" class="tab-content hidden opacity-0 transition-all duration-300">
            <div id="devoirs-container" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            </div>
        </div>

    </div>
</div>
@endsection
