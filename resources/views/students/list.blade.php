@extends('layouts.app')

@section('title', 'Gérer les Élèves')

@section('content')

<div class="space-y-6 md:space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-3xl md:text-4xl font-black text-white tracking-tight">Registre des Élèves</h2>
            <p class="text-gray-500 text-sm mt-1">Gestion et suivi des inscriptions académiques</p>
        </div>
        <button class="w-full sm:w-auto bg-amber-500 hover:bg-amber-600 text-black font-black py-4 px-8 rounded-2xl transition-all flex items-center justify-center gap-3 active:scale-95 text-xs uppercase tracking-widest">
            <i class="fa-solid fa-user-plus text-lg"></i>
            <span>Inscrire un Élève</span>
        </button>
    </div>

    <div class="bg-gray-900 border border-gray-800 p-3 md:p-4 rounded-[1.5rem] md:rounded-[2rem] flex flex-col lg:flex-row gap-4">
        <div class="relative flex-1 group">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-amber-500 transition-colors"></i>
            <input type="text" placeholder="Rechercher un élève..."
                class="w-full bg-gray-950 border border-gray-800 text-gray-300 py-4 pl-14 pr-6 rounded-xl md:rounded-2xl focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/20 transition-all text-sm">
        </div>

        <div class="flex gap-3 sm:gap-4">
            <select class="flex-1 lg:flex-none bg-gray-950 border border-gray-800 text-gray-400 py-4 px-4 md:px-6 rounded-xl md:rounded-2xl focus:outline-none focus:border-amber-500/50 transition-all min-w-[140px] cursor-pointer text-sm">
                <option value="">Tous les Niveaux</option>
                <option value="1bac">1ère Année Bac</option>
                <option value="2bac">2ème Année Bac</option>
            </select>

            <button class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-4 rounded-xl md:rounded-2xl transition-all flex items-center justify-center gap-3 min-w-[56px] sm:min-w-auto">
                <i class="fa-solid fa-search text-amber-500"></i>
                <span class="hidden sm:inline font-bold text-sm">Chercher</span>
            </button>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-[1.5rem] md:rounded-[2.5rem] overflow-hidden shadow-2xl">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-gray-800/50">
                        <th class="px-6 md:px-8 py-5 text-[10px] md:text-[11px] uppercase font-bold text-gray-500 tracking-widest">Nom & Prénom</th>
                        <th class="px-4 md:px-8 py-5 text-[10px] md:text-[11px] uppercase font-bold text-gray-500 tracking-widest text-center">Genre</th>
                        <th class="px-6 md:px-8 py-5 text-[10px] md:text-[11px] uppercase font-bold text-gray-500 tracking-widest">Niveau</th>
                        <th class="md:table-cell px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">Lieu de Naissance</th>
                        <th class="px-6 md:px-8 py-5 text-[10px] md:text-[11px] uppercase font-bold text-gray-500 tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    <tr class="hover:bg-gray-800/20 transition-colors group">
                        <td class="px-6 md:px-8 py-5 md:py-6">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="w-10 h-10 md:w-11 md:h-11 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Ahmed" alt="Avatar" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-sm md:text-base text-white group-hover:text-amber-400 transition-colors truncate">Ahmed Mansouri</span>
                            </div>
                        </td>
                        <td class="px-4 md:px-8 py-5 md:py-6 text-center">
                            <span class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-blue-400 bg-blue-400/10 px-2.5 py-1 rounded-full border border-blue-400/20">M</span>
                        </td>
                        <td class="px-6 md:px-8 py-5 md:py-6 text-xs md:text-sm font-semibold text-gray-300">2 Bac</td>
                        <td class="hidden md:table-cell px-8 py-6">
                            <div class="flex items-center gap-2 text-sm text-gray-400">
                                <i class="fa-solid fa-location-dot text-[10px] text-gray-600"></i>
                                Casablanca
                            </div>
                        </td>
                        <td class="px-6 md:px-8 py-5 md:py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="#" class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg md:rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all hover:border-amber-500/50">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="bg-gray-800/30 px-6 md:px-8 py-6 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-[10px] md:text-xs font-bold text-gray-500 uppercase tracking-widest text-center sm:text-left">
                Affichage de 1 à 10 sur 42 élèves
            </p>

            <div class="flex items-center gap-1.5 md:gap-2">
                <button class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg md:rounded-xl bg-gray-800 text-gray-500 cursor-not-allowed border border-gray-700">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg md:rounded-xl bg-amber-500 text-black font-black text-xs shadow-lg shadow-amber-500/20">1</button>
                <button class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg md:rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all font-bold text-xs">2</button>
                <button class="hidden xs:flex w-9 h-9 md:w-10 md:h-10 items-center justify-center rounded-lg md:rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all font-bold text-xs">3</button>
                <span class="text-gray-600 px-1">...</span>
                <button class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg md:rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</div>


@endsection
