<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School-Way - Responsive Dashboard</title>
<script src="script.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-gray-950 text-gray-100 min-h-screen font-sans antialiased overflow-hidden">

  <input type="checkbox" id="menu-toggle" class="hidden">

  <div class="flex h-screen overflow-hidden relative">

    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 border-r border-gray-800 flex flex-col transform -translate-x-full transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0">

      <div class="p-5 border-b border-gray-800 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-amber-500 p-2.5 rounded-xl shadow-md shadow-amber-500/20">
                            <i src =""></i>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-white leading-none">School-Way</h1>
            </div>
        </div>
        <label for="menu-toggle" class="lg:hidden p-2 text-gray-400 cursor-pointer">
            <i class="fa-solid fa-xmark"></i>
        </label>
      </div>

      <div class="px-4 py-4 border-b border-gray-800 bg-gray-900/50">
        <label class="text-[10px] uppercase tracking-widest text-gray-500 font-bold ml-1">Année Scolaire</label>
        <div class="mt-1 flex items-center justify-between bg-gray-800 border border-gray-700 rounded-lg px-3 py-2">
            <span class="text-sm font-medium text-amber-400">2025 - 2026</span>
            <i class="fa-solid fa-calendar-check text-xs text-gray-500"></i>
        </div>
      </div>

      <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
        <a href="#" class="flex items-center gap-3 px-4 py-3 bg-gray-800 text-white rounded-xl font-medium transition-colors">
          <i class="fa-solid fa-gauge text-amber-400"></i>
          <span>Tableau de bord</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-gray-200 rounded-xl transition">
          <i class="fa-solid fa-chalkboard"></i>
          <span>Classes</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-gray-200 rounded-xl transition">
          <i class="fa-solid fa-user-tie"></i>
          <span>Maîtres</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-gray-200 rounded-xl transition">
          <i class="fa-solid fa-users"></i>
          <span>Élèves</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-gray-200 rounded-xl transition">
          <i class="fa-solid fa-money-bill-wave"></i>
          <span>Paiements</span>
        </a>
      </nav>

      <div class="p-4 border-t border-gray-800">
        <button class="w-full flex items-center justify-center gap-2 bg-red-900/20 hover:bg-red-900/40 text-red-400 py-3 rounded-xl border border-red-900/30 transition text-sm font-medium">
          <i class="fa-solid fa-right-from-bracket"></i>
          <span>Déconnexion</span>
        </button>
      </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

      <header class="h-16 bg-gray-900 border-b border-gray-800 px-4 lg:px-6 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-4">
            <!-- toggle sidebare for mobile-->
            <label onclick="sidebar" for="menu-toggle" class="lg:hidden p-2 bg-gray-800 rounded-lg text-gray-300 cursor-pointer">
                <i class="fa-solid fa-bars"></i>
            </label>
            <h2 class="text-lg lg:text-xl font-semibold truncate">Tableau de bord</h2>
        </div>

        <div class="flex items-center gap-3">
          <div class="text-right hidden sm:block">
            <div class="font-medium text-sm">M. Karim</div>
            <div class="text-[10px] text-gray-500 uppercase tracking-tighter">Directeur</div>
          </div>
          <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center font-bold text-black text-lg shadow-lg shadow-amber-500/10">KA</div>
        </div>
      </header>

      <div class="flex-1 overflow-y-auto p-4 lg:p-6 space-y-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

          <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-amber-600/40 transition-all duration-300 group">
            <div class="flex justify-between items-start">
              <div>
                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Élèves</p>
                <p class="text-3xl font-bold mt-1 group-hover:text-amber-400 transition-colors">1 248</p>
              </div>
              <div class="bg-emerald-500/10 text-emerald-400 p-3 rounded-xl">
                <i class="fa-solid fa-users text-lg"></i>
              </div>
            </div>
          </div>

          <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-amber-600/40 transition-all">
            <div class="flex justify-between items-start">
              <div>
                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Paiements</p>
                <p class="text-3xl font-bold mt-1">92%</p>
              </div>
              <div class="bg-amber-500/10 text-amber-500 p-3 rounded-xl">
                <i class="fa-solid fa-hand-holding-dollar text-lg"></i>
              </div>
            </div>
            <div class="mt-4 h-1.5 bg-gray-800 rounded-full overflow-hidden">
              <div class="h-full w-[92%] bg-amber-500 rounded-full"></div>
            </div>
            <p class="text-[10px] text-gray-500 mt-2 font-medium">100 règlements en retard</p>
          </div>

          <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-amber-600/40 transition-all">
            <div class="flex justify-between items-start">
              <div>
                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Revenu (mensuel)</p>
                <p class="text-3xl font-bold mt-1 truncate">347k <span class="text-sm font-normal text-amber-500">MAD</span></p>
              </div>
              <div class="bg-blue-500/10 text-blue-400 p-3 rounded-xl">
                <i class="fa-solid fa-sack-dollar text-lg"></i>
              </div>
            </div>
          </div>

          <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 hover:border-amber-600/40 transition-all">
            <div class="flex justify-between items-start">
              <div>
                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Classes</p>
                <p class="text-3xl font-bold mt-1">38</p>
              </div>
              <div class="bg-purple-500/10 text-purple-400 p-3 rounded-xl">
                <i class="fa-solid fa-chalkboard-user text-lg"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 shadow-sm">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <i class="fa-solid fa-calendar-day text-amber-500"></i>
                Calendrier – Mars 2026
            </h3>
            <div class="flex gap-2">
              <button class="flex-1 sm:flex-none p-2.5 bg-gray-800 hover:bg-gray-700 rounded-xl text-sm transition"><i class="fa-solid fa-chevron-left"></i></button>
              <button class="flex-1 sm:flex-none p-2.5 bg-gray-800 hover:bg-gray-700 rounded-xl text-sm transition"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
          </div>

          <div class="overflow-x-auto">
            <div class="min-w-[400px] grid grid-cols-7 gap-1 text-center text-sm">
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Dim</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Lun</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Mar</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Mer</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Jeu</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Ven</div>
                <div class="text-gray-500 font-bold text-[10px] uppercase pb-4">Sam</div>

                <div class="text-gray-700 py-3">26</div><div class="text-gray-700 py-3">27</div><div class="text-gray-700 py-3">28</div>
                <div class="py-3 hover:bg-gray-800 rounded-xl transition cursor-pointer">1</div>
                <div class="py-3 hover:bg-gray-800 rounded-xl transition cursor-pointer">2</div>
                <div class="py-3 border border-amber-500/30 text-amber-500 font-bold rounded-xl">3</div>
                <div class="bg-amber-600 text-black font-bold py-3 rounded-xl shadow-lg shadow-amber-600/20">4</div>
                <div class="py-3 hover:bg-gray-800 rounded-xl transition cursor-pointer">5</div>
                <div class="py-3 font-semibold text-white">6</div>
                <div class="py-3">7</div><div class="py-3">8</div><div class="py-3">9</div><div class="py-3">10</div><div class="py-3">11</div>
            </div>
          </div>
        </div>

      </div>
    </main>

    <label for="menu-toggle" class="fixed inset-0 bg-black/60 z-40 lg:hidden hidden" id="overlay"></label>
  </div>

</body>
</html>
