<div class="space-y-4">
    <div>
        <x-input-label for="nom" :value="__('Nom de l\'adresse')" />
        <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" value="{{ old('nom', $adresse->nom) }}" required />
    </div>
    <div>
        <x-input-label for="rue" :value="__('Rue')" />
        <x-text-input id="rue" name="rue" type="text" class="mt-1 block w-full" value="{{ old('rue', $adresse->rue) }}" required />
    </div>
    <div>
        <x-input-label for="ville" :value="__('Ville')" />
        <x-text-input id="ville" name="ville" type="text" class="mt-1 block w-full" value="{{ old('ville', $adresse->ville) }}" required />
    </div>
    <div>
        <x-input-label for="code_postal" :value="__('Code postal')" />
        <x-text-input id="code_postal" name="code_postal" type="text" class="mt-1 block w-full" value="{{ old('code_postal', $adresse->code_postal) }}" required />
    </div>
    <div>
        <x-input-label for="pays" :value="__('Pays')" />
        <x-text-input id="pays" name="pays" type="text" class="mt-1 block w-full" value="{{ old('pays', $adresse->pays ?? 'France') }}" required />
    </div>
</div>
