@extends('layouts.app')
@section('title', 'Profil Étudiant')

@section('content')
@vite(['resources/js/core/update-user.js'])

<div class="max-w-7xl mx-auto space-y-8 text-white pb-20 scrollbar-hide px-4">

    <div class="max-w-8xl mx-auto bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="flex flex-col lg:flex-row items-center lg:items-start gap-12">

                <div class="relative shrink-0">
                    <div class="w-32 h-32 md:w-44 md:h-44 rounded-3xl overflow-hidden bg-gray-800 border-2 border-gray-800 p-1 shadow-2xl">
                        <img id="user-avatar" src="" alt="pfp" class="w-full h-full object-cover rounded-2xl bg-gray-900">
                    </div>
                </div>

                <div class="flex-1 w-full">
                    <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-6 mb-10">
                        <div class="text-center lg:text-left">
                            <h2 id="user-fullname-display" class="text-4xl md:text-6xl font-black uppercase tracking-tight text-white leading-none">
                                CHARGEMENT...
                            </h2>
                            <p class="text-amber-500 font-medium tracking-[0.3em] text-[10px] uppercase mt-2 opacity-80">Statut Étudiant Académique</p>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ url('/students/' . basename(Request::path()) . '/edit') }}" class="group flex items-center gap-3 px-6 py-3.5 bg-amber-500 rounded-2xl hover:bg-amber-600 transition-all duration-300">
                                <i class="fa-solid fa-pen-to-square text-black"></i>
                                <span class="text-[11px] font-black uppercase tracking-widest text-black">Modifier</span>
                            </a>

                            <a href="{{ route('student-classes') }}" class="group flex items-center gap-3 px-6 py-3.5 bg-gray-800/50 border border-gray-700 rounded-2xl hover:border-amber-500/50 transition-all duration-300">
                                <i class="fa-solid fa-chalkboard-user text-gray-300"></i>
                                <span class="text-[11px] font-bold uppercase tracking-widest text-white">Classes</span>
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-y-10 gap-x-6 border-t border-gray-800/60 pt-10">
                        <div class="space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Né(e) le</p>
                            <p id="user-birth-info" class="text-base font-semibold text-gray-100">--</p>
                        </div>

                        <div class="space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Genre</p>
                            <p id="user-gender" class="text-base font-semibold text-gray-100 uppercase">--</p>
                        </div>

                        <div class="space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Téléphone</p>
                            <p id="user-phone" class="text-base font-semibold text-gray-100">--</p>
                        </div>

                        <div class="space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Ville</p>
                            <p id="user-address" class="text-base font-semibold text-gray-100 uppercase">--</p>
                        </div>

                        <div class="col-span-2 space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Email Académique</p>
                            <p id="user-email" class="text-base font-bold text-amber-500/90 truncate">--</p>
                        </div>

                        <div class="col-span-2 space-y-1.5">
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Date d'inscription</p>
                            <p id="user-joined" class="text-base font-semibold text-gray-400 italic">--</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
