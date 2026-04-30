@extends('layouts.student')
@section('title', 'Mes Paiements - School-Way')

@section('content')

@vite(['resources/js/student/paiements.js'])

<div class="w-full h-full p-6 md:p-12 text-white">
    <div class="max-w-5xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black uppercase tracking-tighter">Historique des Paiements</h2>
            <div id="payment-summary" class="hidden md:flex gap-4">
            </div>
        </div>

        <div id="paiements-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="col-span-full py-20 text-center animate-pulse text-gray-500 uppercase font-black text-xs tracking-widest">
                Vérification des transactions...
            </div>
        </div>

    </div>
</div>

@endsection
