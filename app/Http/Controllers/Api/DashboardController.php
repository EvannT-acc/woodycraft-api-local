<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use App\Models\Puzzle;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * GET /api/dashboard/resume
     */
    public function resume()
    {
        // Statut "en cours" = commandes en attente de validation (cohérent avec Flutter)
        $commandesEnAttente = Panier::where('statut', 'en cours')->count();

        // Puzzles avec stock bas (colonne seuil_alerte, fallback à 5)
        $stockBasCount = Puzzle::whereRaw(
            'stock <= COALESCE(seuil_alerte, 5)'
        )->count();

        // CA du mois sur commandes validées ou expédiées
        $chiffreAffaireMois = Panier::whereIn('statut', ['validé', 'expédié'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $totalClients = User::where(function ($q) {
            $q->whereNull('role')->orWhere('role', '!=', 'admin');
        })->count();

        return response()->json([
            'commandes_en_attente' => $commandesEnAttente,
            'puzzles_stock_bas'    => $stockBasCount,
            'chiffre_affaire_mois' => round((float) $chiffreAffaireMois, 2),
            'total_clients'        => $totalClients,  // ← clé attendue par Flutter
        ]);
    }

    /**
     * GET /api/dashboard/commandes-attente
     */
    public function commandesEnAttente()
    {
        $commandes = Panier::with(['user', 'puzzles'])
            ->where('statut', 'en cours')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($panier) => [
                'id'            => $panier->id,
                'statut'        => $panier->statut,
                'total'         => (float) $panier->total,
                'mode_paiement' => $panier->mode_paiement,
                'date_commande' => $panier->created_at,
                'client' => $panier->user ? [
                    'id'    => $panier->user->id,
                    'nom'   => $panier->user->name ?? $panier->user->nom,
                    'email' => $panier->user->email,
                ] : null,
                'articles' => $panier->puzzles->map(fn($p) => [
                    'puzzle_id' => $p->id,
                    'nom'       => $p->nom,
                    'quantite'  => $p->pivot->quantite,
                    'prix'      => $p->prix,
                    'sous_total'=> round($p->prix * $p->pivot->quantite, 2),
                ]),
            ]);

        return response()->json($commandes);
    }

    /**
     * GET /api/dashboard/stock-bas
     */
    public function stockBas()
    {
        $puzzles = Puzzle::with('categorie')
            ->whereRaw('stock <= COALESCE(seuil_alerte, 5)')
            ->orderBy('stock', 'asc')
            ->get()
            ->map(fn($p) => [
                'id'           => $p->id,
                'nom'          => $p->nom,
                'stock'        => $p->stock,
                'seuil_alerte' => $p->seuil_alerte ?? 5,
                'prix'         => $p->prix,
                'image'        => $p->image,
                'categorie'    => $p->categorie->nom ?? null,
            ]);

        return response()->json($puzzles);
    }

    /**
     * GET /api/dashboard/stats-ventes
     */
    public function statsVentes()
    {
        $caParJour = Panier::whereIn('statut', ['validé', 'expédié'])
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as chiffre_affaires'),
                DB::raw('COUNT(*) as nb_commandes')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();

        $caParMois = Panier::whereIn('statut', ['validé', 'expédié'])
            ->where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('SUM(total) as chiffre_affaires'),
                DB::raw('COUNT(*) as nb_commandes')
            )
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('annee', 'asc')
            ->orderBy('mois', 'asc')
            ->get();

        return response()->json([
            'par_jour' => $caParJour,
            'par_mois' => $caParMois,
        ]);
    }

    /**
     * GET /api/dashboard/top-puzzles
     */
    public function topPuzzles()
    {
        $topPuzzles = DB::table('appartient')
            ->join('puzzles', 'puzzles.id', '=', 'appartient.puzzle_id')
            ->join('paniers', 'paniers.id', '=', 'appartient.panier_id')
            ->whereIn('paniers.statut', ['validé', 'expédié'])
            ->select(
                'puzzles.id',
                'puzzles.nom',
                'puzzles.prix',
                'puzzles.image',
                'puzzles.stock',
                DB::raw('SUM(appartient.quantite) as total_vendu'),
                DB::raw('SUM(appartient.quantite * puzzles.prix) as revenu_total')
            )
            ->groupBy('puzzles.id', 'puzzles.nom', 'puzzles.prix', 'puzzles.image', 'puzzles.stock')
            ->orderBy('total_vendu', 'desc')
            ->limit(5)
            ->get();

        return response()->json($topPuzzles);
    }
}