<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School-Way | @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/auth/user.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen font-sans antialiased overflow-x-hidden">

    <header class="h-16 bg-gray-900 border-b border-gray-800 px-6 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="bg-amber-500 p-2 rounded-lg text-black">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <span class="font-black uppercase tracking-tighter">School-Way</span>
        </div>
        <button id="logoutBtn" class="text-gray-500 hover:text-red-500 transition-colors">
            <i class="fa-solid fa-power-off"></i>
        </button>
    </header>

    <main class="p-4 lg:p-10">
        @yield('content')
    </main>

</body>
</html>
