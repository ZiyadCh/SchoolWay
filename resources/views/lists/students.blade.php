@extends('layouts.app')

@section('title', 'Gérer les Élèves')

@section('content')
@vite('resources/js/list/students.js')

<div class="space-y-6 md:space-y-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-3xl md:text-4xl text-white">Registre des Élèves</h2>
            <p class="text-gray-500 text-sm mt-1">Gestion et suivi des inscriptions académiques</p>
        </div>
            <a href="{{ route('student-form' ) }}">

        <button class="w-full sm:w-auto bg-amber-500 hover:bg-amber-600 text-black py-4 px-8 rounded-2xl transition-all flex items-center justify-center gap-3 active:scale-95 text-xs uppercase">
            <i class="fa-solid fa-user-plus text-lg"></i>
        Inscrire un Élève
        </button>
                </a>
    </div>

    <div class="bg-gray-900 border border-gray-800 p-3 md:p-4 rounded-3xl md:rounded-4xl flex flex-col lg:flex-row gap-4">
        <div class="relative flex-1 group">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-amber-500 transition-colors"></i>
            <input type="text" placeholder="Rechercher un élève..."
                class="w-full bg-gray-950 border border-gray-800 text-gray-300 py-4 pl-14 pr-6 rounded-xl md:rounded-2xl focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/20 transition-all text-sm">
        </div>

        <div class="flex gap-3 sm:gap-4">
            <select class="flex-1 lg:flex-none bg-gray-950 border border-gray-800 text-gray-400 py-4 px-4 md:px-6 rounded-xl md:rounded-2xl focus:outline-none focus:border-amber-500/50 transition-all min-w-32 cursor-pointer text-sm">
                <option value="">Tous les Niveaux</option>
                <option value="1bac">1ère Année Bac</option>
                <option value="2bac">2ème Année Bac</option>
            </select>

            <button class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-4 rounded-xl md:rounded-2xl transition-all flex items-center justify-center gap-3 min-w-14 sm:min-w-auto">
                <i class="fa-solid fa-search text-amber-500"></i>
                <span class="hidden sm:inline text-sm">Chercher</span>
            </button>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-3xl md:rounded-5xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="bg-gray-800/50">
                        <th class="px-6 md:px-8 py-5 text-xxs md:text-xs uppercase text-gray-500">Nom & Prénom</th>
                        <th class="px-4 md:px-8 py-5 text-xxs md:text-xs uppercase text-gray-500 text-center">Genre</th>
                        <th class="px-6 md:px-8 py-5 text-xxs md:text-xs uppercase text-gray-500">Niveau</th>
                        <th class="md:table-cell px-8 py-5 text-xs uppercase text-gray-500">Lieu de Naissance</th>
                        <th class="px-6 md:px-8 py-5 text-xxs md:text-xs uppercase text-gray-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="student-table-body" class="divide-y divide-gray-800"></tbody>
            </table>
        </div>

        <div class="bg-gray-800/30 px-6 md:px-8 py-6 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p id="pagination-info" class="text-xxs md:text-xs text-gray-500 uppercase text-center sm:text-left"></p>
            <div id="pagination-container" class="flex items-center gap-2">
                <button id="prev-page" class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg md:rounded-xl bg-gray-800 text-gray-500 border border-gray-700 transition-all">
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

<template id="student-row-template">
    <tr class="hover:bg-gray-800/20 transition-colors group">
        <td class="px-6 md:px-8 py-5 md:py-6">
            <div class="flex items-center gap-3 md:gap-4">
                <div class="avatar-container w-10 h-10 md:w-11 md:h-11 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center overflow-hidden shrink-0">
                    <img src="" alt="Avatar" class="student-avatar w-full h-full object-cover">
                </div>
                <span class="student-name text-sm md:text-base text-white group-hover:text-amber-400 transition-colors truncate"></span>
            </div>
        </td>
        <td class="px-4 md:px-8 py-5 md:py-6 text-center">
            <span class="student-gender text-xxs uppercase px-2.5 py-1 rounded-full border"></span>
        </td>
        <td class="student-level px-6 md:px-8 py-5 md:py-6 text-xs md:text-sm text-gray-300"></td>
        <td class="hidden md:table-cell px-8 py-6">
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <i class="fa-solid fa-location-dot text-gray-600"></i>
                <span class="student-location"></span>
            </div>
        </td>
        <td class="px-6 md:px-8 py-5 md:py-6 text-right">
            <div class="flex justify-end gap-2">
                <a href="" class="student-link w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-lg md:rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all hover:border-amber-500/50">
                    <i class="fa-solid fa-eye text-xs"></i>
                </a>
            </div>
        </td>
    </tr>
</template>
@endsection
