<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Liste des catégories')
        </h2>
    </x-slot>

    <div class="container flex justify-center mx-auto">
        <div class="flex flex-col">
            <div class="w-full">
                <div class="border-b border-gray-200 shadow pt-6">

                    @if (session()->has('message'))
                        <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
                            {{ session('message') }}
                        </div>
                    @endif

                    <table class="min-w-full border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-2 text-xs text-gray-500">#</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Nom / Puzzle</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Prix</th>

                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($categories as $categorie)
                                <!-- Ligne catégorie -->
                                <tr class="bg-gray-100 font-bold">
                                    <td class="px-4 py-4">{{ $categorie->id }}</td>
                                    <td class="px-4 py-4" colspan="2">{{ $categorie->nom }}</td>
                                    <td class="px-4 py-4">
                                        <x-link-button href="{{ route('categories.show', $categorie->id) }}">
                                            @lang('Show')
                                        </x-link-button>
                                    </td>
                                </tr>

                                <!-- Lignes puzzles -->
                                @foreach ($categorie->puzzles as $puzzle)
                                    <tr class="whitespace-nowrap">
                                        <td class="px-6 py-2 text-gray-500">- {{ $puzzle->id }}</td>
                                        <td class="px-6 py-2">{{ $puzzle->nom }}</td>
                                        <td class="px-6 py-2">{{ $puzzle->prix }} €</td>
                                        <td class="px-6 py-2">
                                            <x-link-button href="{{ route('puzzle.add', $puzzle->id) }}">
                                                Ajouter au panier
                                            </x-link-button>
                                        </td>
                                    </tr>
                                @endforeach

                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
