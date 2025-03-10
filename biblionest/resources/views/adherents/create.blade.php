<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl sm:text-2xl font-bold mb-4">➕ Ajouter un Adhérent</h1>

        <form method="POST" action="{{ route('adherents.store') }}" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nom :</label>
                <input type="text" name="firstname" required class="w-full border rounded px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Prénom :</label>
                <input type="text" name="lastname" required class="w-full border rounded px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email :</label>
                <input type="email" name="email" required class="w-full border rounded px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="phone_number" class="block text-gray-700">Téléphone :</label>
                <input type="text" name="phone_number" required class="w-full border rounded px-4 py-2">
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">Adresse :</label>
                <input type="text" name="address" required class="w-full border rounded px-4 py-2">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
        </form>
    </div>
</x-app-layout>
