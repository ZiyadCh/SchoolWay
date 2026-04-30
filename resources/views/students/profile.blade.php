@extends('layouts.student')
@section('title', 'Mon Profil - School-Way')

@section('content')
@vite(['resources/js/student/profile.js'])

<div class="w-full h-full p-4 md:p-8 ">

    <div class="max-w-8xl mx-auto bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl">

        <div class="p-8 md:p-12">
            <div class="flex flex-col lg:flex-row items-center lg:items-start gap-10">

                <div class="shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden bg-gray-800 border border-gray-700 p-1">
                        <img id="user-avatar" src="https://picsum.photos/400/400?grayscale" alt="pfp" class="w-full h-full object-cover rounded-xl">
                    </div>
                </div>

                <div class="flex-1 w-full">
                    <div class="mb-8 text-center lg:text-left">
                        <h2 id="user-fullname" class="text-4xl md:text-5xl font-black uppercase tracking-tighter text-white">CHARGEMENT...</h2>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-y-8 gap-x-4 border-t border-gray-800 pt-8">

                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Né(e) le</p>
                            <p id="user-birth-info" class="text-sm md:text-base font-bold text-gray-200">--/--/----</p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Genre</p>
                            <p id="user-gender" class="text-sm md:text-base font-bold text-gray-200 uppercase">--</p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Téléphone</p>
                            <p id="user-phone" class="text-sm md:text-base font-bold text-gray-200">--</p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Ville</p>
                            <p id="user-address" class="text-sm md:text-base font-bold text-gray-200 uppercase">--</p>
                        </div>

                        <div class="col-span-2 space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Email Académique</p>
                            <p id="user-email" class="text-sm md:text-base font-bold text-amber-500/90 truncate uppercase tracking-tight">chargement...</p>
                        </div>

                        <div class="col-span-2 space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Date d'inscription</p>
                            <p id="user-joined" class="text-sm md:text-base font-bold text-gray-200 uppercase italic">--/--/----</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

