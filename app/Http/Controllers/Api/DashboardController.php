<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use App\Models\Puzzle;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // -------------------------------------------------------
    // GET /api/dashboard/resume
    // Chiffres clés tout en haut du tableau de bord Flutter
    // -------------------------------------------------------
    public function resume()
    {
        $commandesEnAttente = Panier::where('statut', 'preparation')->count();
    
        $stockBasCount = Puzzle::whereColumn('stock', '<=', 'seuil_alerte')->count();
    
        $chiffreAffaireMois = Panier::where('statut', 'preparation')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
    
        $totalClients = User::whereNull('role')
            ->orWhere('role', '!=', 'admin')
            ->count();
    
        return response()->json([
            'commandes_en_attente'  => $commandesEnAttente,
            'puzzles_stock_bas'     => $stockBasCount,
            'chiffre_affaire_mois'  => round($chiffreAffaireMois, 2),
            'nombre_clients'        => $totalClients,
        ]);
    }

    // -------------------------------------------------------
    // GET /api/dashboard/commandes-attente
    // Liste des commandes en attente avec détail client
    // -------------------------------------------------------
    public function commandesEnAttente()
    {
        $commandes = Panier::with(['user', 'puzzles'])
            ->where('statut', 'preparation')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($panier) {
                return [
                    'id'            => $panier->id,
                    'statut'        => $panier->statut,
                    'total'         => $panier->total,
                    'mode_paiement' => $panier->mode_paiement,
                    'date_commande' => $panier->created_at,
                    'client' => $panier->user ? [
                        'id'     => $panier->user->id,
                        'nom'    => $panier->user->nom,
                        'prenom' => $panier->user->prenom,
                        'email'  => $panier->user->email,
                    ] : null,
                    'articles' => $panier->puzzles->map(fn($p) => [
                        'puzzle_id' => $p->id,
                        'nom'       => $p->nom,
                        'quantite'  => $p->pivot->quantite,
                        'prix'      => $p->prix,
                        'sous_total'=> round($p->prix * $p->pivot->quantite, 2),
                    ]),
                ];
            });

        return response()->json($commandes);
    }

    // -------------------------------------------------------
    // GET /api/dashboard/stock-bas
    // Puzzles dont le stock est <= seuil_alerte
    // -------------------------------------------------------
    public function stockBas()
    {
        $puzzles = Puzzle::with('categorie')
            ->whereColumn('stock', '<=', 'seuil_alerte')
            ->orderBy('stock', 'asc')
            ->get()
            ->map(fn($p) => [
                'id'           => $p->id,
                'nom'          => $p->nom,
                'stock'        => $p->stock,
                'seuil_alerte' => $p->seuil_alerte,
                'prix'         => $p->prix,
                'image'        => $p->image,
                'categorie'    => $p->categorie->nom ?? null,
            ]);

        return response()->json($puzzles);
    }

    // -------------------------------------------------------
    // GET /api/dashboard/stats-ventes
    // CA par jour (30 derniers jours) + CA par mois (12 mois)
    // -------------------------------------------------------
    public function statsVentes()
    {
        $caParJour = Panier::where('statut', 'preparation')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as chiffre_affaires'),
                DB::raw('COUNT(*) as nb_commandes')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();

        $caParMois = Panier::where('statut', 'preparation')
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

    // -------------------------------------------------------
    // GET /api/dashboard/top-puzzles
    // Top 5 puzzles les plus commandés (par quantité)
    // Note: utilise puzzles.prix car prix_unitaire pas encore
    //       dans la table appartient
    // -------------------------------------------------------
    public function topPuzzles()
    {
        $topPuzzles = DB::table('appartient')
            ->join('puzzles', 'puzzles.id', '=', 'appartient.puzzle_id')
            ->join('paniers', 'paniers.id', '=', 'appartient.panier_id')
            ->where('paniers.statut', 'preparation')
            ->select(
                'puzzles.id',
                'puzzles.nom',
                'puzzles.prix',
                'puzzles.image',
                'puzzles.stock',
                DB::raw('SUM(appartient.quantite) as total_vendu'),
                DB::raw('SUM(appartient.quantite * puzzles.prix) as revenu_total')
            )
            ->groupBy(
                'puzzles.id',
                'puzzles.nom',
                'puzzles.prix',
                'puzzles.image',
                'puzzles.stock'
            )
            ->orderBy('total_vendu', 'desc')
            ->limit(5)
            ->get();

        return response()->json($topPuzzles);
    }
}