@extends('layouts.app')

@section('title', 'Créer une Classe')

@section('content')
@vite('resources/js/forms/add-class.js')
<div class="max-w-4xl mx-auto space-y-8 text-white pb-12">

    <div>
        <h1 class="text-3xl font-black tracking-tight">Nouvelle Classe</h1>
        <p class="text-gray-400 mt-1 text-sm">Définissez une nouvelle section et attribuez-lui un enseignant responsable.</p>
    </div>

    <form id="classForm" class="space-y-6">
        @csrf
        <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] p-8 space-y-8">
            <div class="flex items-center gap-4 border-b border-gray-800 pb-6">
                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-chalkboard text-indigo-500"></i>
                </div>
                <h2 class="text-xl font-bold">Configuration de la Classe</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nom de la classe --}}
                <div class="space-y-2 md:col-span-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Nom de la classe <span class="text-indigo-500">*</span></label>
                    <input type="text" name="name" required placeholder="Ex: 2nde A, Terminale S1..."
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-indigo-500 focus:bg-gray-800 transition-all text-gray-200">
                </div>

                {{-- Niveau --}}
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Niveau Scolaire <span class="text-indigo-500">*</span></label>
                    <div class="relative group">
                        <select name="level_id" required class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-indigo-500 focus:bg-gray-800 transition-all appearance-none cursor-pointer text-gray-200">
                            <option value="" disabled selected>Choisir un niveau</option>
                        </select>
                        {{-- Icône de la flèche du menu déroulant --}}
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                {{-- Matière --}}
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Matière Principale <span class="text-indigo-500">*</span></label>
                    <div class="relative group">
                        <select name="subject_id" required class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-indigo-500 focus:bg-gray-800 transition-all appearance-none cursor-pointer text-gray-200">
                            <option value="" disabled selected>Choisir une matière</option>
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                {{-- Enseignant --}}
<div class="space-y-2 md:col-span-2 relative">
    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Enseignant Responsable <span class="text-indigo-500">*</span></label>

    <div class="relative group">
        <input type="text" id="teacherSearch" placeholder="Rechercher un enseignant par nom..."
            class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-indigo-500 focus:bg-gray-800 transition-all text-gray-200">

        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-500">
            <i class="fa-solid fa-magnifying-glass text-xs"></i>
        </div>
    </div>

    {{-- Liste des résultats (cachée par défaut) --}}
    <div id="teacherResults" class="hidden absolute z-50 w-full mt-2 bg-gray-900 border border-gray-700 rounded-2xl shadow-2xl max-h-60 overflow-y-auto">
        </div>

    {{-- Champ caché pour envoyer l'ID au serveur --}}
    <input type="hidden" name="teacher_id" id="selectedTeacherId" required>
</div>
            </div>

            <div class="pt-6 border-t border-gray-800 flex justify-end">
                <button type="submit" id="submitBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-12 rounded-2xl transition-all active:scale-95 text-sm uppercase tracking-widest flex items-center gap-3">
                    <i class="fa-solid fa-plus-circle text-lg"></i>
                    <span>Créer la classe</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
