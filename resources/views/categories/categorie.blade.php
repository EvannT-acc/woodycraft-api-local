<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Produits dans la catégorie : {{ $categorie->nom }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if ($categorie->puzzles->isEmpty())
            <p class="text-gray-500">Aucun produit dans cette catégorie.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($categorie->puzzles as $puzzle)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <!-- Image du puzzle (si tu as un champ image) -->
                        @if($puzzle->image)
                            <img src="{{ asset('storage/' . $puzzle->image) }}" alt="{{ $puzzle->nom }}" class="w-full h-48 object-cover">
                        @endif

                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2">{{ $puzzle->nom }}</h3>
                            <p class="text-gray-600 mb-2">{{ $puzzle->description ?? 'Pas de description.' }}</p>
                            <p class="font-semibold mb-2">Prix : {{ $puzzle->prix }} €</p>

                            <!-- Bouton ajouter au panier -->
                            <x-link-button href="{{ route('puzzle.add', $puzzle->id) }}">
                                Ajouter au panier
                            </x-link-button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
