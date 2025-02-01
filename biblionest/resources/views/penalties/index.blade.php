<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl sm:text-2xl font-bold text-center mb-4">💰 Liste des Pénalités</h1>

        <!-- Bouton Ajouter une Pénalité (centré sur mobile) -->
        <div class="w-full flex justify-center sm:justify-start">
            <a href="{{ route('penalties.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105 flex items-center gap-2 text-sm sm:text-base">
                ➕ Ajouter une pénalité
            </a>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mt-4 rounded text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtres -->
        <form method="GET" action="{{ route('penalties.index') }}" class="mt-4 flex flex-col sm:flex-row gap-2 sm:gap-4 w-full sm:items-center">
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 w-full sm:w-auto">
                <select name="user_id" class="border px-3 py-2 rounded-lg w-full sm:w-auto">
                    <option value="">Tous les emprunteurs</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="border px-3 py-2 rounded-lg w-full sm:w-auto">
                    <option value="">Tous les statuts</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>✅ Payée</option>
                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>❌ Non payée</option>
                </select>
            </div>

            <!-- Bouton Filtrer bien aligné avec les sélections -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition sm:ml-2">
                🔎 Filtrer
            </button>
        </form>

        <!-- Affichage conditionnel : Table sur Desktop / Cartes sur Mobile -->
        <div class="hidden sm:block overflow-x-auto mt-4">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm sm:text-base">
                        <th class="py-2 px-4 border">Livre</th>
                        <th class="py-2 px-4 border">Utilisateur</th>
                        <th class="py-2 px-4 border">Montant</th>
                        <th class="py-2 px-4 border">Statut</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penalties as $penalty)
                        <tr class="hover:bg-gray-50 text-sm sm:text-base">
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
                            <td class="py-2 px-4 border text-center">
                                <a href="{{ route('penalties.edit', $penalty->id) }}" class="text-blue-500">Modifier</a>
                                <form action="{{ route('penalties.destroy', $penalty->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Supprimer</button>
                                </form>
                                @if(!$penalty->paid)
                                    <form action="{{ route('penalties.pay', $penalty->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm sm:text-base w-full">
                                            Payer
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Version Mobile : Affichage en Cartes -->
        <div class="sm:hidden flex flex-col gap-4 mt-4">
            @foreach ($penalties as $penalty)
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                    <p class="font-bold text-lg">{{ $penalty->borrowing->book->title }}</p>
                    <p class="text-sm text-gray-600">👤 Emprunteur : <span class="font-medium">{{ $penalty->borrowing->user->name }}</span></p>
                    <p class="text-sm text-gray-600">💰 Montant : <span class="font-medium">{{ $penalty->amount }} €</span></p>
                    <p class="text-sm text-gray-600">
                        📌 Statut : 
                        @if($penalty->paid)
                            ✅ Payé le {{ \Carbon\Carbon::parse($penalty->paid_at)->format('d/m/Y') }}
                        @else
                            ❌ Non payé
                        @endif
                    </p>
                    @if(!$penalty->paid)
                        <form action="{{ route('penalties.pay', $penalty->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-lg w-full">
                                Payer
                            </button>
                        </form>
                    @else
                        <p class="text-green-500 font-bold mt-2 text-center">✔️ Déjà payé</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
