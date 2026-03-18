<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-bold mb-4">Modifier la Catégorie</h1>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('categories.update', $category->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nom de la catégorie :</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full border rounded px-4 py-2">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
        </form>
    </div>
</x-app-layout>

