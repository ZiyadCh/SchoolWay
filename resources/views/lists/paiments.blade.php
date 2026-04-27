@extends('layouts.app')

@section('title', 'Gestion des Paiements')

@section('content')
@vite('resources/js/list/paiment-status.js')
<div class="space-y-8 max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div>
            <h2 class="text-4xl font-bold text-white tracking-tight">Suivi des Paiements</h2>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 p-4 rounded-3xl flex flex-col lg:flex-row gap-4">
        <div class="relative flex-1 group">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-amber-500 transition-colors"></i>
            <input type="text" id="search-input" placeholder="Rechercher un élève..."
                class="w-full bg-gray-950 border border-gray-800 text-gray-300 py-4 pl-14 pr-6 rounded-2xl focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/20 transition-all text-sm">
        </div>

        <div class="flex flex-wrap sm:flex-nowrap gap-4">
            <select id="status-filter" class="bg-gray-950 border border-gray-800 text-gray-400 py-4 px-6 rounded-2xl focus:outline-none focus:border-amber-500/50 transition-all min-w-5 cursor-pointer text-sm font-bold">
                <option value="all">Tous les Statuts</option>
                <option value="paid" class="text-emerald-500">À jour</option>
                <option value="late" class="text-red-500">En retard</option>
            </select>
        </div>

            <button class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-4 rounded-xl md:rounded-2xl transition-all flex items-center justify-center gap-3 min-w-14 sm:min-w-auto">
                <i class="fa-solid fa-search text-amber-500"></i>
                <span class="hidden sm:inline text-sm">Chercher</span>
            </button>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-800/50">
                        <th class="px-8 py-5 text-xs uppercase font-bold text-gray-500 tracking-widest">Élève</th>
                        <th class="px-8 py-5 text-xs uppercase font-bold text-gray-500 tracking-widest text-center">Statut</th>
                        <th class="px-8 py-5 text-xs uppercase font-bold text-gray-500 tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="payments-table-body" class="divide-y divide-gray-800">
                    </tbody>
            </table>
        </div>

            <!--- PAGINATION -->
        <div class="bg-gray-800/30 px-8 py-6 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-6">
            <p id="pagination-info" class="text-xs font-bold text-gray-500 uppercase tracking-widest"></p>
            <div class="flex items-center gap-2">
                <button id="prev-page" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-500 border border-gray-700 hover:text-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <div id="page-numbers" class="flex gap-2">
                    </div>
                <button id="next-page" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-500 border border-gray-700 hover:text-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<template id="payment-row-template">
    <tr class="hover:bg-gray-800/20 transition-colors group">
        <td class="px-8 py-6">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center overflow-hidden">
                    <i class="fa-solid fa-user text-gray-500 group-hover:text-amber-500 transition-colors avatar-icon"></i>
                    <img src="" alt="Avatar" class="w-full h-full object-cover hidden avatar-img">
                </div>
                <div>
                    <span class="text-white group-hover:text-amber-400 font-bold transition-colors block student-name"></span>
                    <span class="text-xs font-bold text-gray-600 uppercase tracking-wider class-name"></span>
                </div>
            </div>
        </td>
        <td class="px-8 py-6 text-center">
            <div class="flex flex-col items-center gap-1">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-black uppercase border status-badge">
                    <span class="w-1.5 h-1.5 rounded-full status-dot"></span>
                    <span class="status-text"></span>
                </span>
                <div class="text-xs font-bold text-gray-600 balance-info"></div>
            </div>
        </td>
        <td class="px-8 py-6 text-right">
            <div class="flex justify-end gap-2">
                <a href="" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-amber-500 hover:bg-amber-500/10 border border-gray-700 transition-all action-link">
                    <i class="fa-solid fa-address-book text-xs"></i>
                </a>
            </div>
        </td>
    </tr>
</template>
@endsection
