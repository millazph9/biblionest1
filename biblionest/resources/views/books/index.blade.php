<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">📚 Liste des Livres</h1>


        <!-- Formulaire de filtre par catégorie -->
        <form method="GET" action="{{ route('books.index') }}" class="mb-4 flex gap-4">
            <label for="category_id" class="text-lg">Filtrer par catégorie :</label>
            <select name="category_id" id="category_id" class="border px-4 py-2">
                <option value="">Toutes les catégories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-black px-4 py-2">Filtrer</button>
            <div class="flex justify-end mb-4">
            <a href="{{ route('books.export.pdf') }}" 
               class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow-md transition transform hover:scale-105 flex items-center gap-2 text-sm w-fit">
                📄 Exporter en PDF
            </a>
        </div>
        </form>

        <!-- Tableau des livres -->
        <table class="min-w-full bg-white border border-gray-200 mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border">ISBN</th>
                    <th class="py-2 px-4 border">Titre</th>
                    <th class="py-2 px-4 border">Auteur</th>
                    <th class="py-2 px-4 border">Année</th>
                    <th class="py-2 px-4 border">Catégorie</th>
                    <th class="py-2 px-4 border">Copies Dispo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td class="py-2 px-4 border">{{ $book->isbn }}</td>
                        <td class="py-2 px-4 border">{{ $book->title }}</td>
                        <td class="py-2 px-4 border">{{ $book->author }}</td>
                        <td class="py-2 px-4 border">{{ $book->published_year }}</td>
                        <td class="py-2 px-4 border">{{ $book->category->name ?? 'Non catégorisé' }}</td>
                        <td class="py-2 px-4 border">{{ $book->copies_available }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
