@extends('layouts.student')
@section('title', 'Mes Devoirs - School-Way')

@section('content')

@vite(['resources/js/student/devoirs.js'])

<div class="w-full h-full p-6 md:p-12 text-white">
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Header de la page -->
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black uppercase tracking-tighter">Travaux à venir</h2>
            <span class="text-[10px] bg-gray-800 px-3 py-1 rounded-full text-gray-400 font-bold tracking-widest uppercase">
                Mode Liste
            </span>
        </div>

        <!-- Conteneur des Cards -->
        <div id="devoirs-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Rempli par devoirs.js -->
            <div class="col-span-full py-20 text-center animate-pulse text-gray-500 uppercase font-black text-xs tracking-widest">
                Chargement des devoirs...
            </div>
        </div>

    </div>
</div>

@endsection
