<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-xl font-bold">Modifier une Pénalité</h1>

        <form method="POST" action="{{ route('penalties.update', $penalty->id) }}">
            @csrf
            @method('PUT')

            <label for="amount">Montant :</label>
            <input type="number" name="amount" value="{{ $penalty->amount }}" required>

            <label for="paid">Statut :</label>
            <select name="paid">
                <option value="0" {{ !$penalty->paid ? 'selected' : '' }}>Non payé</option>
                <option value="1" {{ $penalty->paid ? 'selected' : '' }}>Payé</option>
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2">Mettre à jour</button>
        </form>
    </div>
</x-app-layout>
