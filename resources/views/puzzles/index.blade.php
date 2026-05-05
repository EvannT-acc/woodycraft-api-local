<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Liste des puzzles')
        </h2>
    </x-slot>
    

    <div class="container flex justify-center mx-auto">
        
        <div class="flex flex-col">
            <div class="w-full">
                <div class="border-b border-gray-200 shadow pt-6">
                    <table>
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-2 text-xs text-gray-500">#</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Nom</th>
                                <th class="px-2 py-2 text-xs text-gray-500"></th>
                                <th class="px-2 py-2 text-xs text-gray-500"></th>
                                <th class="px-2 py-2 text-xs text-gray-500"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                        @if (session()->has('message'))
                            <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
                                {{ session('message') }}
                            </div>
                        @endif
                            @foreach ($puzzles as $puzzle)
                                <tr class="whitespace-nowrap">
                                    <td class="px-4 py-4 text-sm text-gray-500">{{ $puzzle->id }}</td>
                                    <td class="px-4 py-4">{{ $puzzle->nom }}</td>

                                    <td class="px-4 py-4">
                                        <x-link-button href="{{ route('puzzles.show', $puzzle->id) }}">
                                            @lang('Show')
                                        </x-link-button>
                                    </td>
                                    <td class="px-4 py-4">
                                        <x-link-button href="{{ route('puzzles.edit', $puzzle->id) }}">
                                            @lang('Edit')
                                        </x-link-button>
                                    </td>
                                    <td class="px-4 py-4">
                                        <x-link-button
                                            onclick="event.preventDefault(); document.getElementById('destroy{{ $puzzle->id }}').submit();">
                                            @lang('Delete')
                                        </x-link-button>
                                        <form id="destroy{{ $puzzle->id }}" action="{{ route('puzzles.destroy', $puzzle->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

