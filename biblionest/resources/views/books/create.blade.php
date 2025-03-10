<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-bold mb-4">Ajouter un Livre</h1>

        <form method="POST" action="{{ route('books.store') }}">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Titre :</label>
                <input type="text" name="title" required class="w-full border rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label for="author" class="block text-gray-700">Auteur :</label>
                <input type="text" name="author" required class="w-full border rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label for="isbn" class="block text-gray-700">ISBN :</label>
                <input type="text" name="isbn" required class="w-full border rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label for="published_year" class="block text-gray-700">Année de Publication :</label>
                <input type="number" name="published_year" required class="w-full border rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Catégorie :</label>
                <select name="category_id" required class="w-full border rounded px-4 py-2">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="copies_available" class="block text-gray-700">Copies Disponibles :</label>
                <input type="number" name="copies_available" required class="w-full border rounded px-4 py-2">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
        </form>
    </div>
</x-app-layout>
