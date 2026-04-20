@extends('layouts.app')

@section('title', 'Gestion des Paiements')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-4xl font-black text-white tracking-tight">Suivi des Paiements</h2>
        </div>
        <div class="flex gap-4">


        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 p-4 rounded-[2rem] flex flex-col lg:flex-row gap-4">
        <div class="relative flex-1 group">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-amber-500 transition-colors"></i>
            <input type="text" placeholder="Rechercher un élève..."
                class="w-full bg-gray-950 border border-gray-800 text-gray-300 py-4 pl-14 pr-6 rounded-2xl focus:outline-none focus:border-amber-500/50 transition-all">
        </div>

        <div class="flex flex-wrap sm:flex-nowrap gap-4">
            <select class="bg-gray-950 border border-gray-800 text-gray-400 py-4 px-6 rounded-2xl focus:outline-none cursor-pointer text-sm font-bold">
                <option value="all">Tous les Statuts</option>
                <option value="paid" class="text-emerald-500">À jour</option>
                <option value="late" class="text-red-500">En retard</option>
            </select>


        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-800/50">
                        <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">Élève</th>
                        <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">Niveau</th>
                        <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest text-center">Statut </th>
                        <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr class="hover:bg-gray-800/20 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center overflow-hidden">
                                    <img src="https://imgs.search.brave.com/ga1XYA-Gv_ZxrF3opOXO0WKaZVWzcTArBM-0KgmCDRY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/bWVtZXBmcC5jb20v/X25leHQvaW1hZ2Uv/P3VybD1odHRwczov/L2Nkbi5tZW1lcGZw/LmNvbS9wZnAtZm9y/LXNjaG9vbCZ3PTE5/MjAmcT03NQ" alt="Avatar" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <span class="font-bold text-white group-hover:text-amber-400 transition-colors block">Ahmed Mansouri</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm font-semibold text-gray-300">2 Bac</td>
                        <td class="px-8 py-6 text-center">
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500/10 text-emerald-400 rounded-full text-[10px] font-black uppercase border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    à jour
                            </span>
                        </td>

                        <td class="px-8 py-6 text-right">
                            <a href="" class="bg-amber-500/10 hover:text-amber-500  font-black text-[10px] uppercase px-4 py-2 rounded-xl transition-all border border-amber-500/20">
                                <i class="fa-solid fa-address-book text-xs"></i>
                            </a>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-800/20 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center overflow-hidden">
                                    <img src="https://imgs.search.brave.com/ga1XYA-Gv_ZxrF3opOXO0WKaZVWzcTArBM-0KgmCDRY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/bWVtZXBmcC5jb20v/X25leHQvaW1hZ2Uv/P3VybD1odHRwczov/L2Nkbi5tZW1lcGZw/LmNvbS9wZnAtZm9y/LXNjaG9vbCZ3PTE5/MjAmcT03NQ" alt="Avatar" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <span class="font-bold text-white group-hover:text-amber-400 transition-colors block">Sara Bennani</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-sm font-semibold text-gray-300">1 Bac</td>
                        <td class="px-8 py-6 text-center">
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-red-500/10 text-red-400 rounded-full text-[10px] font-black uppercase border border-red-500/20 ">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    retard
                            </span>
                        </td>

                        <td class="px-8 py-6 text-right">
                            <a href="paiments/detail" class="bg-amber-500/10 hover:text-amber-500  font-black text-[10px] uppercase px-4 py-2 rounded-xl transition-all border border-amber-500/20">
                                <i class="fa-solid fa-address-book text-xs"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="bg-gray-800/30 px-8 py-6 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-6">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">
            </p>
            <div class="flex items-center gap-2">
                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-amber-500 text-black font-black text-xs shadow-lg">1</button>
                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 border border-gray-700 font-bold text-xs">2</button>
            </div>
        </div>
    </div>
</div>
@endsection
