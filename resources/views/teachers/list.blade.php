@extends('layouts.app')

@section('title', 'Gestion des Enseignants')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-4xl font-black text-white tracking-tight">Enseignants</h2>
        </div>
        <button class="bg-amber-500 hover:bg-amber-600 text-black font-black py-4 px-8 rounded-2xl transition-all flex items-center gap-3 active:scale-95 text-sm uppercase tracking-widest">
            <i class="fa-solid fa-plus text-lg"></i>
            <span>Ajouter un Enseignant</span>
        </button>
    </div>

    <div class="bg-gray-900 border border-gray-800 p-4 rounded-[2rem] flex flex-col lg:flex-row gap-4">
        <div class="relative flex-1 group">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-amber-500 transition-colors"></i>
            <input type="text" placeholder="Rechercher un professeur par nom ou matière..."
                class="w-full bg-gray-950 border border-gray-800 text-gray-300 py-4 pl-14 pr-6 rounded-2xl focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/20 transition-all">
        </div>

        <div class="flex flex-wrap sm:flex-nowrap gap-4">
            <select class="bg-gray-950 border border-gray-800 text-gray-400 py-4 px-6 rounded-2xl focus:outline-none focus:border-amber-500/50 transition-all min-w-[160px] cursor-pointer">
                <option value="">Toutes les Matières</option>
                <option value="math">Mathématiques</option>
                <option value="pc">Physique-Chimie</option>
                <option value="fr">Français</option>
                <option value="svt">SVT</option>
            </select>

            <button class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-4 rounded-2xl transition-all flex items-center gap-3 border border-gray-700">
                <i class="fa-solid fa-search text-amber-500"></i>
                <span class="font-bold text-sm">Chercher</span>
            </button>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-800/50">
                        <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">Enseignant</th>
                        <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">Matière / Spécialité</th>
                        <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">Contact</th>
                        <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest text-right">Détails</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    {{-- Enseignant 1 --}}
                    <tr class="hover:bg-gray-800/20 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center overflow-hidden">
                                    <img src="https://imgs.search.brave.com/ga1XYA-Gv_ZxrF3opOXO0WKaZVWzcTArBM-0KgmCDRY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/bWVtZXBmcC5jb20v/X25leHQvaW1hZ2Uv/P3VybD1odHRwczov/L2Nkbi5tZW1lcGZw/LmNvbS9wZnAtZm9y/LXNjaG9vbCZ3PTE5/MjAmcT03NQ" alt="Avatar" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-white group-hover:text-amber-400 transition-colors">Prof. Amine Alami</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-semibold text-gray-300">Mathématiques</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1 text-sm text-gray-400">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-[10px] text-gray-600"></i>
                                    <span>06 61 XX XX 01</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all"><i class="fa-solid fa-address-book text-xs"></i></button>
                            </div>
                        </td>
                    </tr>

                    {{-- Enseignant 2 --}}
                    <tr class="hover:bg-gray-800/20 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center overflow-hidden">
                                    <img src="https://imgs.search.brave.com/ga1XYA-Gv_ZxrF3opOXO0WKaZVWzcTArBM-0KgmCDRY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/bWVtZXBmcC5jb20v/X25leHQvaW1hZ2Uv/P3VybD1odHRwczov/L2Nkbi5tZW1lcGZw/LmNvbS9wZnAtZm9y/LXNjaG9vbCZ3PTE5/MjAmcT03NQ" alt="Avatar" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-white group-hover:text-amber-400 transition-colors">Prof. Karima Bennani</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-semibold text-gray-300">Physique-Chimie</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1 text-sm text-gray-400">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-[10px] text-gray-600"></i>
                                    <span>06 55 XX XX 44</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all"><i class="fa-solid fa-address-book text-xs"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-gray-800/30 px-8 py-6 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-6">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">
            </p>

            <div class="flex items-center gap-2">
                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-500 cursor-not-allowed border border-gray-700">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>

                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-amber-500 text-black font-black text-xs shadow-lg shadow-amber-500/20">1</button>
                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all font-bold text-xs">2</button>

                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
