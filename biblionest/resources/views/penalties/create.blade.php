<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-xl font-bold">Ajouter une Pénalité</h1>

        <form method="POST" action="{{ route('penalties.store') }}">
            @csrf
            <label for="borrowing_id">Emprunt :</label>
            <select name="borrowing_id" required>
                @foreach($borrowings as $borrowing)
                    <option value="{{ $borrowing->id }}">
                        {{ $borrowing->book->title }} - {{ $borrowing->user->name }}
                    </option>
                @endforeach
            </select>

            <label for="amount">Montant :</label>
            <input type="number" name="amount" required>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2">Enregistrer</button>
        </form>
    </div>
</x-app-layout>
