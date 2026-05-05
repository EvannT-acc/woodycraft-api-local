<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a puzzle') }}
        </h2>
    </x-slot>

    <x-puzzles-card>
        <!-- Message de réussite -->
        @if (session()->has('message'))
            <div class="mt-3 mb-4 list-disc list-inside text-sm text-green-600">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('puzzles.store') }}" method="POST">
            @csrf

            <!-- Nom -->
            <div>
                <x-input-label for="nom" :value="__('Name')" />
                <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus />
                
                <x-input-label for="categorie_id" :value="__('categorie_id')" />
                <x-text-input id="categorie_id" class="block mt-1 w-full" type="text" name="categorie_id" :value="old('categorie_id')" required autofocus />
                
                <x-input-label for="description" :value="__('description')" />
                <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autofocus />
                
                <x-input-label for="image" :value="__('image')" />
                <x-text-input id="image" class="block mt-1 w-full" type="text" name="image" :value="old('image')" required autofocus />
                
                <x-input-label for="prix" :value="__('prix')" />
                <x-text-input id="prix" class="block mt-1 w-full" type="number" name="prix" :value="old('prix')" step="0.01" required autofocus />
                <x-input-error :messages="$errors->get('prix')" class="mt-2" />

                <x-input-label for="stock" :value="__('stock')" />
                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock')" step="1" required autofocus />
                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4" >
                <x-primary-button class="ml-3">
                    {{ __('Send') }}
                </x-primary-button>
            </div>
        </form>
    </x-puzzles-card>
</x-app-layout>