<x-app-layout>
    
    <div class="container mx-auto">
        <h1 class="text-xl font-bold">📖 Liste des Emprunts</h1>
        <a href="{{ route('borrowings.create') }}" 
        class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded-lg shadow-md transition transform hover:scale-200 flex items-center gap-2">
            ➕ Ajouter un Emprunt
        </a>
        <form method="GET" action="{{ route('borrowings.index') }}" class="mb-4 mt-4 flex gap-4">
            <select name="user_id" class="border px-4 py-2 rounded">
                <option value="">Tous les emprunteurs</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="border px-4 py-2 rounded">
                <option value="">Tous les statuts</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>📖 En cours</option>
                <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>❌ En retard</option>
                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>✅ Rendu</option>
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filtrer</button>
        </form>

        <table class="min-w-full bg-white border border-gray-200 mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border">Livre</th>
                    <th class="py-2 px-4 border">Emprunté par</th>
                    <th class="py-2 px-4 border">Date d'emprunt</th>
                    <th class="py-2 px-4 border">Retour prévu</th>
                    <th class="py-2 px-4 border">Statut</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowings as $borrowing)
                    <tr>
                    <td class="py-2 px-4 border">
                        {{ $borrowing->book ? $borrowing->book->title : '📌 Livre supprimé' }}
                    </td>
                        <td class="py-2 px-4 border">{{ $borrowing->user->name }}</td>
                        <td class="py-2 px-4 border">
                            {{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d/m/Y') }}
                        </td>
                        <td class="py-2 px-4 border">
                            {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                        </td>
                        <td class="py-2 px-4 border">
                            @if ($borrowing->returned_at)
                                ✅ Rendu le {{ \Carbon\Carbon::parse($borrowing->returned_at)->format('d/m/Y') }}
                            @elseif (\Carbon\Carbon::parse($borrowing->due_date)->isPast())
                                ❌ En retard
                            @else
                                📖 En cours
                            @endif
                        </td>
                        <td class="py-2 px-4 border">
                            @if (!$borrowing->returned_at)
                                <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                                        Retourner
                                    </button>
                                </form>
                            @else
                                ✔️
                            @endif
                        </td>
                        <td class="py-2 px-4 border">
                            <a href="{{ route('borrowings.edit', $borrowing->id) }}" class="text-blue-500">Modifier</a>
                            <form action="{{ route('borrowings.destroy', $borrowing->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Supprimer</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
