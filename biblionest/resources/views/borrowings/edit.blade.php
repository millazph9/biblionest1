<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-xl font-bold">Modifier un Emprunt</h1>
        <form method="POST" action="{{ route('borrowings.update', $borrowing->id) }}">
            @csrf
            @method('PUT')
            <label>Emprunteur :</label>
            <select name="user_id" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $borrowing->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>

            <label>Livre :</label>
            <select name="book_id" required>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ $borrowing->book_id == $book->id ? 'selected' : '' }}>
                        {{ $book->title }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-500 text-black px-4 py-2 mt-2">Mettre à jour</button>
        </form>
    </div>
</x-app-layout>
