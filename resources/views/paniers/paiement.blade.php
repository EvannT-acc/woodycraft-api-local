<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Mode de paiement')
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-8 bg-white shadow p-6 rounded-lg">
        <form action="{{ route('paiement.store') }}" method="POST">
            @csrf

            <p class="mb-4 text-gray-700">Veuillez choisir votre mode de paiement :</p>

            <div class="space-y-3 mb-6">
                <label class="flex items-center space-x-3">
                    <input type="radio" name="mode_paiement" value="paypal" class="h-4 w-4 text-blue-600">
                    <span>Paiement par PayPal</span>
                </label>

                <label class="flex items-center space-x-3">
                    <input type="radio" name="mode_paiement" value="cheque" class="h-4 w-4 text-blue-600">
                    <span>Paiement par chèque</span>
                </label>
            </div>

            <button type="submit" 
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Valider mon paiement
            </button>
        </form>
    </div>
</x-app-layout>
