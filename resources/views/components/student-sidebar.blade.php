<div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity"></div>

<button id="sidebar-open" class="lg:hidden fixed top-4 left-4 z-30 p-2 text-gray-400 hover:text-white cursor-pointer">
    <i class="fa-bars text-xl"></i>
</button>
<aside id="main-sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 border-r border-gray-800 flex flex-col
    transition-transform duration-300 ease-in-out -translate-x-full
    lg:relative lg:translate-x-0">

    <div class="p-5 border-b border-gray-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-amber-500 p-3 rounded-xl shadow-md text-black">
                <i class="fa-solid fa-school text-lg"></i>
            </div>
            <h1 class="text-xl font-bold text-white leading-none">School-Way</h1>
        </div>

        <button id="sidebar-close" class="lg:hidden p-2 text-gray-400 hover:text-white transition-colors">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>
    </div>

    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
        <label class="uppercase text-gray-500 font-black px-4 mb-4 block text-[10px] tracking-widest">Espace Élève</label>

        <x-sidebar-link href="/student/profile" icon="fa-user-graduate" :active="request()->is('student/profile*')">
            Mon Profil
        </x-sidebar-link>
        <x-sidebar-link href="/student/notes" icon="fa-file-signature" :active="request()->is('student/notes*')">
            Notes & Bulletins
        </x-sidebar-link>
        <x-sidebar-link href="/student/absences" icon="fa-calendar-check" :active="request()->is('student/absences*')">
            Mes Absences
        </x-sidebar-link>
        <x-sidebar-link href="/student/devoirs" icon="fa-book-open-reader" :active="request()->is('student/devoirs*')">
            Mes Devoirs
        </x-sidebar-link>
        <x-sidebar-link href="/student/paiements" icon="fa-wallet" :active="request()->is('student/paiements*')">
            Scolarité
        </x-sidebar-link>
    </nav>

    <div class="p-4 border-t border-gray-800 bg-black/20">
        <button id="logoutBtn" class="w-full flex items-center justify-center gap-2 bg-red-900/10 hover:bg-red-900/30 text-red-400 py-4 rounded-xl border border-red-900/20 transition-all text-xs font-bold uppercase group">
            <i class="fa-solid fa-right-from-bracket transition-transform group-hover:translate-x-1"></i>
            <span>Déconnexion</span>
        </button>
    </div>
</aside>
@vite('resources/js/core/sidebar.js')
