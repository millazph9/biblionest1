<x-app-layout>
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong>Veuillez corriger les erreurs suivantes :</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
    @endif

    <div class="container mx-auto px-4">
        <h1 class="text-xl sm:text-2xl font-bold mb-4">✏️ Modifier un Adhérent</h1>
        <form method="POST" action="{{ route('adherents.update', $adherent->id) }}" class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            @csrf
            @method('PUT')
            <!-- Nom -->
            <div class="mb-4">
                <label for="firstname" class="block text-gray-700">Prénom :</label>
                <input type="text" name="firstname" id="firstname" value="{{ old('firstname', $adherent->firstname) }}" required 
                       class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300">
            </div>
            <!-- Prénom -->
            <div class="mb-4">
                <label for="lastname" class="block text-gray-700">Nom :</label>
                <input type="text" name="lastname" id="lastname" value="{{ old('lastname', $adherent->lastname) }}" required 
                       class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300">
            </div>
            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email :</label>
                <input type="email" name="email" id="email" value="{{ old('email', $adherent->email) }}" required 
                       class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300">
            </div>
            <!-- Téléphone -->
            <div class="mb-4">
                <label for="phone_number" class="block text-gray-700">Téléphone :</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $adherent->phone_number) }}" required 
                       class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300">
            </div>
            <!-- Adresse -->
            <div class="mb-4">
                <label for="address" class="block text-gray-700">Adresse :</label>
                <input type="text" name="address" id="address" value="{{ old('address', $adherent->address) }}" required 
                       class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300">
            </div>
            <!-- Bouton de mise à jour -->
            <div class="text-center">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow-md transition">
                    ✅ Mettre à jour
                </button>
            </div>
        </form>
    </div>
</x-app-layout>