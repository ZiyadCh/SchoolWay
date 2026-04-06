<head>
    @vite(['resources/css/app.css','resources/js/auth/login.js'])
</head>
<body class="bg-gray-900"> <div class="min-h-screen bg-gray-900 flex flex-col items-center justify-center p-6 text-gray-100">
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl border border-gray-700 p-10">

        <div class="flex flex-col items-center mb-8">
           <h1 class="text-2xl font-bold text-white">School-Way</h1>
        </div>

        <form id="loginForm" class="space-y-5">

            <div id="errorAlert" class="hidden mb-4 p-4 bg-red-500/10 border border-red-500/30 rounded-lg text-red-400 text-sm">
                <span id="errorMessage"></span>
            </div>
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="votre@email.com"
                       class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-500 focus:ring-2 focus:ring-amber-400 focus:border-transparent outline-none transition"
                       required>
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Mot de passe</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="••••••••"
                       class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-500 focus:ring-2 focus:ring-amber-400 focus:border-transparent outline-none transition"
                       required>
            </div>


            <button type="submit"
                    class="w-full bg-amber-400 hover:bg-amber-500 text-black font-bold py-3 rounded-lg transition-all duration-200 transform hover:scale-[1.02] active:scale-95 mt-2">
                Se connecter
            </button>

        </form>
    </div>
</div>
</body>
