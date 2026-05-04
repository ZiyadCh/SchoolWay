@extends('layouts.teacher')
@section('title', 'Mon Profil - School-Way')
@section('content')
@vite(['resources/js/teacher/profile.js', 'resources/js/auth/reset-password.js'])
<div class="w-full h-full p-4 md:p-8">
    <div class="max-w-8xl mx-auto bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl">
        <div class="p-8 md:p-12">
            <div class="flex flex-col lg:flex-row items-center lg:items-start gap-10">
                <div class="shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden bg-gray-800 border border-gray-700 p-1">
                        <img id="user-avatar" src="" alt="pfp" class="w-full h-full object-cover rounded-xl">
                    </div>
                </div>
                <div class="flex-1 w-full">
                    <div class="mb-8 text-center lg:text-left">
                        <h2 id="user-fullname" class="text-4xl md:text-5xl font-black uppercase tracking-tighter text-white">CHARGEMENT...</h2>
                        <p class="text-[10px] text-amber-500 font-black uppercase tracking-widest mt-2">Enseignant</p>
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
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Email</p>
                            <p id="user-email" class="text-sm md:text-base font-bold text-amber-500/90 truncate uppercase tracking-tight">chargement...</p>
                        </div>
                        <div class="col-span-2 space-y-1">
                            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">Membre depuis</p>
                            <p id="user-joined" class="text-sm md:text-base font-bold text-gray-200 uppercase italic">--/--/----</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-800 pt-8 mt-8">
                        <button id="open-reset-modal" class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-lg border border-gray-700 text-gray-400 hover:border-amber-500 hover:text-amber-500 transition-colors">
                            Changer le mot de passe
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Reset Password Modal -->
<div id="reset-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-sm font-black uppercase tracking-widest text-white">Changer le mot de passe</h3>
            <button id="close-reset-modal" class="text-gray-600 hover:text-white transition-colors text-xl leading-none">&times;</button>
        </div>
        <div class="space-y-5">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Nouveau mot de passe</label>
                <input id="new-password" type="password" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Confirmer le mot de passe</label>
                <input id="new-password-confirmation" type="password" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-3 text-sm text-white outline-none focus:border-amber-500 transition-colors" placeholder="••••••••">
            </div>
            <p id="reset-message" class="text-[11px] font-bold text-center hidden"></p>
            <button id="submit-reset" class="w-full py-3 bg-amber-500 hover:bg-amber-400 text-black text-[11px] font-black uppercase tracking-widest rounded-lg transition-colors">
                Confirmer
            </button>
        </div>
    </div>
</div>
@endsection
