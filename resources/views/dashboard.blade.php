@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    {{-- Top Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        @php
            $stats = [
                ['label' => 'Élèves', 'value' => '1248', 'icon' => 'fa-users', 'color' => 'emerald'],
                ['label' => 'Paiements', 'value' => '92%', 'icon' => 'fa-hand-holding-dollar', 'color' => 'amber', 'progress' => 92],
                ['label' => 'Revenu réalisés', 'value' => '100,300', 'unit' => 'MAD', 'icon' => 'fa-sack-dollar', 'color' => 'blue'],
                ['label' => 'Classes', 'value' => '38', 'icon' => 'fa-chalkboard-user', 'color' => 'purple'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 hover:border-amber-500/30 transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">{{ $stat['label'] }}</p>
                    <p class="text-3xl font-black mt-1 group-hover:text-amber-500 transition-colors">
                        {{ $stat['value'] }}@if(isset($stat['unit']))<span class="text-xs ml-1 text-amber-500">{{ $stat['unit'] }}</span>@endif
                    </p>
                </div>
                <div class="bg-{{ $stat['color'] }}-500/10 text-{{ $stat['color'] }}-400 p-3 rounded-lg border border-{{ $stat['color'] }}-500/20">
                    <i class="fa-solid {{ $stat['icon'] }} text-lg"></i>
                </div>
            </div>
            @if(isset($stat['progress']))
                <div class="mt-4 h-1 bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-amber-500 rounded-full shadow-[0_0_8px_#f59e0b]" style="width: {{ $stat['progress'] }}%"></div>
                </div>
            @endif
        </div>
        @endforeach
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Ratio Homme/Femme --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 shadow-2xl">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="text-lg font-black uppercase tracking-tight">Répartition par Genre</h3>
                </div>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-sm bg-blue-500"></span>
                        <span class="text-[11px] font-black text-gray-500 uppercase">Garçons</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-sm bg-pink-500"></span>
                        <span class="text-[11px] font-black text-gray-500 uppercase">Filles</span>
                    </div>
                </div>
            </div>

            <div class="relative h-12 bg-gray-950 rounded-lg border border-gray-800 flex overflow-hidden p-1">
                <div class="h-full bg-blue-500/90 rounded-md flex items-center justify-center transition-all hover:brightness-110 shadow-[0_0_15px_#3b82f630]" style="width: 58%">
                    <span class="text-[14px] font-black text-white">58%</span>
                </div>
                <div class="h-full bg-pink-500/90 rounded-md flex items-center justify-center transition-all hover:brightness-110 ml-1 shadow-[0_0_15px_#ec489930]" style="width: 42%">
                    <span class="text-[14px] font-black text-white">42%</span>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-4">
                <div class="bg-gray-950/50 border border-gray-800/50 p-4 rounded-lg">
                    <p class="text-[9px] font-black text-gray-600 uppercase">Total Garçons</p>
                    <p class="text-xl font-black text-blue-400 mt-1">724</p>
                </div>
                <div class="bg-gray-950/50 border border-gray-800/50 p-4 rounded-lg">
                    <p class="text-[9px] font-black text-gray-600 uppercase">Total Filles</p>
                    <p class="text-xl font-black text-pink-400 mt-1">524</p>
                </div>
            </div>
        </div>


    </div>
@endsection
