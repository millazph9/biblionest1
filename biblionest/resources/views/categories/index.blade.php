<x-app-layout>
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Catégories</h1>
            <a href="{{ route('categories.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition hover:scale-105 text-sm sm:text-base">
                ➕ Ajouter une catégorie
            </a>
        </div>

        <!-- Liste des catégories sous forme de cartes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($categories as $category)
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200 flex justify-between items-center">
                    <span class="text-gray-800 font-medium">{{ $category->name }}</span>
                    <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500 text-sm hover:underline">Modifier</a>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Aucune catégorie trouvée.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
