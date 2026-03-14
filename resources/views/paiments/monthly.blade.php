@extends('layouts.app')

@section('title', 'Pointage Mensualités')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto text-white">
    <div class="bg-gray-900 border border-gray-800 p-8 rounded-[2.5rem] flex items-center gap-6">
        <div class="w-20 h-20 rounded-3xl overflow-hidden border-2 border-amber-500/20">
            <img src="https://imgs.search.brave.com/ga1XYA-Gv_ZxrF3opOXO0WKaZVWzcTArBM-0KgmCDRY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/bWVtZXBmcC5jb20v/X25leHQvaW1hZ2Uv/P3VybD1odHRwczov/L2Nkbi5tZW1lcGZw/LmNvbS9wZnAtZm9y/LXNjaG9vbCZ3PTE5/MjAmcT03NQ" class="w-full h-full object-cover">
        </div>
        <div>
            <h2 class="text-3xl font-black tracking-tight text-white">Ahmed Mansouri</h2>
            <p class="text-gray-500 font-medium uppercase text-xs tracking-widest mt-1">ID: 24001582</p>
        </div>
    </div>

    <form action="#" method="POST">
        @csrf
        <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800/50">
                            <th class="px-10 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest w-24 text-center">Action</th>
                            <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">Mois</th>
                            <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest text-right">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @php
                            $allMonths = [
                                ['id' => 'september', 'name' => 'Septembre', 'paid' => true],
                                ['id' => 'october', 'name' => 'Octobre', 'paid' => false],
                                ['id' => 'november', 'name' => 'Novembre', 'paid' => false],
                                ['id' => 'december', 'name' => 'Décembre', 'paid' => false],
                                ['id' => 'january', 'name' => 'Janvier', 'paid' => false],
                                ['id' => 'february', 'name' => 'Février', 'paid' => false],
                            ];
                        @endphp

                        @foreach($allMonths as $m)
                        <tr class="hover:bg-gray-800/20 transition-colors {{ $m['paid'] ? '' : 'group' }}">
                            <td class="px-10 py-6 text-center">
                                <label class="relative inline-flex items-center cursor-pointer {{ $m['paid'] ? '' : 'group' }}">
                                    <input type="checkbox" name="months[]" value="{{ $m['id'] }}" {{ $m['paid'] ? 'checked disabled' : '' }} class="peer sr-only">
                                    <div class="w-7 h-7 {{ $m['paid'] ? 'bg-emerald-500 border-emerald-500 opacity-40' : 'bg-black border-gray-700 group-hover:border-amber-500' }} border-2 rounded-xl transition-all flex items-center justify-center peer-checked:bg-emerald-500 peer-checked:border-emerald-500">
                                        <i class="fa-solid fa-check text-xs text-black font-black {{ $m['paid'] ? '' : 'opacity-0 peer-checked:opacity-100' }} transition-opacity"></i>
                                    </div>
                                </label>
                            </td>
                            <td class="px-8 py-6 text-lg font-bold {{ $m['paid'] ? 'text-gray-600 line-through' : 'text-white' }}">
                                {{ $m['name'] }}
                            </td>
                            <td class="px-8 py-6 text-right">
                                @if($m['paid'])
                                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-400 bg-emerald-400/10 px-4 py-2 rounded-full border border-emerald-400/20">Payé</span>
                                @else
                                    <span class="text-[10px] font-black uppercase tracking-widest text-red-400 bg-red-400/10 px-4 py-2 rounded-full border border-red-400/20">Impayé</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-800/30 px-10 py-10 border-t border-gray-800 flex justify-end">
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-black font-black py-4 px-12 rounded-2xl transition-all active:scale-95 text-sm uppercase tracking-widest flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    Confirmer
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
