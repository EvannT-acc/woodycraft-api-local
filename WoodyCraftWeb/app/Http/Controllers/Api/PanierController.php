<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Panier;

class PanierController extends Controller
{
    /**
     * GET /api/paniers
     * Retourne tous les paniers en cours (ID seulement)
     */
    public function index()
    {
        $paniers = Panier::select('id','statut')
                         ->where('statut', 'en cours')
                         ->get();

        return response()->json([
            'message' => 'Liste des paniers en cours',
            'data' => $paniers
        ]);
    }
     
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'statut' => 'required|string|in:en cours,terminé'
        ]);

        $panier = Panier::create([
            'user_id' => $validated['user_id'],
            'statut' => $validated['statut']
        ]);

        return response()->json([
            'message' => 'Panier créé avec succès',
            'data' => $panier
        ], 201);
    }

    /**
     * PUT /api/paniers/{id}
     * Met à jour le statut du panier
     */

}