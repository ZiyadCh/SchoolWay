@extends('layouts.student')
@section('title', 'Mes Absences - School-Way')

@section('content')
<div class="w-full h-full p-6 md:p-12 text-white">

    <div class="max-w-5xl mx-auto space-y-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between items-center min-h-32 hover:border-gray-600 transition-colors">
                <p class="text-xs font-black text-gray-500 uppercase">Total Absences</p>
                <p class="text-5xl font-black text-white">12</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between items-center min-h-32 hover:border-emerald-500 transition-colors">
                <p class="text-xs font-black text-gray-500 uppercase">Justifiées</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-5xl font-black text-emerald-500">08</p>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-center items-center min-h-32 hover:border-red-500 transition-colors">
                <p class="text-xs font-black text-gray-500 uppercase">Non Justifiées</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-5xl font-black text-red-500">04</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-950 border-b border-gray-800">
                            <th class="p-6 text-xs font-black uppercase text-gray-500">Date de l'absence</th>
                            <th class="p-6 text-xs font-black uppercase text-gray-500 text-right">Statut Justification</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <tr class="hover:bg-gray-800 transition-colors group">
                            <td class="p-6 text-gray-200 text-lg font-bold uppercase">
                                02 Avril 2026
                            </td>
                            <td class="p-6 text-right whitespace-nowrap">
                                <span class="px-4 py-1 bg-emerald-500 text-black text-xs font-black uppercase rounded-full">
                                    Justifiée
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-800 transition-colors group">
                            <td class="p-6 text-gray-200 text-lg font-bold uppercase">
                                28 Mars 2026
                            </td>
                            <td class="p-6 text-right whitespace-nowrap">
                                <span class="px-4 py-1 bg-red-600 text-white text-xs font-black uppercase rounded-full">
                                    Non Justifiée
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-800 transition-colors group">
                            <td class="p-6 text-gray-200 text-lg font-bold uppercase">
                                15 Mars 2026
                            </td>
                            <td class="p-6 text-right whitespace-nowrap">
                                <span class="px-4 py-1 bg-emerald-500 text-black text-xs font-black uppercase rounded-full">
                                    Justifiée
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
