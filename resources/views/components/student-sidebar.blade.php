<aside class="left-0 z-50 w-64 h-screen bg-gray-900 border-r border-gray-800 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">


    <div class="p-5 border-b border-gray-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-amber-500 p-2.5 rounded-xl shadow-md shadow-amber-500/20 text-black">
                <i class="fa-solid fa-school text-lg"></i>
            </div>
            <h1 class="text-xl font-bold tracking-tight text-white leading-none">School-Way</h1>
        </div>
        <label for="menu-toggle" class="lg:hidden p-2 text-gray-400 cursor-pointer">
            <i class="fa-solid fa-xmark"></i>
        </label>
    </div>



    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto scrollbar-hide">
        <label class="uppercase tracking-[0.2em] text-gray-500 font-black px-4 mb-4 block ">Espace Élève</label>

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

    <div class="p-4 border-t border-gray-800 bg-gray-950/30">
            <button class="w-full flex items-center justify-center gap-2 bg-red-900/10 hover:bg-red-900/30 text-red-400 py-3 rounded-xl border border-red-900/20 transition-all text-xs font-bold uppercase tracking-widest group">
                <i class="fa-solid fa-right-from-bracket transition-transform group-hover:translate-x-1"></i>
                <span>Déconnexion</span>
            </button>
    </div>
</aside>
