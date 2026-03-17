<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bibliothèque Laravel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">
    <div class="min-h-screen flex flex-col justify-center items-center p-6">
        <!-- Logo ou titre -->
        <h1 class="text-3xl sm:text-5xl font-bold mb-6 text-center text-blue-600">
            📚 Gestion de Bibliothèque
        </h1>

        <!-- Description -->
        <p class="text-center text-lg text-gray-600 max-w-2xl mb-8">
            Bienvenue dans l'application de gestion de bibliothèque développée avec Laravel. Gérer les livres, les emprunts, les adhérents et les pénalités n’a jamais été aussi simple !
        </p>

        <!-- Actions rapides -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-10">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow transition">
                    🎛️ Accéder au Tableau de Bord
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow transition">
                    🔐 Se connecter
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg shadow transition">
                        📝 Créer un compte
                    </a>
                @endif
            @endauth
        </div>

        <!-- Infos projet -->
        <div class="text-center text-sm text-gray-500">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} • PHP v{{ PHP_VERSION }}
        </div>
    </div>
</body>
</html>
