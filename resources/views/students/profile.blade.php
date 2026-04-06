@extends('layouts.student')
@section('title', 'Mon Profil - School-Way')

@section('content')
@vite(['resources/js/student/profile.js'])

<div class="min-h-screen bg-gray-950">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 text-white pb-20 pt-10">

        <div class="bg-gray-900 border border-gray-800 p-8 md:p-12 rounded-3xl relative overflow-hidden shadow-2xl min-h-[400px] flex flex-col justify-center">
            <div class="absolute top-0 right-0 w-80 h-80 bg-amber-500/5 blur-[100px] rounded-full -mr-40 -mt-40"></div>

            <div class="relative z-10">
                <div class="flex flex-col lg:flex-row gap-10 lg:gap-16 items-center">

                    <div class="flex flex-col items-center lg:items-start gap-6 shrink-0">
                        <div class="w-36 h-36 md:w-44 md:h-44 rounded-2xl overflow-hidden bg-gray-800 border border-gray-700 p-1.5 shadow-xl">
                            <img id="user-avatar" src="https://picsum.photos/400/500?grayscale" alt="pfp" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        </div>

                        <div class="text-center lg:text-left space-y-2 w-full">
                            <h2 id="user-fullname" class="text-3xl md:text-4xl lg:text-5xl font-black uppercase tracking-tighter text-white leading-tight">CHARGEMENT...</h2>
                            <div class="flex flex-col gap-1">
                                <p class="text-amber-500 text-[10px] md:text-xs font-black uppercase tracking-[0.2em] italic">
                                    <span class="text-gray-500 not-italic font-bold">CLASSE:</span> <span id="user-class" class="text-white">---</span>
                                </p>
                                <p class="text-amber-500/80 text-[10px] md:text-xs font-black uppercase tracking-[0.2em] italic">
                                    <span class="text-gray-500 not-italic font-bold">MATRICULE:</span> <span id="user-id" class="text-white/80">#---</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block w-px h-48 bg-gray-800"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 lg:gap-12 flex-1 w-full">

                        <div class="space-y-6">
                            <span class="text-[9px] text-amber-500 uppercase font-black tracking-[0.4em]">✦ État Civil</span>
                            <div class="space-y-4 pl-4 border-l-2 border-amber-500/20">
                                <div>
                                    <p class="text-[9px] text-gray-600 uppercase font-black tracking-widest mb-1">Date de naissance</p>
                                    <p id="user-birth-info" class="text-lg md:text-xl font-bold text-gray-200 italic tracking-tighter">--/--/---- (-- ANS)</p>
                                </div>
                                <div>
                                    <p class="text-[9px] text-gray-600 uppercase font-black tracking-widest mb-1">Genre</p>
                                    <p id="user-gender" class="text-lg md:text-xl font-bold text-gray-300 uppercase tracking-tighter">--</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <span class="text-[9px] text-amber-500 uppercase font-black tracking-[0.4em]">✦ Localisation</span>
                            <div class="space-y-4 pl-4 border-l-2 border-amber-500/20">
                                <div>
                                    <p class="text-[9px] text-gray-600 uppercase font-black tracking-widest mb-1">Téléphone</p>
                                    <p id="user-phone" class="text-lg md:text-xl font-bold text-gray-200 tracking-tighter">--</p>
                                </div>
                                <div>
                                    <p class="text-[9px] text-gray-600 uppercase font-black tracking-widest mb-1">Adresse</p>
                                    <p id="user-address" class="text-base md:text-lg font-bold text-gray-300 line-clamp-1 tracking-tighter uppercase">--</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-gray-900 border border-gray-800 p-10 rounded-3xl shadow-xl min-h-[300px] flex flex-col">
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-1 h-6 bg-amber-500 rounded-full"></div>
                    <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.4em] italic">Accès Institutionnel</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 mt-auto">
                    <div class="space-y-2">
                        <p class="text-[9px] text-gray-600 uppercase font-black tracking-widest">Email de connexion</p>
                        <p id="user-email" class="text-sm md:text-base font-bold text-gray-200 break-all pl-4 border-l-2 border-amber-500 py-1 uppercase tracking-tight">
                            chargement...
                        </p>
                    </div>

                    <div class="space-y-2">
                        <p class="text-[9px] text-gray-600 uppercase font-black tracking-widest">Date d'enregistrement</p>
                        <p id="user-joined" class="text-base md:text-lg font-bold text-gray-200 tracking-tighter uppercase italic pl-4 border-l-2 border-amber-500 py-1">
                            --/--/----
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-10 rounded-3xl flex flex-col justify-between shadow-xl min-h-[300px] group">
                <div class="space-y-8">
                    <div class="w-16 h-16 bg-gray-950 border border-gray-800 rounded-xl flex items-center justify-center text-amber-500 group-hover:border-amber-500/50 transition-all">
                        <i class="fa-solid fa-shield-halved text-2xl"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-sm font-black uppercase text-white tracking-[0.3em]">Sécurité</h4>
                        <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">Compte vérifié</p>
                    </div>
                </div>

                <button class="w-full py-3.5 bg-gray-800 hover:bg-amber-500 text-gray-400 hover:text-black rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all border border-gray-700 hover:border-amber-400">
                    Gérer les accès
                </button>
            </div>

        </div>

    </div>
</div>
@endsection

