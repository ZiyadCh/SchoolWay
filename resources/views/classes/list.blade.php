@extends('layouts.app')

@section('title', 'Gestion des Classes')

@section('content')
    <div class="space-y-10 max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div>
                <h2 class="text-4xl font-black text-white tracking-tight">Gestion des Classes</h2>
                <p class="text-gray-500 mt-2 font-medium">Administration des structures académiques et des affectations.</p>
            </div>
            <button class="bg-amber-500 hover:bg-amber-600 text-black font-black py-4 px-8 rounded-2xl transition-all shadow-xl shadow-amber-500/20 flex items-center gap-3 active:scale-95 text-sm uppercase tracking-widest">
                <i class="fa-solid fa-plus text-lg"></i>
                <span>Nouvelle Classe</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-900 border border-gray-800 p-8 rounded-3xl flex items-center gap-6 hover:border-blue-500/50 transition-colors">
                <div class="bg-blue-500/10 text-blue-400 p-5 rounded-2xl">
                    <i class="fa-solid fa-layer-group text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Total Classes</p>
                    <p class="text-3xl font-black text-white">38</p>
                </div>
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
                            <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <tr class="hover:bg-gray-800/20 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="font-bold text-white group-hover:text-amber-400 transition-colors">2BAC-SP | G1</div>
                            </td>
                            <td class="px-8 py-6 text-sm font-medium text-gray-300">2ème Année Baccalauréat</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-gray-800 text-emerald-400 rounded-lg text-xs font-bold border border-gray-700">32 Élèves</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-amber-500/20 border border-amber-500/50 flex items-center justify-center text-[10px] font-black text-amber-500">AL</div>
                                    <span class="text-sm font-semibold text-gray-300">Prof. Alami</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-3">
                                    <button class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all"><i class="fa-solid fa-pen-to-square text-xs"></i></button>
                                    <button class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-red-400 border border-gray-700 transition-all"><i class="fa-solid fa-trash text-xs"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-800/20 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="font-bold text-white group-hover:text-amber-400 transition-colors">1BAC-SM | A</div>
                            </td>
                            <td class="px-8 py-6 text-sm font-medium text-gray-300">1ère Année Baccalauréat</td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-gray-800 text-emerald-400 rounded-lg text-xs font-bold border border-gray-700">28 Élèves</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-500/20 border border-blue-500/50 flex items-center justify-center text-[10px] font-black text-blue-400">BN</div>
                                    <span class="text-sm font-semibold text-gray-300">Prof. Bennani</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-3">
                                    <button class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-white border border-gray-700 transition-all"><i class="fa-solid fa-pen-to-square text-xs"></i></button>
                                    <button class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-800 text-gray-400 hover:text-red-400 border border-gray-700 transition-all"><i class="fa-solid fa-trash text-xs"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
