use App\Models\Approvisionnement;
use App\Models\Puzzle;
use Illuminate\Support\Facades\DB; // Très important pour la sécurité des données

public function update(Request $request, $id)
{
    $request->validate([
        'quantite' => 'required|integer|min:0',
        'fournisseur' => 'nullable|string'
    ]);

    // On utilise une transaction : si un truc plante, rien n'est enregistré
    return DB::transaction(function () use ($request, $id) {
        
        $puzzle = Puzzle::findOrFail($id);
        $ancienStock = $puzzle->stock;
        $nouveauStock = $request->quantite;
        $difference = $nouveauStock - $ancienStock;

        // 1. Mise à jour du stock du Puzzle
        $puzzle->stock = $nouveauStock;
        $puzzle->save();

        // 2. Traçabilité : on crée l'approvisionnement seulement si on a ajouté du stock
        if ($difference > 0) {
            Approvisionnement::create([
                'puzzle_id'   => $puzzle->id,
                'quantite'    => $difference,
                'fournisseur' => $request->fournisseur ?? 'Manuel',
                'date_reception' => now(), // Optionnel : ajoute la date actuelle
            ]);
        }

        return response()->json([
            'success'       => true,
            'message'       => "Stock mis à jour (" . ($difference > 0 ? "Approvisionnement tracé" : "Correction manuelle") . ")",
            'nouveau_stock' => $puzzle->stock,
            'difference'    => $difference
        ]);
    });
}