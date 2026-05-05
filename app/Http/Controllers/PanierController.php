<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Panier;
use App\Models\Puzzle;

class PanierController extends Controller
{
    // Affiche le panier de l'utilisateur connecté
    public function index()
    {
        $user = Auth::user();
        $panier = Panier::where('user_id', $user->id)->where('statut', 'en cours')->first();
        $puzzles = $panier ? $panier->puzzles : collect();
        $adresse = $user->adresse; // récupère l’adresse si elle existe

        return view('paniers.index', compact('puzzles', 'adresse'));
    }


    // Met à jour la quantité (boutons + / -)
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $panier = Panier::where('user_id', $user->id)->where('statut', 'en cours')->first();

        if (!$panier) {
            return redirect()->route('paniers.index')->with('message', 'Aucun panier trouvé.');
        }

        $puzzle = $panier->puzzles()->where('puzzle_id', $id)->first();

        if (!$puzzle) {
            return redirect()->route('paniers.index')->with('message', 'Produit introuvable dans le panier.');
        }

        $action = $request->input('action');

        if ($action === 'increase') {
            if ($puzzle->stock > $puzzle->pivot->quantite) {
                $puzzle->pivot->quantite += 1;
            } else return redirect()->route('paniers.index')->with('message', 'quantité maximal atteinte');
        } elseif ($action === 'decrease') {
            $puzzle->pivot->quantite = max(1, $puzzle->pivot->quantite - 1);
        }

        $puzzle->pivot->save();

        // Met à jour le total
        $panier->total = $panier->puzzles->sum(fn($p) => $p->prix * $p->pivot->quantite);
        $panier->save();

        return redirect()->route('paniers.index');
    }

    // Supprimer un produit du panier
    public function destroy($id)
    {
        $user = Auth::user();
        $panier = Panier::where('user_id', $user->id)->where('statut', 'en cours')->first();

        if ($panier) {
            $panier->puzzles()->detach($id);

            // Recalcul du total
            $panier->total = $panier->puzzles->sum(fn($p) => $p->prix * $p->pivot->quantite);
            $panier->save();
        }

        return redirect()->route('paniers.index')->with('message', 'Produit supprimé du panier.');
    }

    public function paiement()
    {
        return view('paniers.paiement');
    }


    public function facturePdf()
    {
        $user = Auth::user();
        $panier = Panier::where('user_id', $user->id)
                        ->where('statut', 'en cours')
                        ->with('puzzles')
                        ->firstOrFail();

        $adresse = $user->adresse; // relation hasOne avec Adresse

        $pdf = Pdf::loadView('paniers.facture', [
            'user' => $user,
            'panier' => $panier,
            'adresse' => $adresse,
        ]);

        return $pdf->download('facture_' . $panier->id . '.pdf');
    }


    public function store(Request $request)
    {
        $request->validate([
            'mode_paiement' => 'required|in:paypal,cheque',
        ]);

        $user = Auth::user();
        $panier = Panier::where('user_id', $user->id)->where('statut', 'en cours')->firstOrFail();

        $panier->mode_paiement = $request->mode_paiement;
        
        $panier->save();

        if ($request->mode_paiement === 'paypal') {
            $panier->statut = "preparation";
            $panier->save();
            return redirect('https://www.paypal.com/fr/home/');
        }
        
        $pdf = Pdf::loadView('paniers.facture', [
            'user' => $user,
            'panier' => $panier,
            'adresse' => $user->adresse,
        ]);

        $panier->statut = "preparation";
        $panier->save();

        // Si c’est un chèque, tu rediriges vers la génération du PDF
        return $pdf->download('facture_' . $panier->id . '.pdf');
    }

}
