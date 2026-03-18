<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl sm:text-2xl font-bold mb-4">👤 Détails de l'Adhérent</h1>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p><strong>Prénom :</strong> {{ $adherent->firstname }}</p>
            <p><strong>Nom :</strong> {{ $adherent->lastname }}</p>
            <p><strong>Email :</strong> {{ $adherent->email }}</p>
            <p><strong>Téléphone :</strong> {{ $adherent->phone_number }}</p>
            <p><strong>Adresse :</strong> {{ $adherent->address }}</p>
        </div>
        <h2 class="text-lg sm:text-xl font-bold mt-6">📚 Emprunts de l'adhérent</h2>
        @if($adherent->borrowings->isEmpty())
            <p class="text-gray-500 mt-2">Aucun emprunt trouvé.</p>
        @else
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm sm:text-base">
                            <th class="py-2 px-4 border">Livre</th>
                            <th class="py-2 px-4 border">Date d'emprunt</th>
                            <th class="py-2 px-4 border">Retour prévu</th>
                            <th class="py-2 px-4 border">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adherent->borrowings as $borrowing)
                            <tr class="hover:bg-gray-50 text-sm sm:text-base">
                                <td class="py-2 px-4 border">{{ $borrowing->book?->title ?? 'Livre inconnu' }}</td>
                                <td class="py-2 px-4 border">{{ optional($borrowing->borrowed_at)->format('d/m/Y') }}</td>
                                <td class="py-2 px-4 border">{{ optional($borrowing->due_date)->format('d/m/Y') }}</td>
                                <td class="py-2 px-4 border">
                                    @if ($borrowing->returned_at)
                                        ✅ Rendu le {{ optional($borrowing->returned_at)->format('d/m/Y') }}
                                    @elseif (optional($borrowing->due_date)->isPast())
                                        ❌ En retard
                                    @else
                                        📖 En cours
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <!-- Bouton de téléchargement en PDF -->
        <div class="mt-4">
            <a href="{{ route('adherents.export.borrowings', $adherent->id) }}" 
               class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition">
                📄 Télécharger la liste des emprunts
            </a>
        </div>
    </div>
</x-app-layout>