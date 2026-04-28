@extends('layouts.app')

@section('title', 'Gestion des Classes')

@section('content')
@vite('resources/js/list/classes.js')
    <div class="space-y-8 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div>
                <h2 class="text-4xl text-white">Gestion des Classes</h2>
            </div>

                <a href="{{ route('class-form' ) }}">
            <button class="bg-amber-500 hover:bg-amber-600 text-black py-4 px-8 rounded-2xl transition-all flex items-center gap-3 active:scale-95 text-sm uppercase">
                <i class="fa-solid fa-plus text-lg"></i>
                Nouvelle Classe
            </button>
            </a>
        </div>

        <div class="bg-gray-900 border border-gray-800 p-4 rounded-4xl flex flex-col lg:flex-row gap-4">
            <div class="relative flex-1 group">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-amber-500 transition-colors"></i>
                <input type="text" placeholder="Rechercher une classe ou un professeur..."
                    class="w-full bg-gray-950 border border-gray-800 text-gray-300 py-4 pl-14 pr-6 rounded-2xl focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/20 transition-all text-sm">
            </div>

            <div class="flex flex-wrap sm:flex-nowrap gap-4">
                <select class="bg-gray-950 border border-gray-800 text-gray-400 py-4 px-6 rounded-2xl focus:outline-none focus:border-amber-500/50 transition-all min-w-5 cursor-pointer text-sm">
                    <option value="">Tous les Niveaux</option>
                </select>

                <button class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-4 rounded-2xl transition-all flex items-center gap-3 border border-gray-700">
                    <i class="fa-solid fa-search text-amber-500"></i>
                    <span class="text-sm">Chercher</span>
                </button>
            </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800/50">
                            <th class="px-8 py-5 text-[11px] uppercase text-gray-500 tracking-widest">Classe</th>
                            <th class="px-8 py-5 text-[11px] uppercase text-gray-500 tracking-widest">Niveau</th>
                            <th class="px-8 py-5 text-[11px] uppercase text-gray-500 tracking-widest">NBr Élèves</th>
                            <th class="px-8 py-5 text-[11px] uppercase text-gray-500 tracking-widest">Maître</th>
                            <th class="px-8 py-5 text-[11px] uppercase text-gray-500 tracking-widest text-right">Details</th>
                        </tr>
                    </thead>
                    <tbody id="class-table-body" class="divide-y divide-gray-800"></tbody>
                </table>
            </div>

            <div class="bg-gray-800/30 px-8 py-6 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-6">
                <p class="text-xs text-gray-500 uppercase tracking-widest"></p>
                <div class="flex items-center gap-2">
                    <button id="prev-page" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-500 border border-gray-700">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <div id="page-numbers" class="flex gap-2"></div>
                    <button id="next-page" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-500 border border-gray-700">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <template id="class-row-template">
        <tr class="hover:bg-gray-800/20 transition-colors group">
            <td class="px-8 py-6">
                <div class="text-white group-hover:text-amber-400 transition-colors class-name"></div>
                <span class="text-[10px] text-gray-600 uppercase tracking-tighter class-year"></span>
            </td>
            <td class="px-8 py-6 text-sm text-gray-300 class-level"></td>
            <td class="px-8 py-6">
                <span class="px-3 py-1.5 bg-blue-500/10 text-blue-400 rounded-xl text-[10px] uppercase border border-blue-500/20 class-students-count"></span>
            </td>
            <td class="px-8 py-6">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 overflow-hidden rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center">
                        <img src="" class="w-full h-full object-cover teacher-photo" alt="">
                    </div>
                    <span class="text-sm text-gray-300 teacher-name"></span>
                </div>
            </td>
            <td class="px-8 py-6 text-right">
                <div class="flex justify-end gap-2">
                    <a href="" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all class-link">
                        <i class="fa-solid fa-circle-info text-xs"></i>
                    </a>
                </div>
            </td>
        </tr>
    </template>
@endsection
