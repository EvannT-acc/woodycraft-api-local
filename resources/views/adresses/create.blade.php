<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajouter une adresse</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <form action="{{ route('adresses.store') }}" method="POST">
            @csrf
            @include('adresses.form', ['adresse' => new \App\Models\Adresse])
            <x-primary-button>Ajouter</x-primary-button>
        </form>
    </div>
</x-app-layout>
