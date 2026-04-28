@extends('layouts.app')

@section('title', 'Ajouter un Étudiant')

@section('content')
@vite('resources/js/forms/add-students.js')

<div class="max-w-4xl mx-auto space-y-8 text-white pb-12">

    <div>
        <h1 class="text-3xl font-black tracking-tight">Nouvel Étudiant</h1>
        <p class="text-gray-400 mt-1 text-sm">Inscrire un nouvel élève manuellement ou via un fichier Excel.</p>
    </div>

    {{-- Formulaire Manuel --}}
    <form enctype="multipart/form-data" id="studentForm" class="space-y-6">
        @csrf
        <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] p-8 space-y-8">

            <div class="flex items-center gap-4 border-b border-gray-800 pb-6">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-user-plus text-amber-500"></i>
                </div>
                <h2 class="text-xl font-bold">Informations de l'utilisateur</h2>
            </div>

            {{-- Photo de Profil --}}
            <div class="flex flex-col items-center justify-center space-y-4 pb-8">
                <label for="studentImage" class="relative group cursor-pointer block hover:scale-105 transition-transform duration-300">
                    <div id="imagePreview" class="w-32 h-32 rounded-full border-2 border-dashed border-gray-700 bg-gray-800/50 flex items-center justify-center overflow-hidden transition-all group-hover:border-amber-500 group-hover:bg-gray-800 shadow-2xl">
                        <i class="fa-solid fa-camera text-3xl text-gray-600 group-hover:text-amber-500 transition-colors"></i>
                        <img id="previewImg" src="" class="hidden w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/60 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fa-solid fa-pen text-white text-xs"></i>
                        </div>
                    </div>
                    <input type="file" name="image" id="studentImage" class="hidden" accept="image/*">
                </label>
                <div class="text-center">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">Photo de profil (Optionnel)</span>
                </div>
            </div>

            {{-- Grille de saisie --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Nom <span class="text-amber-500">*</span></label>
                    <input type="text" name="nom" required placeholder="Ex: Dupont"
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-amber-500 focus:bg-gray-800 transition-all text-gray-200">
                    <p id="error-nom" class="text-red-500 text-xs ml-4 hidden"></p>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Prénom <span class="text-amber-500">*</span></label>
                    <input type="text" name="prenom" required placeholder="Ex: Jean"
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-amber-500 focus:bg-gray-800 transition-all text-gray-200">
                    <p id="error-prenom" class="text-red-500 text-xs ml-4 hidden"></p>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Email <span class="text-amber-500">*</span></label>
                    <input type="email" name="email" required placeholder="jean.dupont@email.com"
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-amber-500 focus:bg-gray-800 transition-all text-gray-200">
                    <p id="error-email" class="text-red-500 text-xs ml-4 hidden"></p>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Sexe <span class="text-amber-500">*</span></label>
                    <div class="relative">
                        <select name="gender" required class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-amber-500 focus:bg-gray-800 transition-all appearance-none cursor-pointer text-gray-200">
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-gray-600 pointer-events-none text-xs"></i>
                    </div>
                    <p id="error-gender" class="text-red-500 text-xs ml-4 hidden"></p>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Date de naissance</label>
                    <input type="date" name="birthday"
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-amber-500 focus:bg-gray-800 transition-all text-gray-200">
                    <p id="error-birthday" class="text-red-500 text-xs ml-4 hidden"></p>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Lieu de naissance</label>
                    <input type="text" name="birthplace" placeholder="Ville"
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-amber-500 focus:bg-gray-800 transition-all text-gray-200">
                    <p id="error-birthplace" class="text-red-500 text-xs ml-4 hidden"></p>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Téléphone</label>
                    <input type="tel" name="tel" placeholder="+212..."
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-amber-500 focus:bg-gray-800 transition-all text-gray-200">
                    <p id="error-tel" class="text-red-500 text-xs ml-4 hidden"></p>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-gray-500 ml-4">Adresse</label>
                    <input type="text" name="adress" placeholder="Rue..."
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-2xl px-6 py-4 focus:outline-none focus:border-amber-500 focus:bg-gray-800 transition-all text-gray-200">
                    <p id="error-adress" class="text-red-500 text-xs ml-4 hidden"></p>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-800 flex justify-end">
                <button type="submit" id="submitBtn" class="bg-amber-500 hover:bg-amber-600 text-black font-black py-4 px-12 rounded-2xl transition-all active:scale-95 text-sm uppercase tracking-widest flex items-center gap-3">
                    <i class="fa-solid fa-plus text-lg"></i>
                    <span>Enregistrer</span>
                </button>
            </div>
        </div>
    </form>

    {{-- Formulaire Excel --}}
    <form id="excelForm" class="space-y-6">
        @csrf
        <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] p-8 space-y-6">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-file-excel text-emerald-500"></i>
                </div>
                <h2 class="text-xl font-bold">Importation Groupée</h2>
            </div>

            <div id="excelAlert" class="hidden px-6 py-4 rounded-2xl text-sm font-bold border"></div>

            <div id="dropzone" class="border-2 border-dashed border-gray-800 rounded-3xl p-10 flex flex-col items-center justify-center hover:border-emerald-500/50 transition-colors cursor-pointer group bg-gray-800/30">
                <input type="file" name="file" id="excelFile" class="hidden" accept=".xlsx, .xls, .csv">
                <div class="w-16 h-16 rounded-2xl bg-gray-800 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform border border-gray-700">
                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-500 group-hover:text-emerald-500"></i>
                </div>
                <p id="dropzoneText" class="font-bold text-center text-gray-300">Cliquez ou glissez votre fichier Excel ici</p>
            </div>

            <div class="flex justify-center">
                <button type="submit" id="importBtn" disabled class="bg-emerald-500 hover:bg-emerald-600 disabled:bg-gray-800 disabled:text-gray-500 text-black font-black py-4 px-12 rounded-2xl transition-all text-sm uppercase tracking-widest flex items-center gap-3">
                    <i class="fa-solid fa-upload"></i>
                    <span>Lancer l'importation</span>
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
