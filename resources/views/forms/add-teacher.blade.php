@extends('layouts.app')

@section('title', 'Ajouter un Enseignant')

@section('content')
@vite('resources/js/forms/add-teacher.js')
<div class="max-w-4xl mx-auto space-y-8 text-white pb-12">

    <div>
        <h1 class="text-3xl font-black tracking-tight">Nouvel Enseignant</h1>
        <p class="text-gray-400 mt-1 text-sm">Enregistrer un nouveau membre du corps professoral dans le système.</p>
    </div>

    <form id="teacherForm" class="space-y-6">
        @csrf
        <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] p-8 space-y-8">
            <div class="flex items-center gap-4 border-b border-gray-800 pb-6">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-chalkboard-user text-blue-500"></i>
                </div>
                <h2 class="text-xl font-bold">Informations de l'Enseignant</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nom --}}
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Nom <span class="text-amber-500">*</span></label>
                    <input type="text" name="nom" required placeholder="Ex: Lemaitre"
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-blue-500 focus:bg-gray-800 transition-all text-gray-200">
                </div>

                {{-- Prénom --}}
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Prénom <span class="text-amber-500">*</span></label>
                    <input type="text" name="prenom" required placeholder="Ex: Sophie"
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-blue-500 focus:bg-gray-800 transition-all text-gray-200">
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Email Professionnel <span class="text-amber-500">*</span></label>
                    <input type="email" name="email" required placeholder="s.lemaitre@ecole.com"
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-blue-500 focus:bg-gray-800 transition-all text-gray-200">
                </div>

                {{-- Sexe --}}
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Sexe <span class="text-amber-500">*</span></label>
                    <div class="relative">
                        <select name="gender" required class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-blue-500 focus:bg-gray-800 transition-all appearance-none cursor-pointer text-gray-200">
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-gray-600 pointer-events-none text-xs"></i>
                    </div>
                </div>

                {{-- Téléphone --}}
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Téléphone</label>
                    <input type="tel" name="tel" placeholder="+212..."
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-blue-500 focus:bg-gray-800 transition-all text-gray-200">
                </div>

                {{-- Adresse --}}
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Adresse</label>
                    <input type="text" name="adress" placeholder="Rue..."
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-blue-500 focus:bg-gray-800 transition-all text-gray-200">
                </div>

                {{-- Champ caché pour le rôle --}}
                <input type="hidden" name="role" value="teacher">
            </div>

            <div class="pt-6 border-t border-gray-800 flex justify-end">
                <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-12 rounded-2xl transition-all active:scale-95 text-sm uppercase tracking-widest flex items-center gap-3">
                    <i class="fa-solid fa-save text-lg"></i>
                    <span>Enregistrer l'enseignant</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
