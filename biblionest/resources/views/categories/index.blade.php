<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl sm:text-2xl font-bold mb-4 text-center">🏷️ Liste des Catégories</h1>

        <div class="w-full flex justify-center sm:justify-start mb-4">
            <a href="{{ route('categories.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105">
                ➕ Ajouter une Catégorie
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm sm:text-base">
                        <th class="py-2 px-4 border">Nom</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="hover:bg-gray-50 text-sm sm:text-base">
                            <td class="py-2 px-4 border">{{ $category->name }}</td>
                            <td class="py-2 px-4 border">
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
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
    </div>
</x-app-layout>
