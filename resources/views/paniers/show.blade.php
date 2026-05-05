<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Afficher un puzzle')
        </h2>
    </x-slot>

    <x-puzzles-card>
        <!-- total -->
        <h3 class="font-semibold text-xl text-gray-800">@lang('total')</h3>
        <p>{{ $panier->total }}</p>

        <!-- Date de création -->
        <h3 class="font-semibold text-xl text-gray-800 pt-2">@lang('Date de création')</h3>
        <p>{{ $puzzle->created_at->format('d/m/Y') }}</p>

        <!-- Date de dernière mise à jour (si différente de la création) -->
        @if ($puzzle->created_at != $puzzle->updated_at)
            <h3 class="font-semibold text-xl text-gray-800 pt-2">@lang('Dernière mise à jour')</h3>
            <p>{{ $puzzle->updated_at->format('d/m/Y') }}</p>
        @endif
    </x-puzzles-card>
</x-app-layout>
