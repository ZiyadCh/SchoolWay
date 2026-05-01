@extends('layouts.teacher')
@section('title', 'Détail Classe - School-Way')
@section('content')
@vite(['resources/js/teacher/class-detail.js'])
<div class="w-full h-full p-6 md:p-12 text-white">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <a href="/teacher/classes" class="text-[10px] text-gray-500 font-black uppercase tracking-widest hover:text-amber-500 transition-colors">← Mes Classes</a>
                <h2 id="class-name" class="text-3xl font-black uppercase tracking-tighter mt-1">Chargement...</h2>
                <div class="w-12 h-1 bg-amber-500 mt-2 rounded-full"></div>
            </div>
            <div class="flex gap-3">
                <button id="btn-add-devoir" class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-lg bg-amber-500 hover:bg-amber-400 text-black transition-colors">
                    + Devoir
                </button>
                <button id="btn-add-exam" class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-lg border border-gray-700 text-gray-400 hover:border-amber-500 hover:text-amber-500 transition-colors">
                    + Examen
                </button>
            </div>
        </div>

        <!-- Students Table -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-950/50 border-b border-gray-800">
                        <th class="p-5 text-[10px] font-black uppercase tracking-widest text-gray-500">Étudiant</th>
                        <th class="p-5 text-[10px] font-black uppercase tracking-widest text-gray-500">Email</th>
                        <th class="p-5 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Action</th>
                    </tr>
                </thead>
                <tbody id="students-body" class="divide-y divide-gray-800/50">
                    <tr>
                        <td colspan="3" class="p-10 text-center animate-pulse text-gray-500 uppercase font-black text-xs tracking-widest">
                            Chargement des élèves...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Devoir Modal -->
<div id="devoir-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-sm font-black uppercase tracking-widest text-white">Nouveau Devoir</h3>
            <button class="close-modal text-gray-600 hover:text-white transition-colors text-xl leading-none">&times;</button>
        </div>
        <div class="space-y-5">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Titre</label>
                <input id="devoir-title" type="text" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors" placeholder="Ex: Exercices chapitre 3">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Date limite</label>
                <input id="devoir-deadline" type="date" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Description</label>
                <textarea id="devoir-contenu" rows="3" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors resize-none" placeholder="Instructions..."></textarea>
            </div>
            <p id="devoir-message" class="text-[11px] font-bold text-center hidden"></p>
            <button id="submit-devoir" class="w-full py-3 bg-amber-500 hover:bg-amber-400 text-black text-[11px] font-black uppercase tracking-widest rounded-lg transition-colors">
                Créer le devoir
            </button>
        </div>
    </div>
</div>

<!-- Add Exam Modal -->
<div id="exam-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-sm font-black uppercase tracking-widest text-white">Nouvel Examen</h3>
            <button class="close-modal text-gray-600 hover:text-white transition-colors text-xl leading-none">&times;</button>
        </div>
        <div class="space-y-5">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Titre</label>
                <input id="exam-title" type="text" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors" placeholder="Ex: Contrôle N°1">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Date</label>
                <input id="exam-date" type="date" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors">
            </div>
            <p id="exam-message" class="text-[11px] font-bold text-center hidden"></p>
            <button id="submit-exam" class="w-full py-3 bg-amber-500 hover:bg-amber-400 text-black text-[11px] font-black uppercase tracking-widest rounded-lg transition-colors">
                Créer l'examen
            </button>
        </div>
    </div>
</div>

<!-- Add Absence Modal -->
<div id="absence-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-sm font-black uppercase tracking-widest text-white">Ajouter une Absence</h3>
            <button class="close-modal text-gray-600 hover:text-white transition-colors text-xl leading-none">&times;</button>
        </div>
        <div class="space-y-5">
            <p id="absence-student-name" class="text-sm font-black text-white uppercase"></p>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Date</label>
                <input id="absence-date" type="date" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors">
            </div>
            <p id="absence-message" class="text-[11px] font-bold text-center hidden"></p>
            <button id="submit-absence" class="w-full py-3 bg-amber-500 hover:bg-amber-400 text-black text-[11px] font-black uppercase tracking-widest rounded-lg transition-colors">
                Enregistrer
            </button>
        </div>
    </div>
</div>
@endsection
