<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-bold mb-4">Modifier le Livre</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('books.update', $book->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700">Titre :</label>
                <input type="text" name="title" value="{{ old('title', $book->title) }}" required class="w-full border rounded px-4 py-2">
                @error('title')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="author" class="block text-gray-700">Auteur :</label>
                <input type="text" name="author" value="{{ old('author', $book->author) }}" required class="w-full border rounded px-4 py-2">
                @error('author')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="isbn" class="block text-gray-700">ISBN :</label>
                <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" required class="w-full border rounded px-4 py-2">
                @error('isbn')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="published_year" class="block text-gray-700">Année de Publication :</label>
                <input type="number" name="published_year" value="{{ old('published_year', $book->published_year) }}" required class="w-full border rounded px-4 py-2">
                @error('published_year')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Catégorie :</label>
                <select name="category_id" required class="w-full border rounded px-4 py-2">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="copies_available" class="block text-gray-700">Copies Disponibles :</label>
                <input type="number" name="copies_available" value="{{ old('copies_available', $book->copies_available) }}" required class="w-full border rounded px-4 py-2">
                @error('copies_available')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
        </form>
    </div>
</x-app-layout>
