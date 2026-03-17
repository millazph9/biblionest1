<nav class="">
    <div class="mb-6 text-center">
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-gray-700 flex items-center justify-center gap-2">
                                
                        <img src="{{ asset('img/biblionest.jpg') }}" alt="Logo" class="w-20 h-20 object-contain">
                    
        </a>
    </div>

    <ul class="space-y-4">
        <li>
            <a href="{{ route('dashboard') }}" class="block text-gray-600 hover:text-blue-500 flex items-center gap-2">
                📊 Tableau de Bord
            </a>
        </li>
        <li>
            <a href="{{ route('books.index') }}" class="block text-gray-600 hover:text-blue-500 flex items-center gap-2">
                📚 Livres
            </a>
        </li>
        <li>
            <a href="{{ route('categories.index') }}" class="block text-gray-600 hover:text-blue-500 flex items-center gap-2">
                🏷️ Catégories
            </a>
        </li>
        <li>
            <a href="{{ route('borrowings.index') }}" class="block text-gray-600 hover:text-blue-500 flex items-center gap-2">
                📖 Emprunts
            </a>
        </li>
        <li>
            <a href="{{ route('penalties.index') }}" class="block text-gray-600 hover:text-blue-500 flex items-center gap-2">
                💰 Pénalités
            </a>
        </li>
        <li>
            <a href="{{ route('adherents.index') }}" class="block text-gray-600 hover:text-blue-500 flex items-center gap-2">
                👤 Adherents
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block text-red-600 hover:text-red-800 flex items-center gap-2">
                    🚪 Déconnexion
                </button>
            </form>
        </li>
    </ul>
</nav>
