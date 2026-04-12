@extends('layouts.app')

@section('title', 'Gestion des Classes')

@section('content')
    <div class="space-y-8 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div>
                <h2 class="text-4xl font-black text-white ">Gestion des Classes</h2>
            </div>
            <buaton class="bg-amber-500 hover:bg-amber-600 text-black font-black py-4 px-8 rounded-2xl transition-all flex items-center gap-3 active:scale-95 text-sm uppercase ">
                <i class="fa-solid fa-plus text-lg"></i>
                <span>Nouvelle Classe</span>
            </button>
        </div>

        <div class="bg-gray-900 border border-gray-800 p-4 rounded-4xl flex flex-col lg:flex-row gap-4">
            <div class="relative flex-1 group">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-amber-500 transition-colors"></i>
                <input type="text" placeholder="Rechercher une classe ou un professeur..."
                    class="w-full bg-gray-950 border border-gray-800 text-gray-300 py-4 pl-14 pr-6 rounded-2xl focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/20 transition-all text-sm">
            </div>

            <div class="flex flex-wrap sm:flex-nowrap gap-4">
                <select class="bg-gray-950 border border-gray-800 text-gray-400 py-4 px-6 rounded-2xl focus:outline-none focus:border-amber-500/50 transition-all min-w-5 cursor-pointer text-sm font-bold">
                    <option value="">Tous les Niveaux</option>
                    <option value="primaire">Primaire</option>
                    <option value="college">Collège</option>
                    <option value="lycee">Lycée / Bac</option>
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
                            <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">Classe</th>
                            <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">Niveau</th>
                            <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">NBr Élèves</th>
                            <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">Maître</th>
                            <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest text-right">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <tr class="hover:bg-gray-800/20 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="font-bold text-white group-hover:text-amber-400 transition-colors">2BAC-SP | G1</div>
                                <span class="text-[10px] text-gray-600 font-bold uppercase tracking-tighter">Année 2025-2026</span>
                            </td>
                            <td class="px-8 py-6 text-sm font-medium text-gray-300">2ème Année Baccalauréat</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1.5 bg-blue-500/10 text-blue-400 rounded-xl text-[10px] font-black uppercase border border-emerald-500/20">
                                    32 Élèves
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 overflow-hidden rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center">
                                    <div class="w-8 h-8 overflow-hidden rounded-full bg-amber-500/20 border border-amber-500/50 flex items-center justify-center text-[10px] font-black text-amber-500"><img src="https://imgs.search.brave.com/jd4laeASdzY2PIWOM5WB16nfYMwz_p9Zlzv99r9CxJM/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly90aHVt/YnMuZHJlYW1zdGlt/ZS5jb20vYi9hc2lh/bi1zY2hvb2wtdGVh/Y2hlci1oYXBweS1t/YWxlLWVsZW1lbnRh/cnktY2xhc3Nyb29t/LTMyNTU1NzM0Lmpw/Zw" class="w-full h-full object-cover" alt=""></div>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-300">Prof. Alami</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all"><i class="fa-solid fa-circle-info text-xs"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-800/20 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="font-bold text-white group-hover:text-amber-400 transition-colors">1BAC-SM | A</div>
                                <span class="text-[10px] text-gray-600 font-bold uppercase tracking-tighter">Année 2025-2026</span>
                            </td>
                            <td class="px-8 py-6 text-sm font-medium text-gray-300">1ère Année Baccalauréat</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1.5 bg-blue-500/10 text-blue-400 rounded-xl text-[10px] font-black uppercase border border-blue-500/20">
                                    28 Élèves
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 overflow-hidden rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center">
                                    <div class="w-8 h-8 overflow-hidden rounded-full bg-amber-500/20 border border-amber-500/50 flex items-center justify-center text-[10px] font-black text-amber-500"><img src="https://imgs.search.brave.com/jd4laeASdzY2PIWOM5WB16nfYMwz_p9Zlzv99r9CxJM/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly90aHVt/YnMuZHJlYW1zdGlt/ZS5jb20vYi9hc2lh/bi1zY2hvb2wtdGVh/Y2hlci1oYXBweS1t/YWxlLWVsZW1lbnRh/cnktY2xhc3Nyb29t/LTMyNTU1NzM0Lmpw/Zw" class="w-full h-full object-cover" alt=""></div>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-300">Prof. Bennani</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all"><i class="fa-solid fa-circle-info text-xs"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

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
