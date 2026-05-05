<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Afficher un puzzle')
        </h2>
    </x-slot>

    <x-puzzles-card>
        <!-- Nom -->
        <h3 class="font-semibold text-xl text-gray-800">@lang('Nom')</h3>
        <p>{{ $puzzle->nom }}</p>

        <!-- Catégorie -->
        <h3 class="font-semibold text-xl text-gray-800 pt-2">@lang('Catégorie')</h3>
        <p>{{ $puzzle->categorie }}</p>

        <!-- Description -->
        <h3 class="font-semibold text-xl text-gray-800 pt-2">@lang('Description')</h3>
        <p>{{ $puzzle->description }}</p>

        <!-- Image -->
        <h3 class="font-semibold text-xl text-gray-800 pt-2">@lang('Image')</h3>
        @if ($puzzle->image)
            <img src="{{ $puzzle->image }}" alt="{{ $puzzle->nom }}" class="max-w-full h-auto rounded-md" />
        @else
            <p>@lang('Pas d\'image disponible')</p>
        @endif

        <!-- Prix -->
        <h3 class="font-semibold text-xl text-gray-800 pt-2">@lang('Prix')</h3>
        <p>{{ number_format($puzzle->prix, 2, ',', ' ') }} €</p>

        <!-- Date de création -->
        <h3 class="font-semibold text-xl text-gray-800 pt-2">@lang('Date de création')</h3>
        <p>{{ $puzzle->created_at->format('d/m/Y') }}</p>

        <!-- Date de dernière mise à jour (si différente de la création) -->
        @if ($puzzle->created_at != $puzzle->updated_at)
            <h3 class="font-semibold text-xl text-gray-800 pt-2">@lang('Dernière mise à jour')</h3>
            <p>{{ $puzzle->updated_at->format('d/m/Y') }}</p>
        @endif
        <x-link-button href="{{ route('puzzle.add', $puzzle->id) }}">
            Ajouter au panier
        </x-link-button>

    </x-puzzles-card>
</x-app-layout>
