<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("-translate-x-full");
            document.getElementById("main-content").classList.toggle("ml-64");
        }
    </script>
</head>
<body class="bg-gray-100 flex">

    <!-- Bouton "burger" pour mobile -->
    <!-- <button class="sm:hidden p-4 focus:outline-none fixed top-2 left-2 z-50 bg-gray-700 text-black rounded-md" onclick="toggleSidebar()"> #}
        ☰
    </button> -->

    <!-- Sidebar (Navigation) -->
    <nav id="sidebar" class="w-64 min-h-screen bg-white shadow-md px-4 py-6 fixed transform -translate-x-full sm:translate-x-0 transition-transform duration-300">
        <div class="mb-6 text-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-700">
                📚 {{ config('app.name', 'Laravel') }}
            </a>
        </div>
        
        <ul class="space-y-4">
            <li>
                <a href="{{ route('dashboard') }}" class="block text-gray-600 hover:text-blue-500">
                    📊 Tableau de Bord
                </a>
            </li>
            <li>
                <a href="{{ route('books.index') }}" class="block text-gray-600 hover:text-blue-500">
                    📚 Livres
                </a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="block text-gray-600 hover:text-blue-500">
                    🏷️ Catégories
                </a>
            </li>
            <li>
                <a href="{{ route('borrowings.index') }}" class="block text-gray-600 hover:text-blue-500">
                    📖 Emprunts
                </a>
            </li>
            <li>
                <a href="{{ route('penalties.index') }}" class="block text-gray-600 hover:text-blue-500">
                    💰 Pénalités
                </a>
            </li>
            <li>
                <a href="{{ route('adherents.index') }}" class="block text-gray-600 hover:text-blue-500">
                    👤 Adherents
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block text-red-600 hover:text-red-800">
                        🚪 Déconnexion
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Contenu Principal -->
    <div id="main-content" class="w-full p-6 transition-all duration-300 sm:ml-64">
        {{ $slot }}
    </div>

</body>
</html>
