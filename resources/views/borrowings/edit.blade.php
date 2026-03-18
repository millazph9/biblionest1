<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-xl font-bold">Modifier un Emprunt</h1>

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

        <form method="POST" action="{{ route('borrowings.update', $borrowing->id) }}">
            @csrf
            @method('PUT')

            <label>Emprunteur :</label>
            <select name="user_id" required class="w-full border rounded px-4 py-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $borrowing->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <label>Livre :</label>
            <select name="book_id" required class="w-full border rounded px-4 py-2">
                @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id', $borrowing->book_id) == $book->id ? 'selected' : '' }}>
                        {{ $book->title }}
                    </option>
                @endforeach
            </select>
            @error('book_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <button type="submit" class="bg-blue-500 text-black px-4 py-2 mt-2">Mettre à jour</button>
        </form>
    </div>
</x-app-layout>
