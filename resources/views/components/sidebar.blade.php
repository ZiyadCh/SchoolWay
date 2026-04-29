<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

<button id="sidebar-open" class="lg:hidden fixed top-4 left-4 z-30 p-2 text-gray-400 hover:text-white cursor-pointer">
    <i class="fa-bars text-xl"></i>
</button>

<aside id="main-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 -translate-x-full bg-gray-900 border-r border-gray-800 flex flex-col transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0">
    <div class="p-5 border-b border-gray-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-amber-500 p-2.5 rounded-xl shadow-md shadow-amber-500/20 text-black">
                <i class="fa-solid fa-school text-lg"></i>
            </div>
            <h1 class="text-xl font-bold tracking-tight text-white leading-none">School-Way</h1>
        </div>
        <button id="sidebar-close" class="lg:hidden p-2 text-gray-400 hover:text-white cursor-pointer">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>
    <div class="px-4 py-4 border-b border-gray-800 bg-gray-900/50">

<div class="relative w-full max-w-50>
    <label class="text-[10px] uppercase tracking-widest text-gray-500 font-bold ml-1">
        Année Scolaire
    </label>

    <div class="relative mt-1">
        <select class="w-full appearance-none bg-gray-800 border border-gray-700 text-amber-400 text-sm font-medium rounded-lg px-3 py-2 pr-10 focus:outline-none focus:border-amber-500/50 focus:ring-1 focus:ring-amber-500/20 transition-all cursor-pointer">
            <option value="2025-2026" selected>2025 - 2026</option>
            <option value="2024-2025">2024 - 2025</option>
            <option value="2023-2024">2023 - 2024</option>
        </select>

        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
            <i class="fa-solid fa-right-left text-[10px]"></i>
        </div>
    </div>
</div>
    </div>
    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
        <label class="text-[10px] uppercase text-gray-500 font-black px-4 mb-4 block">Menu Principal</label>
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
        <button id="logoutBtn" class="w-full flex items-center justify-center gap-2 bg-red-900/10 hover:bg-red-900/30 text-red-400 py-3 rounded-xl border border-red-900/20 transition-all text-xs font-bold uppercase tracking-widest">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Déconnexion</span>
        </button>
    </div>
</aside>

@vite('resources/js/core/sidebar.js')
