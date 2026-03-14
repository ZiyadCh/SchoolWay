@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-6 pb-10">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Élèves', 'value' => '1,248', 'icon' => 'fa-users', 'desc' => '+12 ce mois'],
                ['label' => 'Taux de Paiement', 'value' => '92%', 'icon' => 'fa-hand-holding-dollar', 'progress' => 92],
                ['label' => 'Classes Actives', 'value' => '38', 'icon' => 'fa-chalkboard-user', 'desc' => 'Sur 42 salles'],
                ['label' => 'Staff Total', 'value' => '84', 'icon' => 'fa-user-tie', 'desc' => 'Enseignant & Admin'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 hover:border-amber-500/30 transition-all group ">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] text-gray-500 uppercase font-black tracking-[0.2em]">{{ $stat['label'] }}</p>
                    <p class="text-4xl font-black mt-2 group-hover:text-amber-500 transition-colors tracking-tighter">{{ $stat['value'] }}</p>
                </div>
                <div class="bg-gray-950 p-4 rounded-xl border border-gray-800 group-hover:border-amber-500/50 transition-all text-amber-500">
                    <i class="fa-solid {{ $stat['icon'] }} text-xl"></i>
                </div>
            </div>
            @if(isset($stat['progress']))
                <div class="mt-6">
                    <div class="h-1.5 bg-gray-800 rounded-full overflow-hidden p-0.5">
                        <div class="h-full bg-amber-500 rounded-full " style="width: {{ $stat['progress'] }}%"></div>
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-2xl p-8 ">
            <h3 class="text-xl font-black uppercase tracking-widest mb-10 border-l-4 border-amber-500 pl-4">Répartition par Niveau</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @php
                    $cycles = [
                        ['name' => 'Lycée', 'count' => 542, 'total' => 1248],
                        ['name' => 'Collège', 'count' => 418, 'total' => 1248],
                        ['name' => 'Primaire', 'count' => 288, 'total' => 1248],
                    ];
                @endphp

                @foreach($cycles as $cycle)
                @php $percent = round(($cycle['count'] / $cycle['total']) * 100); @endphp
                <div class="bg-gray-950/50 border border-gray-800 p-6 rounded-2xl group hover:border-amber-500/30 transition-all">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center border border-gray-800 text-amber-500 group-hover:bg-amber-500 group-hover:text-black transition-all">
                            <i class="fa-solid fa-layer-group text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">{{ $cycle['name'] }}</p>
                            <p class="text-2xl font-black">{{ $cycle['count'] }} <span class="text-[10px] text-gray-700 uppercase">élèves</span></p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-black uppercase tracking-widest mb-8 text-gray-400">Ratio de Genre</h3>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-[10px] font-black uppercase mb-2 text-gray-500">
                            <span>Garçons</span>
                            <span class="text-blue-500">58%</span>
                        </div>
                        <div class="h-4 bg-gray-950 rounded-lg border border-gray-800 p-1">
                            <div class="h-full bg-blue-500 rounded " style="width: 58%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-[10px] font-black uppercase mb-2 text-gray-500">
                            <span>Filles</span>
                            <span class="text-pink-600">42%</span>
                        </div>
                        <div class="h-4 bg-gray-950 rounded-lg border border-gray-800 p-1">
                            <div class="h-full bg-pink-500 rounded " style="width: 42%"></div>
                        </div>
                    </div>
                </div>
            </div>
       </div>

    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden ">
        <div class="p-8 border-b border-gray-800 flex justify-between items-center bg-gray-900/50">
            <h3 class="text-lg font-black uppercase tracking-widest">Inscriptions Récentes</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-950/50">
                        <th class="p-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Nom & Prenom</th>
                        <th class="p-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Niveau</th>
                        <th class="p-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Classe</th>
                        <th class="p-5 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    @foreach([
                        ['name' => 'Yassine Fahmi', 'class' => 'Lycée', 'date' => 'BAC1 G2', 'status' => 'Détails'],
                        ['name' => 'Sara Idrissi', 'class' => 'Collège', 'date' => 'CE3 G3', 'status' => 'Détails'],
                    ] as $row)
                    <tr class="hover:bg-gray-800/30 transition-colors group">
                        <td class="p-5 font-black text-sm uppercase tracking-tight">{{ $row['name'] }}</td>
                        <td class="p-5 text-xs text-gray-400 font-bold uppercase">{{ $row['class'] }}</td>
                        <td class="p-5 text-[11px] text-gray-500 font-black uppercase tracking-widest">{{ $row['date'] }}</td>
                        <td class="p-5 text-right">
                            <button class="px-4 py-1.5 rounded bg-gray-950 border border-gray-800 text-[9px] font-black uppercase hover:bg-amber-500 hover:text-black transition-all">
                                {{ $row['status'] }}
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
