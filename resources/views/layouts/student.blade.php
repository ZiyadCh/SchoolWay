<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School-Way | @yield('title')</title>
    @vite(['resources/css/app.css','resources/js/auth/user.js','resources/js/auth/logout.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <style>
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    ::-webkit-scrollbar-thumb {
        background-color: #f59e0b;
        border-radius: 10px;
    }
        #menu-toggle:checked ~ div aside { transform: translateX(0); }
        #menu-toggle:checked ~ div #overlay { display: block; }
    </style>
</head>
<body class="ubuntu bg-gray-950 text-gray-100 min-h-screen antialiased overflow-hidden">

    <input type="checkbox" id="menu-toggle" class="hidden">

    <div class="flex h-screen overflow-hidden relative">

        <x-student-sidebar />

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="h-16 bg-gray-900 border-b border-gray-800 px-4 lg:px-6 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-4">
                    <label for="menu-toggle" class="lg:hidden p-2 bg-gray-800 rounded-lg text-gray-300 cursor-pointer">
                        <i class="fa-solid fa-bars"></i>
                    </label>
                    <h2 class="text-lg lg:text-xl font-semibold truncate">@yield('title')</h2>
                </div>

                <div class="flex items-center justify-center gap-3">
                        <div id="username" class="font-medium uppercase text-lg">loading ...</div>
                     <div class="w-12 h-12 rounded-full border border-4 border-amber-500 bg-gray-800 overflow-hidden shrink-0">
                        <img id="header-avatar" src="https://picsum.photos/100/100?grayscale" class="w-full h-full object-cover rounded-full" alt="pfp">
                    </div>
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
