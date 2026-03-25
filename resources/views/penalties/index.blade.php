<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl sm:text-2xl font-bold mb-4 text-center">💰 Liste des Pénalités</h1>

        <!-- Filtres -->
        <form method="GET" action="{{ route('penalties.index') }}" class="mb-4 flex flex-col sm:flex-row items-center justify-center gap-2">
            <select name="adherent_id" class="border px-3 py-2 rounded-lg w-full sm:w-1/4">
                <option value="">Tous les emprunteurs</option>
                @foreach($adherents as $adherent)
                    <option value="{{ $adherent->id }}" value="{{ request('adherent_id') == $adherent->id ? 'selected' : '' }}">
                        {{ $adherent->lastname }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="border px-3 py-2 rounded-lg w-full sm:w-1/4">
                <option value="">Tous les statuts</option>
                <option value="paid {{ request('status') == 'paid' ? 'selected' : '' }}">✅ Payée</option>
                <option value="unpaid {{ request('status') == 'unpaid' ? 'selected' : '' }}">❌ Non payée</option>
            </select>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md">
                🔍 Filtrer
            </button>
        </form>

        <!-- Affichage Desktop -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mt-4">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm sm:text-base">
                        <th class="py-2 px-4 border">Livre</th>
                        <th class="py-2 px-4 border">Adherent</th>
                        <th class="py-2 px-4 border">Montant</th>
                        <th class="py-2 px-4 border">Statut</th>
                        <th class="py-2 px-4 border">Origine</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penalties as $penalty)
                        <tr class="hover:bg-gray-50 text-sm sm:text-base">
                            <td class="py-2 px-4 border">{{ $penalty->borrowing->book->title }}</td>
                            <td class="py-2 px-4 border">{{ $penalty->borrowing->adherent->lastname }}</td>
                            <td class="py-2 px-4 border">{{ $penalty->amount }} €</td>
                            <td class="py-2 px-4 border">
                                @if($penalty->paid)
                                    ✅ Payé le {{ \Carbon\Carbon::parse($penalty->paid_at)->format('d/m/Y') }}
                                @else
                                    ❌ Non payé
                                @endif
                            </td>
                            <td class="py-2 px-4 border">
                                {{ $penalty->auto_generated ? 'Automatique' : '---' }}
                            </td>
                            <td class="py-2 px-4 border text-center">
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

        <!-- Pagination -->
        <div class="mt-4">
            {{ $penalties->links() }}
        </div>

        <!-- Affichage Mobile -->
        <div class="sm:hidden flex flex-col gap-4 mt-4">
            @foreach ($penalties as $penalty)
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                    <p class="font-bold text-lg">{{ $penalty->borrowing->book->title }}</p>
                    <p class="text-sm text-gray-600">👤 Emprunteur : <span class="font-medium">{{ $penalty->borrowing->adherent->lastname }}</span></p>
                    <p class="text-sm text-gray-600">💰 Montant : <span class="font-medium">{{ $penalty->amount }} €</span></p>
                    <p class="text-sm text-gray-600">📌 Statut :
                        @if($penalty->paid)
                            ✅ Payé le {{ \Carbon\Carbon::parse($penalty->paid_at)->format('d/m/Y') }}
                        @else
                            ❌ Non payé
                        @endif
                    </p>
                    <p class="text-sm text-gray-600">⚙️ Origine :
                        <span class="font-medium">{{ $penalty->auto_generated ? 'Automatique' : '---' }}</span>
                    </p>
                    <div class="mt-2 flex flex-col gap-1">
                        @if(!$penalty->paid)
                            <form action="{{ route('penalties.pay', $penalty->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm mt-1 w-full">
                                    Payer
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
