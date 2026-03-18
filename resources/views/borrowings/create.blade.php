<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">📖 Enregistrer un Emprunt</h1>

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

        <!-- Formulaire d'emprunt -->
        <form method="POST" action="{{ route('borrowings.store') }}" class="space-y-4">
            @csrf

            <!-- Sélection de l'utilisateur -->
            <div>
                <label for="user_id" class="block text-lg font-medium text-gray-700">Emprunteur :</label>
                <select name="adherent_id" id="user_id" required class="w-full border rounded px-4 py-2">
                    <option value="">Sélectionner un utilisateur</option>
                    @foreach($adherents as $adherent)
                        <option value="{{ $adherent->id }}" {{ old('adherent_id') == $adherent->id ? 'selected' : '' }}>
                            {{ $adherent->firstname }} {{ $adherent->lastname }}
                        </option>
                    @endforeach
                </select>
                @error('adherent_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sélection du livre -->
            <div>
                <label for="book_id" class="block text-lg font-medium text-gray-700">Livre :</label>
                <select name="book_id" id="book_id" required class="w-full border rounded px-4 py-2">
                    <option value="">Sélectionner un livre</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }} - {{ $book->copies_available }} copies dispo
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date d'emprunt (readonly) -->
            <div>
                <label for="borrowed_at" class="block text-lg font-medium text-gray-700">Date d'emprunt :</label>
                <input type="text" name="borrowed_at" value="{{ old('borrowed_at', now()->format('Y-m-d')) }}" readonly class="w-full border rounded px-4 py-2 bg-gray-100">
            </div>

            <!-- Date de retour prévue (readonly) -->
            <div>
                <label for="due_date" class="block text-lg font-medium text-gray-700">Retour prévu :</label>
                <input type="text" name="due_date" value="{{ old('due_date', now()->addDays(14)->format('Y-m-d')) }}" readonly class="w-full border rounded px-4 py-2 bg-gray-100">
            </div>

            <!-- Bouton d'enregistrement -->
            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded">
                    Enregistrer l'emprunt
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
