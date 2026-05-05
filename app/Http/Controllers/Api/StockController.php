<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Puzzle;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * GET /api/stocks
     * Affiche l'état des stocks pour tous les puzzles.
     */
    public function index()
    {
        $stocks = Puzzle::select('id', 'nom', 'stock')->get();

        $data = $stocks->map(function ($p) {
            return [
                'id'       => $p->id,
                'nom'      => $p->nom,
                'quantite' => $p->stock,
                'alerte'   => $p->stock <= 5,
                'statut'   => $this->definirStatut($p->stock),
            ];
        });

        return response()->json($data);
    }

    /**
     * PATCH /api/stocks/{id}
     * Met à jour la quantité en stock d'un puzzle spécifique.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantite' => 'required|integer|min:0'
        ]);

        $puzzle = Puzzle::findOrFail($id);
        $puzzle->stock = $request->quantite;
        $puzzle->save();

        return response()->json([
            'success'       => true,
            'message'       => "Stock mis à jour pour {$puzzle->nom}",
            'nouveau_stock' => $puzzle->stock,
            'statut'        => $this->definirStatut($puzzle->stock)
        ]);
    }

    private function definirStatut($q)
    {
        if ($q <= 0) return 'RUPTURE_DE_STOCK';
        if ($q <= 5) return 'STOCK_BAS';
        return 'OK';
    }
}