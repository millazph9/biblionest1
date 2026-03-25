<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl sm:text-2xl font-bold text-center mb-4">📖 Liste des Emprunts</h1>

        <!-- Bouton Ajouter un Emprunt -->
        <div class="w-full flex justify-center sm:justify-start">
            <a href="{{ route('borrowings.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition hover:scale-105 flex items-center gap-2 text-sm sm:text-base">
                ➕ Ajouter un Emprunt
            </a>
        </div>

        <!-- Filtres -->
        <form method="GET" action="{{ route('borrowings.index') }}" class="mt-4 flex flex-col sm:flex-row gap-2 sm:gap-4 w-full sm:items-center">
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 w-full sm:w-auto">
                <select name="adherent_id" class="border px-3 py-2 rounded-lg w-full sm:w-auto">
                    <option value="">Tous les emprunteurs</option>
                    @foreach($adherents as $adherent)
                        <option value="{{ $adherent->id }}" value = "{{ request('adherent_id') == $adherent->id ? 'selected' : '' }}">
                            {{ $adherent->firstname }} {{ $adherent->lastname }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="border px-3 py-2 rounded-lg w-full sm:w-auto">
                    <option value="">Tous les statuts</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>📖 En cours</option>
                    <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>❌ En retard</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>✅ Rendu</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition sm:ml-2">
                🔎 Filtrer
            </button>
        </form>

        <!-- Affichage du tableau sur Desktop -->
        <div class="hidden sm:block overflow-x-auto mt-4">
            @if($borrowings->isEmpty())
                <p class="text-center text-gray-500 py-4">Aucun résultat trouvé.</p>
            @else
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm sm:text-base">
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
                            <tr class="hover:bg-gray-50 text-sm sm:text-base">
                                <td class="py-2 px-4 border">
                                    {{ optional($borrowing->book)->title ?? '📌 Livre supprimé' }}
                                </td>
                                <td class="py-2 px-4 border">
                                    {{ optional($borrowing->adherent)->firstname ?? 'Adhérent inconnu' }} {{ optional($borrowing->adherent)->lastname ?? '' }}
                                </td>
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
                                <td class="py-2 px-4 border text-center">
                                    @if (!$borrowing->returned_at)
                                        <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm sm:text-base">
                                                Retourner
                                            </button>
                                        </form>
                                    @else
                                        ✔️
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Version Mobile : Affichage en Cartes -->
        <div class="sm:hidden flex flex-col gap-4 mt-4">
            @if($borrowings->isEmpty())
                <p class="text-center text-gray-500">Aucun résultat trouvé.</p>
            @else
                @foreach ($borrowings as $borrowing)
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                        <p class="font-bold text-lg">{{ optional($borrowing->book)->title ?? '📌 Livre supprimé' }}</p>
                        <p class="text-sm text-gray-600">👤 Emprunté par : 
                            <span class="font-medium">
                                {{ optional($borrowing->adherent)->firstname ?? 'Adhérent inconnu' }} {{ optional($borrowing->adherent)->lastname ?? '' }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-600">📅 Date d'emprunt : 
                            <span class="font-medium">{{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d/m/Y') }}</span>
                        </p>
                        <p class="text-sm text-gray-600">🔄 Retour prévu : 
                            <span class="font-medium">{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</span>
                        </p>
                        <p class="text-sm text-gray-600">
                            📌 Statut : 
                            @if ($borrowing->returned_at)
                                ✅ Rendu le {{ \Carbon\Carbon::parse($borrowing->returned_at)->format('d/m/Y') }}
                            @elseif (\Carbon\Carbon::parse($borrowing->due_date)->isPast())
                                ❌ En retard
                            @else
                                📖 En cours
                            @endif
                        </p>
                        @if (!$borrowing->returned_at)
                            <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-lg w-full">
                                    Retourner
                                </button>
                            </form>
                        @else
                            <p class="text-green-500 font-bold mt-2 text-center">✔️ Déjà retourné</p>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
