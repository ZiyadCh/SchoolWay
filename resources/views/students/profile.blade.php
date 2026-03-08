@extends('layouts.app')

@section('title', 'Profil Étudiant')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 text-white pb-20">

    <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl flex items-center gap-6 shadow-2xl">
        <div class="w-16 h-16 rounded-lg bg-gray-800 border border-amber-500/20 p-1 shadow-inner">
            <img src="https://imgs.search.brave.com/ga1XYA-Gv_ZxrF3opOXO0WKaZVWzcTArBM-0KgmCDRY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/bWVtZXBmcC5jb20v/X25leHQvaW1hZ2U/P3VybD1odHRwczov/L2Nkbi5tZW1lcGZw/LmNvbS9wZnAtZm9y/LXNjaG9vbCZ3PTE5/MjAmcT03NQ"
                 class="w-full h-full object-cover rounded-md">
        </div>
        <div>
            <h2 class="text-2xl font-black uppercase tracking-tighter">Ahmed Mansouri</h2>
            <p class="text-amber-500/60 text-[10px] font-black uppercase tracking-[0.3em] mt-0.5">2 Bac Sc. Physiques</p>
        </div>
    </div>

    <div class="flex justify-center w-full">
        <div class="flex gap-2 bg-gray-950 p-1.5 rounded-xl border border-gray-900 w-fit shadow-2xl">
            @foreach(['notes' => 'Notes', 'absence' => 'Absence', 'devoir' => 'Devoir'] as $key => $label)
                <a href="?tab={{ $key }}"
                   class="px-10 py-3 rounded-lg font-black text-[11px] uppercase tracking-[0.2em] transition-all {{ $tab === $key ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'text-gray-500 hover:text-white' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

        {{-- notes tab --}}
    @if($tab === 'notes')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
            $exams = [
                ['title' => 'Analyse Mathématique', 'grade' => '18.50', 'date' => '12 Mars'],
                ['title' => 'Physique Nucléaire', 'grade' => '14.00', 'date' => '05 Mars'],
                ['title' => 'Génétique SVT', 'grade' => '16.25', 'date' => '02 Mars'],
                ['title' => 'Philosophie Moderne', 'grade' => '15.00', 'date' => '28 Fév']
            ];
        @endphp

        @foreach($exams as $exam)
        <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl flex flex-col justify-between h-40 hover:border-amber-500/30 transition-all group shadow-lg">
            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest leading-tight group-hover:text-white">{{ $exam['title'] }}</h3>
            <div class="flex justify-between items-end">
                <span class="text-3xl font-black text-amber-500 tracking-tighter">{{ $exam['grade'] }}</span>
                <span class="text-[9px] font-black text-gray-700 uppercase tracking-widest mb-1">{{ $exam['date'] }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

        {{-- absence tab --}}
    @if($tab === 'absence')
    <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl w-full shadow-2xl">
        @php
            $absences = [2 => 'unjustified', 12 => 'justified', 15 => 'unjustified', 28 => 'justified'];
            $currentMonth = request('month', 'Mars');
        @endphp

        <div class="grid grid-cols-7 gap-3">
            @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                <div class="text-center text-[10px] font-black text-gray-700 uppercase tracking-[0.2em] mb-4">{{ $day }}</div>
            @endforeach

            @for ($i = 1; $i <= 31; $i++)
                <div class="h-16 flex flex-col items-center justify-center rounded-lg transition-all border {{ isset($absences[$i]) ? ($absences[$i] === 'justified' ? 'bg-amber-500/10 border-amber-500/50 text-amber-500' : 'bg-red-500/10 border-red-500/50 text-red-500') : 'border-gray-800/40 text-gray-600 hover:bg-gray-800/50 hover:text-gray-400' }}">
                    <span class="text-lg font-black leading-none">{{ $i }}</span>
                    @if(isset($absences[$i]))
                        <span class="text-[7px] uppercase font-black tracking-tighter mt-1 opacity-80">{{ $absences[$i] === 'justified' ? 'Justifié' : 'Absent' }}</span>
                    @endif
                </div>
            @endfor
        </div>

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

            <details class="group">
                <summary class="list-none cursor-pointer">
                    <div class="flex items-center gap-3 bg-gray-800/50 hover:bg-amber-500 hover:text-black px-5 py-2.5 rounded-xl transition-all border border-gray-800 group-open:bg-amber-500 group-open:text-black shadow-lg">
                        <span class="text-[11px] font-black uppercase tracking-[0.2em]">{{ $currentMonth }} 2026</span>
                        <svg class="w-3.5 h-3.5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </summary>
                <div class="absolute bottom-full right-0 mb-4 grid grid-cols-3 gap-2 bg-gray-950 border border-gray-800 p-4 rounded-xl z-50 w-72 shadow-2xl">
                    @foreach(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'] as $m)
                        <a href="?tab=absence&month={{ $m }}" class="text-[9px] font-black uppercase p-2 rounded-md text-center transition-all {{ $currentMonth == $m ? 'bg-amber-500 text-black' : 'text-gray-500 hover:bg-gray-800 hover:text-white' }}">
                            {{ $m }}
                        </a>
                    @endforeach
                </div>
            </details>
        </div>
    </div>
    @endif

        {{-- devoir tab --}}
    @if($tab === 'devoir')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @php
            $devoirs = [
                ['teacher' => 'M. Alaoui', 'task' => 'Compléter les exercices 4 et 5 de la Série 2 sur la thermodynamique des systèmes ouverts. Attention à la précision des calculs d\'entropie.', 'deadline' => '15 Mars 2026'],
                ['teacher' => 'Mme. Bennani', 'task' => 'Rédaction de la dissertation sur la relation entre la conscience et l’inconscient. Se concentrer sur l\'introduction et le plan détaillé.', 'deadline' => '20 Mars 2026'],
            ];
        @endphp

        @foreach($devoirs as $devoir)
        <div class="relative bg-gray-900 rounded-2xl p-10 pl-20 border border-gray-800 shadow-2xl hover:border-amber-500/20 transition-all group overflow-hidden">
            <div class="absolute left-6 top-0 bottom-0 flex flex-col justify-around py-10">
                @for ($i = 0; $i < 5; $i++)
                    <div class="w-4 h-4 rounded-full bg-gray-950 border-2 border-gray-800 shadow-inner group-hover:border-amber-500/30 transition-colors"></div>
                @endfor
            </div>

            <div class="flex flex-col h-full min-h-[180px] justify-center">
                <span class="text-[14px] font-black text-amber-500 uppercase mb-6">{{ $devoir['teacher'] }}</span>
                <div class="grow">
                    <p class="text-xl font-black text-gray-100 font-light ">{{ $devoir['task'] }} </p>
                </div>
                <div class="mt-8 flex items-center gap-4">
                    <div class="h-px w-10 bg-red-400"></div>
                    <span class="text-[18px] text-red-400 uppercase ">Date de limite : {{ $devoir['deadline'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
