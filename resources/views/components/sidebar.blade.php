<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 border-r border-gray-800 flex flex-col transform -translate-x-full transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0">

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

    <div class="px-4 py-4 border-b border-gray-800 bg-gray-900/50">
        <label class="text-[10px] uppercase tracking-widest text-gray-500 font-bold ml-1">Année Scolaire</label>
        <div class="mt-1 flex items-center justify-between bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
            <span class="text-sm font-medium text-amber-400">2025 - 2026</span>
            <i class="fa-solid fa-right-left text-xs text-gray-500"></i>
        </div>
    </div>

    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
    <label class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-black px-4 mb-4 block">Menu Principal</label>

    <x-sidebar-link href="/administration/dashboard" icon="fa-chart-column" :active="request()->is('/')">
        Tableau de bord
    </x-sidebar-link>

    <x-sidebar-link href="/administration/classes" icon="fa-chalkboard-user" :active="request()->is('classes*')">
        Classes
    </x-sidebar-link>

    <x-sidebar-link href="/administration/teachers" icon="fa-person-chalkboard" :active="request()->is('teachers*')">
        Enseignants
    </x-sidebar-link>

    <x-sidebar-link href="/administration/students" icon="fa-users" :active="request()->is('students*')">
        Élèves
    </x-sidebar-link>

    <x-sidebar-link href="/administration/paiments" icon="fa-credit-card" :active="request()->is('paiments*')">
        Paiements
    </x-sidebar-link>
</nav>

    <div class="p-4 border-t border-gray-800 bg-gray-950/30">

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-900/10 hover:bg-red-900/30 text-red-400 py-3 rounded-xl border border-red-900/20 transition-all text-xs font-bold uppercase tracking-widest">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</aside>
