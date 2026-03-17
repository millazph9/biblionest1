<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl sm:text-2xl font-bold mb-4 text-center">📚 Liste des Livres</h1>

        <!-- Bouton Ajouter un Livre -->
        <div class="w-full flex justify-center sm:justify-start mb-4">
            <a href="{{ route('books.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105 flex items-center gap-2 text-sm sm:text-base">
                ➕ Ajouter un livre
            </a>
        </div>

        <!-- Barre de recherche -->
        <form method="GET" action="{{ route('books.index') }}" class="mb-4 flex justify-center">
            <input type="text" name="search" placeholder="Rechercher un livre..." value="{{ request('search') }}"
                   class="border px-3 py-2 rounded-lg w-full sm:w-1/2">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 ml-2 rounded-lg shadow-md">
                🔍 Rechercher
            </button>
        </form>

        <!-- Affichage Desktop -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mt-4">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm sm:text-base">
                        <th class="py-2 px-4 border">ISBN</th>
                        <th class="py-2 px-4 border">Titre</th>
                        <th class="py-2 px-4 border">Auteur</th>
                        <th class="py-2 px-4 border">Année</th>
                        <th class="py-2 px-4 border">Catégorie</th>
                        <th class="py-2 px-4 border">Copies Dispo</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr class="hover:bg-gray-50 text-sm sm:text-base">
                            <td class="py-2 px-4 border">{{ $book->isbn }}</td>
                            <td class="py-2 px-4 border">{{ $book->title }}</td>
                            <td class="py-2 px-4 border">{{ $book->author }}</td>
                            <td class="py-2 px-4 border">{{ $book->published_year }}</td>
                            <td class="py-2 px-4 border">{{ $book->category->name ?? 'Non catégorisé' }}</td>
                            <td class="py-2 px-4 border text-center">{{ $book->copies_available }}</td>
                            <td class="py-2 px-4 border">
                                <a href="{{ route('books.edit', $book->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                                </form>
                            </td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $books->links() }}
        </div>

        <!-- Affichage Mobile -->
        <div class="sm:hidden flex flex-col gap-4">
            @foreach ($books as $book)
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                    <p class="font-bold text-lg">{{ $book->title }}</p>
                    <p class="text-sm text-gray-600">Auteur : <span class="font-medium">{{ $book->author }}</span></p>
                    <p class="text-sm text-gray-600">📅 Année : <span class="font-medium">{{ $book->published_year }}</span></p>
                    <p class="text-sm text-gray-600">🏷️ Catégorie : <span class="font-medium">{{ $book->category->name ?? 'Non catégorisé' }}</span></p>
                    <p class="text-sm text-gray-600">📖 Copies Dispo : <span class="font-medium">{{ $book->copies_available }}</span></p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
