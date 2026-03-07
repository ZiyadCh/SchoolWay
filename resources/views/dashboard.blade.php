@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-amber-600/40 transition-all duration-300 group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Élèves</p>
                    <p class="text-3xl font-bold mt-1 group-hover:text-amber-400 transition-colors">1 248</p>
                </div>
                <div class="bg-emerald-500/10 text-emerald-400 p-3 rounded-xl">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-amber-600/40 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Paiements</p>
                    <p class="text-3xl font-bold mt-1">92%</p>
                </div>
                <div class="bg-amber-500/10 text-amber-500 p-3 rounded-xl">
                    <i class="fa-solid fa-hand-holding-dollar text-lg"></i>
                </div>
            </div>
            <div class="mt-4 h-1.5 bg-gray-800 rounded-full overflow-hidden">
                <div class="h-full w-[92%] bg-amber-500 rounded-full"></div>
            </div>
            <p class="text-[10px] text-gray-500 mt-2 font-medium">100 règlements en retard</p>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-amber-600/40 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Revenu réalisés </p>
                    <p class="text-3xl font-bold mt-1 truncate">100,000 <span class="text-sm font-normal text-amber-500">MAD</span></p>
                </div>
                <div class="bg-blue-500/10 text-blue-400 p-3 rounded-xl">
                    <i class="fa-solid fa-sack-dollar text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-amber-600/40 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Classes</p>
                    <p class="text-3xl font-bold mt-1">38</p>
                </div>
                <div class="bg-purple-500/10 text-purple-400 p-3 rounded-xl">
                    <i class="fa-solid fa-chalkboard-user text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <i class="fa-solid fa-calendar-day text-amber-500"></i>
                Calendrier – Mars 2026
            </h3>
            <div class="flex gap-2">
                <button class="flex-1 sm:flex-none p-2.5 bg-gray-800 hover:bg-gray-700 rounded-xl text-sm transition"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="flex-1 sm:flex-none p-2.5 bg-gray-800 hover:bg-gray-700 rounded-xl text-sm transition"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="min-w-[400px] grid grid-cols-7 gap-1 text-center text-sm">
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Dim</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Lun</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Mar</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Mer</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Jeu</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Ven</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Sam</div>

                <div class="text-gray-700 py-3">26</div><div class="text-gray-700 py-3">27</div><div class="text-gray-700 py-3">28</div>
                <div class="py-3 hover:bg-gray-800 rounded-xl transition cursor-pointer">1</div>
                <div class="py-3 hover:bg-gray-800 rounded-xl transition cursor-pointer">2</div>
                <div class="py-3 border border-amber-500/30 text-amber-500 font-bold rounded-xl">3</div>
                <div class="bg-amber-600 text-black font-bold py-3 rounded-xl shadow-lg shadow-amber-600/20">4</div>
                <div class="py-3 hover:bg-gray-800 rounded-xl transition cursor-pointer">5</div>
                <div class="py-3 font-semibold text-white">6</div>
                <div class="py-3">7</div><div class="py-3">8</div><div class="py-3">9</div><div class="py-3">10</div><div class="py-3">11</div>
            </div>
        </div>
    </div>
@endsection
