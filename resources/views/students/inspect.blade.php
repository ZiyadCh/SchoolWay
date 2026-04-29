@extends('layouts.app')
@section('title', 'Profil Étudiant')

@section('content')
@vite(['resources/js/tab.js','resources/js/student/inspect.js'])

<div class="max-w-7xl mx-auto space-y-5 sm:space-y-8 text-white pb-20 scrollbar-hide px-3 sm:px-4">

    {{-- ── Profile card ── --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden">
        <div class="p-5 sm:p-8 md:p-10">

            {{-- Avatar + name row: side-by-side even on mobile --}}
            <div class="flex flex-row items-start gap-5 sm:gap-8 md:gap-12">

                {{-- Avatar --}}
                <div class="relative shrink-0">
                    <div class="w-20 h-20 sm:w-32 sm:h-32 md:w-40 md:h-40 rounded-2xl sm:rounded-3xl overflow-hidden bg-gray-800 border-2 border-gray-800 p-0.5 sm:p-1 shadow-2xl">
                        <img id="user-avatar" src="" alt="pfp" class="w-full h-full object-cover rounded-xl sm:rounded-2xl bg-gray-900">
                    </div>
                    {{-- Avatar upload (edit mode only) --}}
                    <label id="avatar-upload-label" class="hidden absolute -bottom-2 -right-2 w-8 h-8 sm:w-9 sm:h-9 bg-amber-500 rounded-xl flex items-center justify-center cursor-pointer shadow-lg hover:bg-amber-600 transition-all">
                        <i class="fa-solid fa-camera text-black text-xs"></i>
                        <input type="file" id="avatar-input" accept="image/*" class="hidden">
                    </label>
                </div>

                {{-- Name + buttons --}}
                <div class="flex-1 min-w-0">
                    {{-- Name display --}}
                    <h2 id="user-fullname" class="text-2xl sm:text-4xl md:text-5xl font-black uppercase tracking-tight text-white leading-none truncate">
                        CHARGEMENT...
                    </h2>
                    {{-- Name inputs (edit mode) --}}
                    <div id="edit-name-fields" class="hidden flex flex-col xs:flex-row gap-2 mt-1">
                        <input id="edit-prenom" type="text" placeholder="Prénom"
                            class="bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-base sm:text-lg font-black uppercase tracking-tight outline-none transition-all w-full">
                        <input id="edit-nom" type="text" placeholder="Nom"
                            class="bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-base sm:text-lg font-black uppercase tracking-tight outline-none transition-all w-full">
                    </div>
                    <p class="text-amber-500 font-medium tracking-[0.2em] sm:tracking-[0.3em] text-[9px] sm:text-[10px] uppercase mt-1.5 sm:mt-2 opacity-80">Statut Étudiant Académique</p>

                    {{-- Action buttons — wraps naturally on small screens --}}
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-4 sm:mt-5">
                        {{-- View mode --}}
                        <button id="btn-edit-toggle"
                            class="flex items-center gap-2 px-4 sm:px-5 py-2.5 bg-amber-500 rounded-xl hover:bg-amber-600 transition-all duration-300 shadow-[0_8px_16px_rgba(245,158,11,0.15)]">
                            <i class="fa-solid fa-user-pen text-black text-xs"></i>
                            <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-black">Modifier</span>
                        </button>

                        {{-- Edit mode --}}
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

                        <a href="{{ route('student-classes') }}"
                            class="flex items-center gap-2 px-4 sm:px-5 py-2.5 bg-gray-800/50 border border-gray-700 rounded-xl hover:border-amber-500/50 transition-all duration-300">
                            <i class="fa-solid fa-chalkboard-user text-gray-300 text-xs"></i>
                            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-widest text-white">Classes</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Save feedback banner --}}
            <div id="save-feedback" class="hidden mt-5 px-4 py-3 rounded-xl text-[10px] sm:text-[11px] font-black uppercase tracking-widest border"></div>

            {{-- Info grid --}}
            {{-- Mobile: 1 col. sm: 2 cols. lg: 3 cols with email spanning 2. --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6 sm:gap-y-8 border-t border-gray-800/60 mt-6 sm:mt-8 pt-6 sm:pt-8">

                {{-- Né(e) le --}}
                <div class="space-y-1">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Né(e) le</p>
                    <p id="user-birth-info" class="view-field text-sm sm:text-base font-semibold text-gray-100"></p>
                    <input id="edit-birthday" type="date"
                        class="edit-field hidden bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-sm outline-none transition-all w-full">
                </div>

                {{-- Genre --}}
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

                {{-- Téléphone --}}
                <div class="space-y-1">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Téléphone</p>
                    <p id="user-phone" class="view-field text-sm sm:text-base font-semibold text-gray-100"></p>
                    <input id="edit-tel" type="tel" placeholder="0600000000"
                        class="edit-field hidden bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-sm outline-none transition-all w-full">
                </div>

                {{-- Ville --}}
                <div class="space-y-1">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Ville</p>
                    <p id="user-address" class="view-field text-sm sm:text-base font-semibold text-gray-100 uppercase"></p>
                    <input id="edit-adress" type="text" placeholder="Casablanca"
                        class="edit-field hidden bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-sm outline-none transition-all w-full">
                </div>

                {{-- Email — spans 2 cols on lg so it sits wide --}}
                <div class="sm:col-span-2 lg:col-span-2 space-y-1 min-w-0">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Email Académique</p>
                    <p id="user-email" class="view-field text-sm sm:text-base font-bold text-amber-500/90 truncate"></p>
                    <input id="edit-email" type="email" placeholder="etudiant@ecole.ma"
                        class="edit-field hidden bg-gray-800 border border-gray-700 focus:border-amber-500 rounded-xl px-3 py-2 text-white text-sm outline-none transition-all w-full">
                </div>

                {{-- Date inscription (read-only) --}}
                <div class="space-y-1">
                    <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase font-bold tracking-[0.15em]">Date d'inscription</p>
                    <p id="user-joined" class="text-sm sm:text-base font-semibold text-gray-400 italic"></p>
                </div>

            </div>
        </div>
    </div>

    {{-- ── Tabs ── --}}
    <div class="flex justify-center w-full">
        <div class="flex w-full sm:w-fit bg-gray-950 p-1 sm:p-1.5 rounded-xl sm:rounded-2xl border border-gray-900 shadow-inner">
            <button onclick="switchTab(event, 'notes')"
                class="tab-btn flex-1 sm:flex-none px-3 sm:px-10 md:px-12 py-3 rounded-lg sm:rounded-xl font-black text-[10px] sm:text-[11px] uppercase tracking-[0.15em] sm:tracking-[0.2em] transition-all bg-amber-500 text-black shadow-lg">
                Notes
            </button>
            <button onclick="switchTab(event, 'absence')"
                class="tab-btn flex-1 sm:flex-none px-3 sm:px-10 md:px-12 py-3 rounded-lg sm:rounded-xl font-black text-[10px] sm:text-[11px] uppercase tracking-[0.15em] sm:tracking-[0.2em] transition-all text-gray-500 hover:text-white">
                Absence
            </button>
            <button onclick="switchTab(event, 'devoir')"
                class="tab-btn flex-1 sm:flex-none px-3 sm:px-10 md:px-12 py-3 rounded-lg sm:rounded-xl font-black text-[10px] sm:text-[11px] uppercase tracking-[0.15em] sm:tracking-[0.2em] transition-all text-gray-500 hover:text-white">
                Devoir
            </button>
        </div>
    </div>

    {{-- ── Tab content ── --}}
    <div id="tab-container">
        {{-- Notes --}}
        <div id="notes" class="tab-content transition-all duration-300">
            <div id="notes-container" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">
                <div class="animate-pulse bg-gray-900/50 h-44 rounded-2xl border border-gray-800"></div>
            </div>
        </div>

        {{-- Absences --}}
        <div id="absence" class="tab-content hidden opacity-0 transition-all duration-300">
            <div class="bg-gray-900 border border-gray-800 p-4 sm:p-6 md:p-8 rounded-2xl sm:rounded-3xl w-full shadow-xl">
                {{-- Month nav --}}
                <div class="flex items-center justify-between mb-6 sm:mb-10 pb-4 sm:pb-6 border-b border-gray-800/50">
                    <button id="prev-month" class="p-2 sm:p-3 hover:bg-gray-800 rounded-xl transition-all text-amber-500 border border-transparent hover:border-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <span id="current-month-display" class="text-[10px] sm:text-xs font-black uppercase tracking-[0.25em] sm:tracking-[0.4em] text-white"></span>
                    <button id="next-month" class="p-2 sm:p-3 hover:bg-gray-800 rounded-xl transition-all text-amber-500 border border-transparent hover:border-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                {{-- Calendar grid — gap tighter on mobile so cells fit --}}
                <div id="absence-calendar" class="grid grid-cols-7 gap-1 sm:gap-2 md:gap-3"></div>

                {{-- Legend --}}
                <div class="mt-6 sm:mt-10 pt-5 sm:pt-8 border-t border-gray-800/50 flex gap-5 sm:gap-8">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="w-2 h-2 rounded-full bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.4)]"></span>
                        <span class="text-[9px] sm:text-[10px] font-bold text-gray-500 uppercase tracking-widest">Injustifié</span>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.4)]"></span>
                        <span class="text-[9px] sm:text-[10px] font-bold text-gray-500 uppercase tracking-widest">Justifié</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Devoirs --}}
        <div id="devoir" class="tab-content hidden opacity-0 transition-all duration-300">
            <div id="devoirs-container" class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 md:gap-8"></div>
        </div>
    </div>
</div>
@endsection
