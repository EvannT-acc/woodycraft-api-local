<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Détails de l'adresse</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto bg-white p-4 rounded shadow">
        <p><strong>Nom :</strong> {{ $adresse->nom }}</p>
        <p><strong>Rue :</strong> {{ $adresse->rue }}</p>
        <p><strong>Ville :</strong> {{ $adresse->ville }}</p>
        <p><strong>Code postal :</strong> {{ $adresse->code_postal }}</p>
        <p><strong>Pays :</strong> {{ $adresse->pays }}</p>
        <x-link-button href="{{ route('adresses.edit', $adresse->id) }}">Modifier</x-link-button>
    </div>
</x-app-layout>
