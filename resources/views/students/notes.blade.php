@extends('layouts.student')
@section('title', 'Mes Notes - School-Way')

@section('content')
@vite(['resources/js/student/notes.js'])
<div class="w-full h-full p-6 md:p-12 text-white">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
            <div>
                <h2 class="text-3xl font-black uppercase tracking-tighter">Bulletins & Notes</h2>
                <div class="w-12 h-1 bg-amber-500 mt-2 rounded-full"></div>
            </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-950/50 border-b border-gray-800">
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Examen</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-gray-500">Date</th>
                            <th class="p-6 text-[10px] font-black uppercase tracking-widest text-amber-500 text-right">Note</th>
                        </tr>
                    </thead>
                    <tbody id="notesContainer" class="divide-y divide-gray-800/50">
                        <tr>
                            <td colspan="5" class="p-10 text-center animate-pulse text-gray-500 uppercase font-black text-xs tracking-widest">
                                Récupération des données...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
