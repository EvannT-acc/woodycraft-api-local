<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Panier;
use Illuminate\Http\JsonResponse;

class PanierController extends Controller
{
    /**
     * GET /api/paniers
     * Retourne tous les paniers en cours
     * → Théotime
     */
    public function index()
    {
        $paniers = Panier::select('id', 'statut')
                         ->where('statut', 'en cours')
                         ->get();

        return response()->json([
            'message' => 'Liste des paniers en cours',
            'data'    => $paniers
        ]);
    }

    /**
     * POST /api/paniers
     * Créer un nouveau panier
     * → Théotime
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'statut'  => 'required|string|in:en cours,terminé'
        ]);

        $panier = Panier::create([
            'user_id' => $validated['user_id'],
            'statut'  => $validated['statut']
        ]);

        return response()->json([
            'message' => 'Panier créé avec succès',
            'data'    => $panier
        ], 201);
    }

    /**
     * GET /api/paniers/{id}
     * Détail complet d'une commande
     * → Evann
     */
    public function show(int $id): JsonResponse
    {
        $panier = Panier::with([
            'user',
            'user.adresses',
            'puzzles',
        ])->find($id);

        if (!$panier) {
            return response()->json([
                'message' => 'Commande introuvable'
            ], 404);
        }

        $articles = $panier->puzzles->map(function ($puzzle) {
            return [
                'id'            => $puzzle->id,
                'nom'           => $puzzle->nom,
                'image'         => $puzzle->image,
                'prix_unitaire' => $puzzle->prix,
                'quantite'      => $puzzle->pivot->quantite,
                'sous_total'    => round($puzzle->prix * $puzzle->pivot->quantite, 2),
            ];
        });

        $adresse = null;
        if ($panier->user && $panier->user->adresses->isNotEmpty()) {
            $a = $panier->user->adresses->first();
            $adresse = [
                'rue'         => $a->rue,
                'ville'       => $a->ville,
                'code_postal' => $a->code_postal,
                'pays'        => $a->pays,
            ];
        }

        return response()->json([
            'id'                => $panier->id,
            'statut'            => $panier->statut,
            'total'             => $panier->total,
            'mode_paiement'     => $panier->mode_paiement,
            'date_commande'     => $panier->created_at,
            'client'            => $panier->user ? [
                'id'        => $panier->user->id,
                'nom'       => $panier->user->nom,
                'email'     => $panier->user->email,
                'telephone' => $panier->user->telephone,
            ] : null,
            'adresse_livraison' => $adresse,
            'articles'          => $articles,
            'nb_articles'       => $articles->count(),
        ]);
    }
}