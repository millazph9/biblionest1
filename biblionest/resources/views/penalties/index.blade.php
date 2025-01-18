<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-xl font-bold">💰 Liste des Pénalités</h1>
        <a href="{{ route('penalties.create') }}" 
        class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-2 py-2 rounded-lg shadow-md transition transform hover:scale-200 flex items-center gap-2">
            ➕ Ajouter une pénalitée
        </a>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <form method="GET" action="{{ route('penalties.index') }}" class="mb-4 mt-4 flex gap-4">
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
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>✅ Payée</option>
                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>❌ Non payée</option>
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filtrer</button>
        </form>

        <table class="min-w-full bg-white border border-gray-200 mt-4">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border">Livre</th>
                    <th class="py-2 px-4 border">Utilisateur</th>
                    <th class="py-2 px-4 border">Montant</th>
                    <th class="py-2 px-4 border">Statut</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penalties as $penalty)
                    <tr>
                        <td class="py-2 px-4 border">{{ $penalty->borrowing->book->title }}</td>
                        <td class="py-2 px-4 border">{{ $penalty->borrowing->user->name }}</td>
                        <td class="py-2 px-4 border">{{ $penalty->amount }} €</td>
                        <td class="py-2 px-4 border">
                            @if($penalty->paid)
                                ✅ Payé le {{ \Carbon\Carbon::parse($penalty->paid_at)->format('d/m/Y') }}
                            @else
                                ❌ Non payé
                            @endif
                        </td>
                        <td class="py-2 px-4 border">
                            <a href="{{ route('penalties.edit', $penalty->id) }}" class="text-blue-500">Modifier</a>
                            <form action="{{ route('penalties.destroy', $penalty->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Supprimer</button>
                            </form>
                            @if(!$penalty->paid)
                                <form action="{{ route('penalties.pay', $penalty->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2">Payer</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
