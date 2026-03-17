<head>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900"> <div class="min-h-screen bg-gray-900 flex flex-col items-center justify-center p-6 text-gray-100">
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl border border-gray-700 p-10">

        <div class="flex flex-col items-center mb-8">
            <div class="bg-amber-400 p-2 rounded-lg mb-4 shadow-lg shadow-amber-400/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">School-Way</h1>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="code" class="block text-sm font-medium text-gray-300 mb-1">Code Etudiant</label>
                <input type="code"
                       id="code"
                       name="code"
                       value="{{ old('code') }}"
                       placeholder="XXXX"
                       class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 text-white placeholder-gray-500 focus:ring-2 focus:ring-amber-400 focus:border-transparent outline-none transition"
                       required>
                @error('code')
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
