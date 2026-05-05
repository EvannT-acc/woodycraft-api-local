<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">Mes adresses</h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-6">

            @if(session('message'))
                <div class="mb-4 text-green-600 text-center font-semibold">
                    {{ session('message') }}
                </div>
            @endif

            <div class="flex justify-end mb-4">
                <a href="{{ route('adresses.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    + Ajouter une adresse
                </a>
            </div>

            <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-600 font-semibold">Nom</th>
                        <th class="px-4 py-3 text-left text-gray-600 font-semibold">Adresse</th>
                        <th class="px-4 py-3 text-center text-gray-600 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($adresses as $adresse)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $adresse->nom }}</td>
                            <td class="px-4 py-3">
                                {{ $adresse->rue }}, {{ $adresse->ville }},
                                {{ $adresse->code_postal }}, {{ $adresse->pays }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                <td class="px-4 py-4">
                                        <x-link-button href="{{ route('adresses.edit', $adresse->id) }}">
                                            @lang('Edit')
                                        </x-link-button>
                                    </td>
                                    <a href="{{ route('adresses.edit', $adresse) }}" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Modifier</a>

                                    <form action="{{ route('adresses.destroy', $adresse) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette adresse ?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-primary-button type="submit" class="bg-red-500 hover:bg-red-600 text-white">Supprimer</x-primary-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-gray-500 text-center">Aucune adresse trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
