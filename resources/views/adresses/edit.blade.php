<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Modifier mon adresse
        </h2>
    </x-slot>

    <div class="py-10 flex justify-center">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
            
            @if($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('adresses.update', $adresse) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', $adresse->nom) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="rue" class="block text-sm font-medium text-gray-700">Rue</label>
                    <input type="text" name="rue" id="rue" value="{{ old('rue', $adresse->rue) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="ville" class="block text-sm font-medium text-gray-700">Ville</label>
                    <input type="text" name="ville" id="ville" value="{{ old('ville', $adresse->ville) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="code_postal" class="block text-sm font-medium text-gray-700">Code Postal</label>
                    <input type="text" name="code_postal" id="code_postal" value="{{ old('code_postal', $adresse->code_postal) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div>
                    <label for="pays" class="block text-sm font-medium text-gray-700">Pays</label>
                    <input type="text" name="pays" id="pays" value="{{ old('pays', $adresse->pays) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('adresses.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
