<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Panier')
        </h2>
    </x-slot>

    <div class="container flex justify-center mx-auto">
        <div class="flex flex-col">
            <div class="bg-gray-100 p-4 rounded shadow w-1/2">
                <h3 class="font-semibold mb-2">Adresse de livraison :</h3>
                @if ($adresse)
                    <p>{{ $adresse->nom }},{{ $adresse->rue }},{{ $adresse->ville }}, {{ $adresse->code_postal }},{{ $adresse->pays }}</p>
                @else
                    <p class="text-gray-500 italic">Aucune adresse enregistrée pour le moment.</p>
                @endif
            </div>
            <div class="w-full">
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('adresses.store') }}" 
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        @lang('Ajouter / Modifier l’adresse de livraison')
                    </a>
                </div>
            </div>


                    <table>
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-2 text-xs text-gray-500">#</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Nom</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Prix</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Quentité</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Total</th>
                                <th class="px-2 py-2 text-xs text-gray-500">Option</th>

                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @php $total = 0; @endphp
                            @foreach ($puzzles as $puzzle)
                                @php
                                    $sousTotal = $puzzle->prix * $puzzle->pivot->quantite;
                                    $total += $sousTotal;
                                @endphp
                                <tr class="whitespace-nowrap">
                                    <td class="px-4 py-4 text-sm text-gray-500">{{ $puzzle->id }}</td>
                                    <td class="px-4 py-4">{{ $puzzle->nom }}</td> {{-- ou total si tu as un champ total par puzzle --}}
                                    <td class="px-4 py-4">{{ $puzzle->prix }} €</td> {{-- ou total si tu as un champ total par puzzle --}}
                                    <td class="px-4 py-4">
                                        <form action="{{ route('paniers.update', $puzzle->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="decrease" class="px-2">-</button>
                                        </form>

                                        {{ $puzzle->pivot->quantite }}

                                        <form action="{{ route('paniers.update', $puzzle->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="increase" class="px-2">+</button>
                                        </form>

                                    </td>
                                    <td class="px-4 py-4">{{ $sousTotal }} €</td>
                                    </td>
                                    <td>
                                        <form action="{{ route('paniers.destroy', $puzzle->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                                @lang('X')
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-100">
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-right font-bold">Total :</td>
                                <td colspan="2" class="px-4 py-4 font-bold">{{ $total }} €</td>
                            </tr>
                            <tr>
                                
                                <td colspan="6" class="px-4 py-4 text-right">
                                    @if ($adresse)
                                        <a href="{{ route('paniers.paiement') }}" 
                                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                                            Commander
                                        </a>
                                    @else
                                        <p class="text-red-600 font-semibold">
                                            ⚠️ Vous devez ajouter une adresse avant de pouvoir passer commande.
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        </tfoot>

                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
