<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-bold mb-4">Ajouter un Livre</h1>

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

        <form method="POST" action="{{ route('books.store') }}">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Titre :</label>
                <input type="text" name="title" value="{{ old('title') }}" required class="w-full border rounded px-4 py-2">
                @error('title')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="author" class="block text-gray-700">Auteur :</label>
                <input type="text" name="author" value="{{ old('author') }}" required class="w-full border rounded px-4 py-2">
                @error('author')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="isbn" class="block text-gray-700">ISBN :</label>
                <input type="text" name="isbn" id="isbn" value="{{ old('isbn', '978-' . rand(1000000000, 9999999999)) }}" required class="w-full border rounded px-4 py-2" readonly>
                @error('isbn')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="published_year" class="block text-gray-700">Année de Publication :</label>
                <input type="number" name="published_year" value="{{ old('published_year') }}" required class="w-full border rounded px-4 py-2">
                @error('published_year')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Catégorie :</label>
                <select name="category_id" required class="w-full border rounded px-4 py-2">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="edition" class="block text-gray-700">Édition :</label>
                <input type="text" name="edition" value="{{ old('edition', $book->edition ?? '') }}" class="w-full border rounded px-4 py-2">
                @error('edition')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="copies_available" class="block text-gray-700">Copies Disponibles :</label>
                <input type="number" name="copies_available" value="{{ old('copies_available') }}" required class="w-full border rounded px-4 py-2">
                @error('copies_available')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("isbn").value = "978-" + Math.floor(1000000000 + Math.random() * 9000000000);
        });
    </script>
</x-app-layout>
