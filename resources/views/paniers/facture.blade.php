<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $panier->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f4f4f4; }
        .total { text-align: right; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facture - Commande #{{ $panier->id }}</h1>
        <p>Date : {{ now()->format('d/m/Y') }}</p>
    </div>

    <h3>Informations client :</h3>
    <p>{{ $user->name }}<br>
       {{ $adresse->rue ?? 'Adresse non définie' }}<br>
       {{ $adresse->code_postal ?? '' }} {{ $adresse->ville ?? '' }}<br>
       {{ $adresse->pays ?? '' }}</p>

    <h3>Détails de la commande :</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($panier->puzzles as $puzzle)
                <tr>
                    <td>{{ $puzzle->nom }}</td>
                    <td>{{ $puzzle->pivot->quantite }}</td>
                    <td>{{ number_format($puzzle->prix, 2, ',', ' ') }} €</td>
                    <td>{{ number_format($puzzle->prix * $puzzle->pivot->quantite, 2, ',', ' ') }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Montant total : 
        {{ number_format($panier->puzzles->sum(fn($p) => $p->prix * $p->pivot->quantite), 2, ',', ' ') }} €
    </p>

    <hr>

    <p><strong>Mode de paiement :</strong> {{ ucfirst($panier->mode_paiement) }}</p>

    @if ($panier->mode_paiement === 'cheque')
        <p>
            Merci d’envoyer votre chèque à l’adresse suivante :  
            <br><strong>MonSite - Service Comptabilité</strong>  
            <br>123 Rue du Commerce, 75000 Paris  
        </p>
    @endif

</body>
</html>
