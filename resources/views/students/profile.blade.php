@extends('layouts.app')

@section('title', 'Profil Étudiant')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 text-white">
    <div class="bg-gray-900 border border-gray-800 p-6 rounded-[2rem] flex items-center gap-5">
        <div class="w-14 h-14 rounded-2xl bg-gray-800 border border-amber-500/20 p-1">
            <img src="https://imgs.search.brave.com/ga1XYA-Gv_ZxrF3opOXO0WKaZVWzcTArBM-0KgmCDRY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/bWVtZXBmcC5jb20v/X25leHQvaW1hZ2U/P3VybD1odHRwczov/L2Nkbi5tZW1lcGZw/LmNvbS9wZnAtZm9y/LXNjaG9vbCZ3PTE5/MjAmcT03NQ" class="w-full h-full object-cover rounded-xl">
        </div>
        <div>
            <h2 class="text-xl font-black uppercase tracking-tight">Ahmed Mansouri</h2>
            <p class="text-gray-600 text-[9px] font-black uppercase tracking-widest">2 Bac Sc. Physiques</p>
        </div>
    </div>

    <div class="flex gap-2 bg-gray-950 p-1 rounded-xl border border-gray-900 w-fit">
        <a href="?tab=notes" class="px-5 py-2 rounded-lg font-black text-[9px] uppercase tracking-widest transition-all {{ $tab === 'notes' ? 'bg-amber-500 text-black' : 'text-gray-500 hover:text-white' }}">
            Notes
        </a>
        <a href="?tab=absence" class="px-5 py-2 rounded-lg font-black text-[9px] uppercase tracking-widest transition-all {{ $tab === 'absence' ? 'bg-amber-500 text-black' : 'text-gray-500 hover:text-white' }}">
            Absence
        </a>
        <a href="?tab=devoir" class="px-5 py-2 rounded-lg font-black text-[9px] uppercase tracking-widest transition-all {{ $tab === 'devoir' ? 'bg-amber-500 text-black' : 'text-gray-500 hover:text-white' }}">
            Devoir
        </a>
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

{{-- Contenu Absence --}}
@if($tab === 'absence')
<div class="space-y-6">
    <div class="bg-gray-900 border border-gray-800 p-6 rounded-[2rem] max-w-md">
        <div class="flex justify-between items-center mb-6 px-2">
            <h3 class="text-xs font-black uppercase tracking-widest text-amber-500">Mars 2026</h3>
            <div class="flex gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    <span class="text-[9px] font-black uppercase text-gray-500">Absent</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-2 text-center">
            @foreach(['L', 'M', 'M', 'J', 'V', 'S', 'D'] as $day)
                <span class="text-[10px] font-black text-gray-700 pb-2">{{ $day }}</span>
            @endforeach

            @for ($i = 1; $i <= 31; $i++)
                @php
                    // Simulation : absent le 2 et le 12
                    $isAbsent = in_array($i, [2, 12]);
                @endphp
                <div class="aspect-square flex items-center justify-center rounded-xl text-[10px] font-black transition-all
                    {{ $isAbsent
                        ? 'bg-red-500/10 border border-red-500/20 text-red-500 shadow-lg shadow-red-500/5'
                        : 'text-gray-500 hover:bg-gray-800' }}">
                    {{ $i }}
                </div>
            @endfor
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-gray-900 border border-gray-800 p-5 rounded-3xl flex justify-between items-center">
            <div>
                <span class="text-[9px] font-black text-red-500 uppercase tracking-widest block">02 Mars</span>
                <h3 class="text-xs font-black text-white uppercase">Anglais (08:00 - 10:00)</h3>
            </div>
            <span class="text-[8px] font-black py-1 px-3 bg-red-500/10 border border-red-500/20 text-red-500 rounded-lg uppercase">Non Justifié</span>
        </div>
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
