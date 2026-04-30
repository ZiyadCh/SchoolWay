@extends('layouts.app')
@section('title', 'Profil Enseignant')

@section('content')
@vite(['resources/js/tab.js', 'resources/js/teacher/inspect.js'])

<div class="max-w-7xl mx-auto space-y-5 sm:space-y-8 text-white pb-20 scrollbar-hide px-3 sm:px-4">

    <div class="bg-gray-900 border border-gray-800 rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden">
        <div class="p-5 sm:p-8 md:p-10">

            <div class="flex flex-row items-start gap-5 sm:gap-8 md:gap-12">

                <div class="relative shrink-0">
                    <div class="w-20 h-20 sm:w-32 sm:h-32 md:w-40 md:h-40 rounded-2xl sm:rounded-3xl overflow-hidden bg-gray-800 border-2 border-gray-800 p-0.5 sm:p-1 shadow-2xl">
                        <img id="user-avatar" src="" alt="pfp" class="w-full h-full object-cover rounded-xl sm:rounded-2xl bg-gray-900">
                    </div>
                    <label id="avatar-upload-label" class="hidden absolute -bottom-2 -right-2 w-8 h-8 sm:w-9 sm:h-9 bg-amber-500 rounded-xl flex items-center justify-center cursor-pointer shadow-lg hover:bg-amber-600 transition-all">
                        <i class="fa-solid fa-camera text-black text-xs"></i>
                        <input type="file" id="avatar-input" accept="image/*" class="hidden">
                    </label>
                </div>

                <div class="flex-1 min-w-0">
                    <h2 id="user-fullname" class="text-2xl sm:text-4xl md:text-5xl font-black uppercase tracking-tight text-white leading-none truncate">
                        CHARGEMENT...
                    </h2>

                    <div id="edit-name-fields" class="hidden flex flex-col xs:flex-row gap-2 mt-1">
                        <input id="edit-prenom" type="text" placeholder="Prénom"
                            class="bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-base sm:text-lg font-black uppercase tracking-tight outline-none transition-all w-full">
                        <input id="edit-nom" type="text" placeholder="Nom"
                            class="bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-base sm:text-lg font-black uppercase tracking-tight outline-none transition-all w-full">
                    </div>

                    <p class="text-amber-500 font-medium tracking-[0.2em] sm:tracking-[0.3em] text-[9px] sm:text-[10px] uppercase mt-1.5 sm:mt-2 opacity-80">Corps Enseignant Académique</p>

                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-4 sm:mt-5">
                        <button id="btn-edit-toggle"
                            class="flex items-center gap-2 px-4 sm:px-5 py-2.5 bg-amber-500 rounded-xl hover:bg-amber-600 transition-all duration-300 shadow-[0_8px_16px_rgba(245,158,11,0.15)]">
                            <i class="fa-solid fa-user-pen text-black text-xs"></i>
                            <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-black">Modifier</span>
                        </button>

                        <button id="btn-save"
                            class="hidden flex items-center gap-2 px-4 sm:px-5 py-2.5 bg-emerald-500 rounded-xl hover:bg-emerald-600 transition-all duration-300">
                            <i class="fa-solid fa-floppy-disk text-black text-xs"></i>
                            <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-black">Sauvegarder</span>
                        </button>

                        <button id="btn-cancel"
                            class="hidden flex items-center gap-2 px-4 sm:px-5 py-2.5 bg-gray-800/50 border border-gray-700 rounded-xl hover:border-red-500/50 transition-all duration-300">
                            <i class="fa-solid fa-xmark text-gray-300 text-xs"></i>
                            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-widest text-white">Annuler</span>
                        </button>

                        <!-- AJOUT : BOUTON SUPPRIMER (Caché par défaut) -->
                        <button id="btn-delete-student"
                            class="hidden flex items-center gap-2 px-4 sm:px-5 py-2.5 bg-red-500/10 border border-red-500/50 rounded-xl hover:bg-red-500 transition-all duration-300 group">
                            <i class="fa-solid fa-trash-can text-red-500 group-hover:text-white text-xs"></i>
                            <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-red-500 group-hover:text-white">Supprimer</span>
                        </button>
                    </div>
                </div>
            </div>

            <div id="save-feedback" class="hidden mt-5 px-4 py-3 rounded-xl text-[10px] sm:text-[11px] font-black uppercase tracking-widest border"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6 sm:gap-y-8 border-t border-gray-800/60 mt-6 sm:mt-8 pt-6 sm:pt-8">

                <div class="space-y-1">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Né(e) le</p>
                    <p id="user-birth-info" class="view-field text-sm sm:text-base font-semibold text-gray-100"></p>
                    <input id="edit-birthday" type="date"
                        class="edit-field hidden bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-sm outline-none transition-all w-full">
                </div>

                <div class="space-y-1">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Genre</p>
                    <p id="user-gender" class="view-field text-sm sm:text-base font-semibold text-gray-100 uppercase"></p>
                    <select id="edit-gender"
                        class="edit-field hidden bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-sm outline-none transition-all w-full">
                        <option value="">— Choisir —</option>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Téléphone</p>
                    <p id="user-phone" class="view-field text-sm sm:text-base font-semibold text-gray-100"></p>
                    <input id="edit-tel" type="tel" placeholder="0600000000"
                        class="edit-field hidden bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-sm outline-none transition-all w-full">
                </div>

                <div class="space-y-1">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Ville / Bureau</p>
                    <p id="user-address" class="view-field text-sm sm:text-base font-semibold text-gray-100 uppercase"></p>
                    <input id="edit-adress" type="text" placeholder="Casablanca"
                        class="edit-field hidden bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-sm outline-none transition-all w-full">
                </div>

                <div class="sm:col-span-2 lg:col-span-2 space-y-1 min-w-0">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Email Professionnel</p>
                    <p id="user-email" class="view-field text-sm sm:text-base font-bold text-amber-500/90 truncate"></p>
                    <input id="edit-email" type="email" placeholder="prof@ecole.ma"
                        class="edit-field hidden bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-sm outline-none transition-all w-full">
                </div>

                <div class="space-y-1">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Date d'adhésion</p>
                    <p id="user-joined" class="text-sm sm:text-base font-semibold text-gray-400 italic"></p>
                </div>

            </div>
        </div>
    </div>

    <div class="h-20"></div>

</div>
@endsection
