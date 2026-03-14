@extends('layouts.app')

@section('title', 'Profil Étudiant - Ahmed Mansouri')

@section('content')

<div class="max-w-7xl mx-auto space-y-8 text-white pb-20 scrollbar-hide">

    <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl flex items-center gap-6 ">
        <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-800 border border-amber-500/20 p-1 ">
            <img src="https://picsum.photos/200/300?grayscale" alt="student pfp" class="w-full h-full object-cover rounded-full">
        </div>
        <div>
            <h2 class="text-2xl font-black uppercase tracking-tight">Ahmed Mansouri</h2>
            <p class="text-amber-500/60 text-[14px] font-black uppercase mt-0.5">2 Bac Sc. Physiques • Matricule #8824</p>
        </div>
    </div>

    <div class="flex justify-center w-full">
        <div class="flex gap-2 bg-gray-950 p-1.5 rounded-xl border border-gray-900 w-fit ">
            <button onclick="switchTab(event, 'notes')" class="tab-btn px-10 py-3 rounded-lg font-black text-[11px] uppercase tracking-[0.2em] transition-all bg-amber-500 text-black ">
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

    {{-- Conteneurs de contenu --}}
    <div id="tab-container">

        {{-- SECTION: NOTES --}}
        <div id="notes" class="tab-content transition-all duration-300">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- Card 1 --}}
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl flex flex-col justify-between h-40 hover:border-amber-500/30 transition-all group ">
                    <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest leading-tight group-hover:text-white">Analyse Mathématique</h3>
                    <div class="flex justify-between items-end">
                        <span class="text-3xl font-black text-amber-500 tracking-tighter">18.50</span>
                        <span class="text-[9px] font-black text-gray-700 uppercase tracking-widest mb-1">12 Mars</span>
                    </div>
                </div>
                {{-- Card 2 --}}
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl flex flex-col justify-between h-40 hover:border-amber-500/30 transition-all group ">
                    <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest leading-tight group-hover:text-white">Physique Nucléaire</h3>
                    <div class="flex justify-between items-end">
                        <span class="text-3xl font-black text-amber-500 tracking-tighter">14.00</span>
                        <span class="text-[9px] font-black text-gray-700 uppercase tracking-widest mb-1">05 Mars</span>
                    </div>
                </div>
                {{-- Card 3 --}}
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl flex flex-col justify-between h-40 hover:border-amber-500/30 transition-all group ">
                    <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest leading-tight group-hover:text-white">Génétique SVT</h3>
                    <div class="flex justify-between items-end">
                        <span class="text-3xl font-black text-amber-500 tracking-tighter">16.25</span>
                        <span class="text-[9px] font-black text-gray-700 uppercase tracking-widest mb-1">02 Mars</span>
                    </div>
                </div>
                {{-- Card 4 --}}
                <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl flex flex-col justify-between h-40 hover:border-amber-500/30 transition-all group ">
                    <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest leading-tight group-hover:text-white">Philosophie Moderne</h3>
                    <div class="flex justify-between items-end">
                        <span class="text-3xl font-black text-amber-500 tracking-tighter">15.00</span>
                        <span class="text-[9px] font-black text-gray-700 uppercase tracking-widest mb-1">28 Fév</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION: ABSENCE --}}
        <div id="absence" class="tab-content hidden opacity-0 transition-all duration-300">
            <div class="bg-gray-900 border border-gray-800 p-8 rounded-xl w-full ">
                <div class="grid grid-cols-7 gap-3">
                    @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                        <div class="text-center text-[10px] font-black text-gray-700 uppercase tracking-[0.2em] mb-4">{{ $day }}</div>
                    @endforeach

                    @for ($i = 1; $i <= 31; $i++)
                        @php
                            $status = match($i) {
                                2, 15 => 'unjustified',
                                12, 28 => 'justified',
                                default => 'none'
                            };
                        @endphp
                        <div class="h-16 flex flex-col items-center justify-center rounded-lg border {{ $status === 'justified' ? 'bg-amber-500/10 border-amber-500/50 text-amber-500' : ($status === 'unjustified' ? 'bg-red-500/10 border-red-500/50 text-red-500' : 'border-gray-800/40 text-gray-600') }}">
                            <span class="text-lg font-black">{{ $i }}</span>
                            @if($status !== 'none')
                                <span class="text-[7px] uppercase font-black tracking-tighter mt-1">{{ $status === 'justified' ? 'Justifié' : 'Absent' }}</span>
                            @endif
                        </div>
                    @endfor
                </div>

                <div class="mt-8 pt-6 border-t border-gray-800/50 flex justify-between items-center">
                    <div class="flex gap-6">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 "></span>
                            <span class="text-[9px] font-black text-gray-600 uppercase tracking-widest">Injustifié</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-[0_0_8px_#f59e0b]"></span>
                            <span class="text-[9px] font-black text-gray-600 uppercase tracking-widest">Justifié</span>
                        </div>
                    </div>
                    <span class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500">Mars 2026</span>
                </div>
            </div>
        </div>

        {{-- SECTION: DEVOIR --}}
        <div id="devoir" class="tab-content hidden opacity-0 transition-all duration-300">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Devoir 1 --}}
                <div class="relative bg-gray-900 rounded-xl p-10 pl-20 border border-gray-800 shadow-2xl group overflow-hidden">
                    <div class="absolute left-6 top-0 bottom-0 flex flex-col justify-around py-10">
                        @for ($i = 0; $i < 5; $i++) <div class="w-4 h-4 rounded-full bg-gray-950 border-2 border-gray-800 group-hover:border-amber-500/30 transition-colors"></div> @endfor
                    </div>
                    <span class="text-[14px] font-black text-amber-500 uppercase mb-4 block">M. Alaoui</span>
                    <p class="text-xl font-black text-gray-100 leading-tight">Exercices 4 et 5 de la Série 2 sur la thermodynamique. Précision sur les calculs d'entropie exigée.</p>
                    <div class="mt-8 flex items-center gap-4">
                        <div class="h-px w-10 bg-red-500/50"></div>
                        <span class="text-[12px] font-black text-red-500 uppercase tracking-widest">Limite : 15 Mars 2026</span>
                    </div>
                </div>

                {{-- Devoir 2 --}}
                <div class="relative bg-gray-900 rounded-xl p-10 pl-20 border border-gray-800 shadow-2xl group overflow-hidden">
                    <div class="absolute left-6 top-0 bottom-0 flex flex-col justify-around py-10">
                        @for ($i = 0; $i < 5; $i++) <div class="w-4 h-4 rounded-full bg-gray-950 border-2 border-gray-800 group-hover:border-amber-500/30 transition-colors"></div> @endfor
                    </div>
                    <span class="text-[14px] font-black text-amber-500 uppercase mb-4 block">Mme. Bennani</span>
                    <p class="text-xl font-black text-gray-100 leading-tight">Dissertation Philo : "La relation entre la conscience et l'inconscient". Introduction et plan détaillé.</p>
                    <div class="mt-8 flex items-center gap-4">
                        <div class="h-px w-10 bg-red-500/50"></div>
                        <span class="text-[12px] font-black text-red-500 uppercase tracking-widest">Limite : 20 Mars 2026</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

    <script src ="{{ asset('js/tab.js') }}">

    </script>

@endsection
