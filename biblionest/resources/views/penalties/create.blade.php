<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl font-bold mb-4">💰 Ajouter une Pénalité</h1>

        <form method="POST" action="{{ route('penalties.store') }}" class="bg-white p-6 rounded-lg shadow-md border">
            @csrf

            <!-- Sélection de l'Emprunt -->
            <label for="borrowing_id" class="block text-gray-700 font-semibold">📖 Sélectionner un Emprunt :</label>
            <select name="borrowing_id" id="borrowing_id" required class="w-full border px-3 py-2 rounded-lg mb-4">
                <option value="" disabled selected>📌 Sélectionner un emprunt</option>
                @forelse($borrowings as $borrowing)
                    <option value="{{ $borrowing->id }}">
                        {{ $borrowing->book->title }} - {{ $borrowing->user->name }}
                    </option>
                @empty
                    <option disabled>⚠️ Aucun emprunt disponible</option>
                @endforelse
            </select>

            <!-- Montant -->
            <label for="amount" class="block text-gray-700 font-semibold">💰 Montant :</label>
            <input type="number" name="amount" required class="w-full border px-3 py-2 rounded-lg mb-4" placeholder="Ex: 5">

            <!-- Bouton de validation -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md w-full">
                ✅ Enregistrer la Pénalité
            </button>
        </form>
    </div>
</x-app-layout>
