@extends('layouts.app')
@section('title', 'Gestion des Enseignants')
@section('content')
@vite('resources/js/list/teachers.js')

<div class="space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h2 class="text-4xl font-black text-white tracking-tight">Enseignants</h2>
            <p class="text-gray-500 text-sm mt-1">Gestion et suivi du corps enseignant</p>
        </div>
        <a href="{{ route('teacher-form') }}">
            <button class="bg-amber-500 hover:bg-amber-600 text-black font-black py-4 px-8 rounded-2xl transition-all flex items-center gap-3 active:scale-95 text-sm uppercase tracking-widest">
                <i class="fa-solid fa-plus text-lg"></i>
                Ajouter un Enseignant
            </button>
        </a>
    </div>

    <div class="bg-gray-900 border border-gray-800 p-4 rounded-4xl flex flex-col lg:flex-row gap-4">
        <div class="relative flex-1 group">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-amber-500 transition-colors"></i>
            <input
                type="text"
                id="search-input"
                placeholder="Rechercher un professeur par nom ..."
                class="w-full bg-gray-950 border border-gray-800 text-gray-300 py-4 pl-14 pr-6 rounded-2xl focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/20 transition-all text-sm">
        </div>
        <div class="flex flex-wrap sm:flex-nowrap gap-4">
            <button
                id="search-btn"
                class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-4 rounded-2xl transition-all flex items-center gap-3 border border-gray-700 min-w-[140px] justify-center">
                <i class="fa-solid fa-search text-amber-500"></i>
                <span class="font-bold text-sm">Chercher</span>
            </button>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-[3rem] overflow-hidden shadow-2xl">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="bg-gray-800/50">
                        <th class="px-8 py-5 text-xs uppercase font-bold text-gray-500 tracking-widest">Enseignant</th>
                        <th class="px-8 py-5 text-xs uppercase font-bold text-gray-500 tracking-widest">Email</th>
                        <th class="px-8 py-5 text-xs uppercase font-bold text-gray-500 tracking-widest">Contact</th>
                        <th class="px-8 py-5 text-xs uppercase font-bold text-gray-500 tracking-widest text-right">Détails</th>
                    </tr>
                </thead>
                <tbody id="teacher-table-body" class="divide-y divide-gray-800"></tbody>
            </table>
        </div>

        <div class="bg-gray-800/30 px-6 md:px-8 py-6 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p id="pagination-info" class="text-xxs md:text-xs text-gray-500 uppercase text-center sm:text-left"></p>
            <div id="pagination-container" class="flex items-center gap-2">
                <button id="prev-page" class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg md:rounded-xl bg-gray-800 text-gray-500 border border-gray-700 transition-all hover:text-white">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <div id="page-numbers" class="flex gap-2"></div>
                <button id="next-page" class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg md:rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<template id="teacher-row-template">
    <tr class="hover:bg-gray-800/20 transition-colors group">
        <td class="px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center overflow-hidden">
                    <img src="" alt="Avatar" class="teacher-photo w-full h-full object-cover">
                </div>
                <span class="teacher-name font-bold text-white group-hover:text-amber-400 transition-colors"></span>
            </div>
        </td>
        <td class="px-8 py-6">
            <span class="teacher-email text-sm font-semibold text-gray-300"></span>
        </td>
        <td class="px-8 py-6">
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <i class="fa-solid fa-phone text-xs text-gray-600"></i>
                <span class="teacher-phone text-gray-400"></span>
            </div>
        </td>
        <td class="px-8 py-6 text-right">
            <div class="flex justify-end gap-2">
                <a href="" class="teacher-link w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all hover:border-amber-500/50">
                    <i class="fa-solid fa-address-book text-xs"></i>
                </a>
            </div>
        </td>
    </tr>
</template>
@endsection
