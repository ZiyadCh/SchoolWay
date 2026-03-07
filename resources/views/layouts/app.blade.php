<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School-Way - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        #menu-toggle:checked ~ div aside { transform: translateX(0); }
        #menu-toggle:checked ~ div #overlay { display: block; }
    </style>
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen font-sans antialiased overflow-hidden">

    <input type="checkbox" id="menu-toggle" class="hidden">

    <div class="flex h-screen overflow-hidden relative">

        <x-sidebar />

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="h-16 bg-gray-900 border-b border-gray-800 px-4 lg:px-6 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-4">
                    <label for="menu-toggle" class="lg:hidden p-2 bg-gray-800 rounded-lg text-gray-300 cursor-pointer">
                        <i class="fa-solid fa-bars"></i>
                    </label>
                    <h2 class="text-lg lg:text-xl font-semibold truncate">@yield('title')</h2>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <div class="font-medium text-sm">Nom Directeur</div>
                        <div class="text-[10px] text-gray-500 uppercase tracking-tighter">Directeur</div>
                    </div>
                    <div class="w-10 h-10 rounded-full border border-amber-500 text-center overflow-hidden"><img src="https://imgs.search.brave.com/BAFzpkFfMVZa4N4o3drcd7oq3fYl3MzU68AB7EFl5SY/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9zdGF0/aWMudmVjdGVlenku/Y29tL3N5c3RlbS9y/ZXNvdXJjZXMvdGh1/bWJuYWlscy8wMjcv/OTM1LzE5Mi9zbWFs/bC9oYXBweS1taWRk/bGUtYWdlZC1idXNp/bmVzcy1tYW4tY2Vv/LXN0YW5kaW5nLWlu/LW9mZmljZS1hcm1z/LWNyb3NzZWQtcGhv/dG8uanBn" alt="" class="w-full h-full object-cover"></div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 lg:p-6 space-y-6">
                @yield('content')
            </div>
        </main>

        <label for="menu-toggle" class="fixed inset-0 bg-black/60 z-40 lg:hidden hidden" id="overlay"></label>
    </div>
</body>
</html>
