<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    
    <!-- Script pour gérer l'ouverture et la fermeture du menu -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("-translate-x-full");
        }
    </script>
</head>
<body class="bg-gray-100 flex">

    <button class="sm:hidden p-2 fixed top-2 left-2 z-50 bg-gray-700 text-white rounded-md" onclick="toggleSidebar()">
        ☰
    </button>

    <!-- Sidebar (Navigation à gauche) -->
    <div id="sidebar" class="w-64 min-h-screen bg-white shadow-md px-11 py-6 fixed transform -translate-x-full sm:translate-x-0 transition-transform duration-300">
        @include('layouts.sidebar')
    </div>

    <!-- Contenu Principal -->
    <div id="main-content" class="flex-1 p-6 transition-all duration-300 sm:ml-64">
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow mb-4">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

</body>
</html>
