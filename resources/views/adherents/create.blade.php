<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-xl sm:text-2xl font-bold mb-4">➕ Ajouter un Adhérent</h1>
        
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

        <form method="POST" action="{{ route('adherents.store') }}" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="firstname" class="block text-gray-700">Nom :</label>
                <input type="text" name="firstname" value="{{ old('firstname') }}" required class="w-full border rounded px-4 py-2">
                @error('firstname')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="lastname" class="block text-gray-700">Prénom :</label>
                <input type="text" name="lastname" value="{{ old('lastname') }}" required class="w-full border rounded px-4 py-2">
                @error('lastname')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email :</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-4 py-2">
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="phone_number" class="block text-gray-700">Téléphone :</label>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" required pattern="^(\+33|0)[1-9]\d{8}$" class="w-full border rounded px-4 py-2">
                @error('phone_number')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700">Adresse :</label>
                <input type="text" name="address" value="{{ old('address') }}" required class="w-full border rounded px-4 py-2">
                @error('address')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
        </form>
    </div>
</x-app-layout>
