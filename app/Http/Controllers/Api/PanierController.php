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
     * Retourne TOUTES les commandes avec les infos nécessaires à Flutter
     */
    public function index(): JsonResponse
    {
        $paniers = Panier::select('id', 'statut', 'total', 'mode_paiement', 'created_at')
                         ->orderBy('created_at', 'desc')
                         ->get()
                         ->map(fn($p) => [
                             'id'             => $p->id,
                             'statut'         => $p->statut,
                             'total'          => (float) $p->total,
                             'mode_paiement'  => $p->mode_paiement,
                             'date_commande'  => $p->created_at,
                         ]);

        return response()->json([
            'message' => 'Liste des commandes',
            'data'    => $paniers,
        ]);
    }

    /**
     * POST /api/paniers
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'statut'  => 'required|string|in:en cours,validé,expédié,annulé',
        ]);

        $panier = Panier::create($validated);

        return response()->json([
            'message' => 'Panier créé avec succès',
            'data'    => $panier,
        ], 201);
    }

    /**
     * GET /api/paniers/{id}
     * Détail complet d'une commande
     */
    public function show(int $id): JsonResponse
    {
        $panier = Panier::with(['user', 'user.adresses', 'puzzles'])->find($id);

        if (!$panier) {
            return response()->json(['message' => 'Commande introuvable'], 404);
        }

        $articles = $panier->puzzles->map(fn($puzzle) => [
            'id'            => $puzzle->id,
            'nom'           => $puzzle->nom,
            'image'         => $puzzle->image,
            'prix_unitaire' => $puzzle->prix,
            'quantite'      => $puzzle->pivot->quantite,
            'sous_total'    => round($puzzle->prix * $puzzle->pivot->quantite, 2),
        ]);

        $adresse = null;
        if ($panier->user && $panier->user->adresses && $panier->user->adresses->isNotEmpty()) {
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
            'total'             => (float) $panier->total,
            'mode_paiement'     => $panier->mode_paiement,
            'date_commande'     => $panier->created_at,
            'client'            => $panier->user ? [
                'id'        => $panier->user->id,
                'nom'       => $panier->user->name ?? $panier->user->nom,
                'email'     => $panier->user->email,
                'telephone' => $panier->user->telephone ?? null,
            ] : null,
            'adresse_livraison' => $adresse,
            'articles'          => $articles,
            'nb_articles'       => $articles->count(),
        ]);
    }

    /**
     * DELETE /api/paniers/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $panier = Panier::find($id);

        if (!$panier) {
            return response()->json(['message' => 'Commande introuvable'], 404);
        }

        $panier->delete();

        return response()->json(['message' => 'Commande supprimée'], 200);
    }

    /**
     * PUT /api/paniers/{id}/validate
     * Passe le statut à "validé"
     */
    public function valider(int $id): JsonResponse
    {
        $panier = Panier::find($id);

        if (!$panier) {
            return response()->json(['message' => 'Commande introuvable'], 404);
        }

        $panier->statut = 'validé';
        $panier->save();

        return response()->json([
            'message' => 'Commande validée',
            'data'    => $panier,
        ]);
    }

    /**
     * PUT /api/paniers/{id}/checkout
     * Passe le statut à "expédié"
     */
    public function expedier(int $id): JsonResponse
    {
        $panier = Panier::find($id);

        if (!$panier) {
            return response()->json(['message' => 'Commande introuvable'], 404);
        }

        $panier->statut = 'expédié';
        $panier->save();

        return response()->json([
            'message' => 'Commande expédiée',
            'data'    => $panier,
        ]);
    }
}