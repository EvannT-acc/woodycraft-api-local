<?php

// Le Controller gère la logique métier.
// Il reçoit les requêtes HTTP, fait les opérations en BDD, et retourne du JSON.

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Approvisionnement;
use App\Models\Puzzle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApprovisionnementController extends Controller
{
    /**
     * GET /api/approvisionnements
     *
     * Retourne TOUT l'historique des approvisionnements.
     * "with('puzzle')" = on charge aussi les infos du puzzle lié (son nom, son stock...)
     * Cela évite de faire une 2ème requête séparée pour chaque puzzle.
     * "orderBy desc" = les plus récents en premier.
     */
    // Fichier : ApprovisionnementController.php

    public function index(): JsonResponse
    {
        // LA JOINTURE EST ICI : with('puzzle')
        $appros = Approvisionnement::with('puzzle') 
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($appro) {
                return [
                    'id'           => $appro->id,
                    'puzzle_nom'   => $appro->puzzle ? $appro->puzzle->nom : 'Puzzle supprimé',
                    'quantite'     => $appro->quantite,
                    'fournisseur'  => $appro->fournisseur,
                    'created_at'   => $appro->created_at->format('d/m/Y H:i'),
                ];
            });

        return response()->json($appros, 200);
    }

    /**
     * POST /api/approvisionnements
     *
     * Crée un approvisionnement ET met à jour le stock du puzzle automatiquement.
     * C'est la logique métier principale : quand on reçoit des puzzles,
     * on enregistre la livraison ET on ajoute au stock existant.
     */
    public function store(Request $request): JsonResponse
    {
        // Validation des données envoyées par Flutter
        // Si une règle est violée, Laravel retourne automatiquement une erreur 422
        $validated = $request->validate([
            'puzzle_id'   => 'required|integer|exists:puzzles,id', // L'ID doit exister en BDD
            'quantite'    => 'required|integer|min:1',             // Au moins 1 unité
            'fournisseur' => 'required|string|max:255',            // Texte obligatoire
        ]);

        // ── Étape 1 : Créer l'enregistrement dans la table approvisionnements ──
        $appro = Approvisionnement::create([
            'puzzle_id'  => $validated['puzzle_id'],
            'quantite'   => $validated['quantite'],
            'fournisseur'=> $validated['fournisseur'],
        ]);

        // ── Étape 2 : Mettre à jour le stock du puzzle (logique automatique) ──
        // On cherche le puzzle concerné
        $puzzle = Puzzle::find($validated['puzzle_id']);

        // On ajoute la quantité reçue au stock actuel
        // Exemple : stock était 10, on reçoit 50 → nouveau stock = 60
        $puzzle->stock = $puzzle->stock + $validated['quantite'];
        $puzzle->save(); // On sauvegarde en base de données

        // Retourner une réponse complète pour Flutter
        return response()->json([
            'message'        => 'Approvisionnement créé et stock mis à jour',
            'approvisionnement' => [
                'id'          => $appro->id,
                'puzzle_nom'  => $puzzle->nom,
                'quantite'    => $appro->quantite,
                'fournisseur' => $appro->fournisseur,
                'created_at'  => $appro->created_at->format('d/m/Y H:i'),
            ],
            'nouveau_stock'  => $puzzle->stock, // Utile pour debug
        ], 201); // 201 = Created
    }
}