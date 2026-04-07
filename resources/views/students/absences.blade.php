@extends('layouts.student')
@section('title', 'Mes Absences - School-Way')

@section('content')
<div class="w-full h-full p-6 md:p-12 text-white">

    <div class="max-w-5xl mx-auto space-y-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between items-center min-h-30">
                <p class="text-l text-gray-500">Total Absences</p>
                <p class="text-5xl text-white">12</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-between items-center  min-h-30">
                <p class="text-l text-gray-500">Justifiées</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-5xl text-emerald-500">08</p>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl shadow-xl flex flex-col justify-center items-center min-h-30">
                <p class="text-l text-gray-500">Non Justifiées</p>
                <div class="flex items-baseline gap-2">
                    <p class="text-5xl text-red-500">04</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-950/50 border-b border-gray-800">
                            <th class="p-6 text-[10px] text-gray-500">Date de l'absence</th>
                            <th class="p-6 text-[10px] text-gray-500 text-right">Statut Justification</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        <tr class="hover:bg-gray-800 transition-colors">
                            <td class="p-6 text-gray-200 text-lg">
                                02 Avril 2026
                            </td>
                            <td class="p-6 text-right">
                                <span class="px-4 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-[9px] text-emerald-500">
                                    Justifiée
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-800 transition-colors">
                            <td class="p-6 text-gray-200 text-lg">
                                28 Mars 2026
                            </td>
                            <td class="p-6 text-right">
                                <span class="px-4 py-1.5 bg-red-500/10 border border-amber-500/20 rounded-full text-[9px] text-amber-500">
                                    Non Justifiée
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-800 transition-colors">
                            <td class="p-6 text-gray-200 text-lg">
                                15 Mars 2026
                            </td>
                            <td class="p-6 text-right">
                                <span class="px-4 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-[9px] text-emerald-500">
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
