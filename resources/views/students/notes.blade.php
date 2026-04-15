@extends('layouts.student')
@section('title', 'Mes Notes - School-Way')

@section('content')
<div class="w-full h-full p-6 md:p-12 text-white">

    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
            <div>
                <h2 class="text-3xl font-black uppercase tracking-tighter">Bulletins & Notes</h2>
                <div class="w-12 h-1 bg-amber-500 mt-2 rounded-full"></div>
            </div>

            <div class="flex flex-wrap gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-[8px] font-black uppercase text-gray-500 tracking-[0.2em] ml-1 text-nowrap">Filtrer par Classe</label>
                    <select class="bg-gray-900 border border-gray-800 text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-lg focus:border-amber-500 outline-none transition-colors cursor-pointer min-w-40">
                        <option value="all">Toutes les classes</option>
                        <option value="A">Classe A</option>
                        <option value="B">Classe B</option>
                    </select>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-[8px] font-black uppercase text-gray-500 tracking-[0.2em] ml-1 text-nowrap">Trier par Date</label>
                    <select class="bg-gray-900 border border-gray-800 text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-lg focus:border-amber-500 outline-none transition-colors cursor-pointer text-amber-500 min-w-40">
                        <option value="recent">Plus récent</option>
                        <option value="old">Plus ancien</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-950/50 border-b border-gray-800">
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Examen</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Matière</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-nowrap">Enseignant</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500 text-center">Coefficient</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Date</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-amber-500 text-right">Note</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        <tr class="hover:bg-gray-800/30 transition-colors group">
                            <td class="p-6 font-bold text-gray-200 uppercase tracking-tight">Examen Final</td>
                            <td class="p-6 font-bold text-gray-400 uppercase tracking-tight">Mathématiques</td>
                            <td class="p-6 text-sm font-bold text-gray-400">Pr. Ahmed Benani</td>
                            <td class="p-6 text-center font-bold text-gray-400">4</td>
                            <td class="p-6 text-sm font-bold text-gray-400 uppercase italic">12 - 02 - 2026</td>
                            <td class="p-6 text-right font-black text-white text-xl">15.50</td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors group">
                            <td class="p-6 font-bold text-gray-200 uppercase tracking-tight">Contrôle N°2</td>
                            <td class="p-6 font-bold text-gray-400 uppercase tracking-tight">Physique-Chimie</td>
                            <td class="p-6 text-sm font-bold text-gray-400 text-nowrap">Mme. Sarah Mansouri</td>
                            <td class="p-6 text-center font-bold text-gray-400">3</td>
                            <td class="p-6 text-sm font-bold text-gray-400 uppercase italic">05 - 02 - 2026</td>
                            <td class="p-6 text-right font-black text-white text-xl">12.00</td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors group">
                            <td class="p-6 font-bold text-gray-200 uppercase tracking-tight">Projet IA</td>
                            <td class="p-6 font-bold text-gray-400 uppercase tracking-tight text-nowrap">Informatique</td>
                            <td class="p-6 text-sm font-bold text-gray-400">Pr. Yassine Alami</td>
                            <td class="p-6 text-center font-bold text-gray-400">2</td>
                            <td class="p-6 text-sm font-bold text-gray-400 uppercase italic">15 Mar 2026</td>
                            <td class="p-6 text-right font-black text-amber-500 text-xl">19.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
