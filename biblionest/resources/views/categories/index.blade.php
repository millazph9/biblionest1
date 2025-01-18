<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-xl font-bold">Catégories</h1>
        <a href="{{ route('categories.create') }}" class="text-blue-500">Ajouter une catégorie</a>
        <ul>
            @foreach($categories as $category)
                <li>{{ $category->name }}</li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
