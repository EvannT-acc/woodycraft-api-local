<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Puzzle;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * GET /api/stocks
     */
    public function index()
    {
        $stocks = Puzzle::select('id', 'nom', 'stock')->get();

        return response()->json(
            $stocks->map(fn($p) => [
                'id'     => $p->id,
                'nom'    => $p->nom,
                'stock'  => $p->stock,
                'alerte' => $p->stock <= 5,
                'statut' => $this->definirStatut($p->stock),
            ])
        );
    }

    /**
     * PUT|PATCH /api/stocks/{id}
     * Fix : on lit le body JSON avec json_decode manuellement
     * car $request->input() est parfois vide sur PATCH + JSON
     */
    public function update(Request $request, $id)
    {
        // Lecture manuelle du body JSON — plus fiable que $request->input()
        // pour les requêtes PATCH avec Content-Type: application/json
        $body = json_decode($request->getContent(), true) ?? [];

        // Fusion avec les données normales (au cas où)
        $data = array_merge($request->all(), $body);

        // Accepte "stock" (Flutter) ou "quantite" (compatibilité)
        $newStock = $data['stock'] ?? $data['quantite'] ?? null;

        if ($newStock === null) {
            return response()->json(['message' => 'Le champ stock est requis'], 422);
        }

        $newStock = (int) $newStock;

        if ($newStock < 0) {
            return response()->json(['message' => 'Le stock ne peut pas être négatif'], 422);
        }

        $puzzle = Puzzle::findOrFail($id);
        $puzzle->stock = $newStock;
        $puzzle->save();

        return response()->json([
            'success'       => true,
            'message'       => "Stock mis à jour pour {$puzzle->nom}",
            'nouveau_stock' => $puzzle->stock,
            'statut'        => $this->definirStatut($puzzle->stock),
        ]);
    }

    private function definirStatut(int $q): string
    {
        if ($q <= 0) return 'RUPTURE_DE_STOCK';
        if ($q <= 5) return 'STOCK_BAS';
        return 'OK';
    }
}