@extends('layouts.app')

@section('title', 'Profil Étudiant')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 text-white">
    <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl flex items-center gap-5">
        <div class="w-14 h-14 rounded-x1 bg-gray-800 border border-amber-500/20 p-1">
            <img src="https://imgs.search.brave.com/ga1XYA-Gv_ZxrF3opOXO0WKaZVWzcTArBM-0KgmCDRY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/bWVtZXBmcC5jb20v/X25leHQvaW1hZ2U/P3VybD1odHRwczov/L2Nkbi5tZW1lcGZw/LmNvbS9wZnAtZm9y/LXNjaG9vbCZ3PTE5/MjAmcT03NQ" class="w-full h-full object-cover rounded-xl">
        </div>
        <div>
            <h2 class="text-xl font-black uppercase tracking-tight">Ahmed Mansouri</h2>
            <p class="text-gray-600 text-[9px] font-black uppercase tracking-widest">2 Bac Sc. Physiques</p>
        </div>
    </div>

{{-- Navigation des Onglets Centrée et Agrandie --}}
    <div class="flex justify-center w-full">
        <div class="flex gap-3 bg-gray-950 p-2 rounded-x1 border border-gray-900 w-fit ">
            <a href="?tab=notes"
               class="px-10 py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.3em] transition-all {{ $tab === 'notes' ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'text-gray-500 hover:text-white' }}">
                Notes
            </a>
            <a href="?tab=absence"
               class="px-10 py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.3em] transition-all {{ $tab === 'absence' ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'text-gray-500 hover:text-white' }}">
                Absence
            </a>
            <a href="?tab=devoir"
               class="px-10 py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.3em] transition-all {{ $tab === 'devoir' ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'text-gray-500 hover:text-white' }}">
                Devoir
            </a>
        </div>
    </div>

    {{-- Contenu des Notes --}}
    @if($tab === 'notes')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $exams = [
                ['title' => 'Analyse Mathématique', 'grade' => '18.50', 'date' => '12 Mars'],
                ['title' => 'Physique Nucléaire', 'grade' => '14.00', 'date' => '05 Mars'],
                ['title' => 'Génétique SVT', 'grade' => '16.25', 'date' => '02 Mars'],
                ['title' => 'Philosophie Moderne', 'grade' => '15.00', 'date' => '28 Fév']
            ];
        @endphp

        @foreach($exams as $exam)
        <div class="bg-gray-900 border border-gray-800 p-5 rounded-3xl flex flex-col justify-between h-36 hover:border-amber-500/30 transition-all group">
            <h3 class="text-xs font-black text-gray-400 uppercase leading-tight group-hover:text-white">{{ $exam['title'] }}</h3>
            <div class="flex justify-between items-end">
                <span class="text-3xl font-black text-amber-500 tracking-tighter">{{ $exam['grade'] }}</span>
                <span class="text-sm font-black text-gray-600 uppercase tracking-widest mb-1">{{ $exam['date'] }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Tab Absence --}}
    @if($tab === 'absence')
    <div class="bg-gray-900 border border-gray-800 p-8 rounded-xl w-full">
        @php
            $absences = [
                2 => 'unjustified',
                12 => 'justified',
                15 => 'unjustified',
                28 => 'justified'
            ];
            $currentMonth = request('month', 'Mars');
        @endphp

        <div class="grid grid-cols-7 gap-3">
            @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                <div class="text-center text-[9px] font-black text-gray-700 uppercase tracking-[0.2em] mb-4">
                    {{ $day }}
                </div>
            @endforeach

            @for ($i = 1; $i <= 31; $i++)
                @if(isset($absences[$i]))
                    <div class="h-16 flex flex-col items-center justify-center rounded-x1 text-white transition-all hover:scale-[1.02]
                        {{ $absences[$i] === 'justified'
                            ? 'bg-amber-500/10 border border-amber-500/50 text-amber-500'
                            : 'bg-red-500/10 border border-red-500/50 text-red-500' }}">
                        <span class="text-lg font-black leading-none">{{ $i }}</span>
                        <span class="text-[7px] uppercase font-black tracking-tighter mt-1 opacity-80">
                            {{ $absences[$i] === 'justified' ? 'Justifié' : 'Absent' }}
                        </span>
                    </div>
                @else
                    <div class="h-16 flex items-center justify-center rounded-x1 border border-gray-800/40 text-gray-700 text-sm font-black hover:bg-gray-800/50 hover:text-gray-500 transition-all">
                        {{ $i }}
                    </div>
                @endif
            @endfor
        </div>

        {{-- Footer avec Bouton de sélection de mois --}}
        <div class="mt-8 pt-6 border-t border-gray-800/50 flex justify-between items-center relative">
            <div class="flex gap-6">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 shadow-[0_0_8px_#ef4444]"></span>
                    <span class="text-[9px] font-black text-gray-600 uppercase tracking-widest">Injustifié</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-[0_0_8px_#f59e0b]"></span>
                    <span class="text-[9px] font-black text-gray-600 uppercase tracking-widest">Justifié</span>
                </div>
            </div>

            {{-- Bouton Sélecteur de Mois --}}
            <details class="group">
                <summary class="list-none cursor-pointer">
                    <div class="flex items-center gap-3 bg-gray-800/50 hover:bg-amber-500 hover:text-black px-4 py-2 rounded-xl transition-all border border-gray-800 group-open:bg-amber-500 group-open:text-black">
                        <span class="text-[11px] font-black uppercase tracking-[0.2em]">{{ $currentMonth }} 2026</span>
                        <svg class="w-3 h-3 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </summary>
                <div class="absolute bottom-full right-0 mb-4 grid grid-cols-3 gap-2 bg-gray-950 border border-gray-800 p-4 rounded-x1  z-50 w-72">
                    @foreach(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'] as $m)
                        <a href="?tab=absence&month={{ $m }}" class="text-[9px] font-black uppercase p-2 rounded-lg text-center transition-all {{ $currentMonth == $m ? 'bg-amber-500 text-black' : 'text-gray-500 hover:bg-gray-800 hover:text-white' }}">
                            {{ $m }}
                        </a>
                    @endforeach
                </div>
            </details>
        </div>
    </div>
    @endif

    {{-- Contenu Devoir --}}
    @if($tab === 'devoir')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gray-900 border border-gray-800 p-5 rounded-3xl flex flex-col justify-between h-36">
            <h3 class="text-xs font-black text-gray-400 uppercase">Thermodynamique</h3>
            <div class="flex justify-between items-end">
                <span class="text-xs font-black text-emerald-500 uppercase">À rendre</span>
                <span class="text-sm font-black text-gray-600 uppercase tracking-widest">15 Mars</span>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
