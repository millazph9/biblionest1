<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl sm:text-2xl font-bold mb-4 text-center">👤 Liste des Adhérents</h1>

        <!-- Bouton Ajouter un Adhérent -->
        <div class="w-full flex justify-center sm:justify-start mb-4">
            <a href="{{ route('adherents.create') }}" 
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105 flex items-center gap-2 text-sm sm:text-base">
                ➕ Ajouter un adhérent
            </a>
        </div>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('adherents.index') }}" class="mb-4 flex flex-col sm:flex-row gap-2 sm:gap-4 w-full sm:w-auto">
            <input type="text" name="search" placeholder="Rechercher un adhérent..." value="{{ request('search') }}"
                   class="border px-4 py-2 rounded-lg w-full sm:w-72 focus:ring focus:ring-blue-300">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition">
                🔍 Rechercher
            </button>
        </form>

        <!-- Tableau des adhérents -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm sm:text-base">
                        <th class="py-2 px-4 border">Prénom</th>
                        <th class="py-2 px-4 border">Nom</th>
                        <th class="py-2 px-4 border">Email</th>
                        <th class="py-2 px-4 border">Téléphone</th>
                        <th class="py-2 px-4 border">Adresse</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($adherents as $adherent)
                        <tr class="hover:bg-gray-50 text-sm sm:text-base">
                            <td class="py-2 px-4 border">{{ $adherent->firstname }}</td>
                            <td class="py-2 px-4 border">{{ $adherent->lastname }}</td>
                            <td class="py-2 px-4 border">{{ $adherent->email }}</td>
                            <td class="py-2 px-4 border">{{ $adherent->phone_number }}</td>
                            <td class="py-2 px-4 border">{{ $adherent->address }}</td>
                            <td class="py-2 px-4 border flex gap-2">
                                <a href="{{ route('adherents.edit', $adherent->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                                <form action="{{ route('adherents.destroy', $adherent->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                                </form>
                                <a href="{{ route('adherents.show', $adherent->id) }}" class="text-blue-500 hover:underline">
                                    🔍 Voir détails
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">Aucun adhérent trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $adherents->links() }}
        </div>
    </div>
</x-app-layout>
