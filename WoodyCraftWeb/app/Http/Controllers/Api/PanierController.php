<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Panier;
<<<<<<< HEAD
use Illuminate\Http\JsonResponse;
=======
>>>>>>> 8b084609477424c13c6d336d0cdb03c945478699

class PanierController extends Controller
{
    /**
     * GET /api/paniers
<<<<<<< HEAD
     * Retourne tous les paniers en cours
     * → Théotime
     */
    public function index()
    {
        $paniers = Panier::select('id', 'statut')
=======
     * Retourne tous les paniers en cours (ID seulement)
     */
    public function index()
    {
        $paniers = Panier::select('id','statut')
>>>>>>> 8b084609477424c13c6d336d0cdb03c945478699
                         ->where('statut', 'en cours')
                         ->get();

        return response()->json([
            'message' => 'Liste des paniers en cours',
<<<<<<< HEAD
            'data'    => $paniers
        ]);
    }

    /**
     * POST /api/paniers
     * Créer un nouveau panier
     * → Théotime
     */
=======
            'data' => $paniers
        ]);
    }
     
>>>>>>> 8b084609477424c13c6d336d0cdb03c945478699
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
<<<<<<< HEAD
            'statut'  => 'required|string|in:en cours,terminé'
=======
            'statut' => 'required|string|in:en cours,terminé'
>>>>>>> 8b084609477424c13c6d336d0cdb03c945478699
        ]);

        $panier = Panier::create([
            'user_id' => $validated['user_id'],
<<<<<<< HEAD
            'statut'  => $validated['statut']
=======
            'statut' => $validated['statut']
>>>>>>> 8b084609477424c13c6d336d0cdb03c945478699
        ]);

        return response()->json([
            'message' => 'Panier créé avec succès',
<<<<<<< HEAD
            'data'    => $panier
=======
            'data' => $panier
>>>>>>> 8b084609477424c13c6d336d0cdb03c945478699
        ], 201);
    }

    /**
<<<<<<< HEAD
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

    public function validatePanier(int $id): JsonResponse
    {
        $panier = Panier::find($id);

        if (!$panier) {
            return response()->json([
                'message' => 'Commande introuvable'
            ], 404);
        }

        // vérifier qu'il est en cours
        if ($panier->statut !== 'en cours') {
            return response()->json([
                'message' => 'Cette commande ne peut pas etre validee'
            ], 400);
        }

        // update statut
        $panier->statut = 'validé';
        $panier->save();

        return response()->json([
            'message' => 'Commande validee avec succes',
            'data'    => $panier
        ]);
    }

    public function checkout(int $id): JsonResponse
    {
        $panier = Panier::find($id);

        if (!$panier) {
            return response()->json([
                'message' => 'Commande introuvable'
            ], 404);
        }

        // vérifier qu'il est en cours
        if ($panier->statut !== 'validé') {
            return response()->json([
                'message' => 'Cette commande ne peut pas etre expedier'
            ], 400);
        }

        // update statut
        $panier->statut = 'expédiée';
        $panier->save();

        return response()->json([
            'message' => 'Commande expediee avec succes',
            'data'    => $panier
        ]);
    }

public function destroy(int $id): JsonResponse
{
    $panier = Panier::find($id);

    if (!$panier) {
        return response()->json([
            'message' => 'Commande introuvable'
        ], 404);
    }

    $panier->delete();

    return response()->json([
        'message' => 'Commande supprimée avec succès'
    ]);
}
=======
     * PUT /api/paniers/{id}
     * Met à jour le statut du panier
     */

>>>>>>> 8b084609477424c13c6d336d0cdb03c945478699
}