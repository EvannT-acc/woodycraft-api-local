<?php

namespace App\Http\Controllers;

use App\Models\Adresse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdresseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Liste des adresses
    public function index()
    {
        $adresses = Auth::user()->adresses;
        return view('adresses.create', compact('adresses'));
    }

    // Formulaire création
    public function create()
    {
        return view('adresses.create');
    }

    // Stocker nouvelle adresse
    public function store(Request $request)
    {

        $user = Auth::user();

        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'rue' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|string|max:20',
            'pays' => 'required|string|max:255',
        ]);

        Adresse::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        //$adresse = new Adresse($request->all());
        //$adresse->user_id = Auth::id(); // <-- indispensable
        //$adresse->save();
    
        return redirect()->route('paniers.index')->with('message', 'Adresse ajoutée avec succès !');
    }
    

    // Formulaire édition
    public function edit(Adresse $adresse)
    {
        dd([
            'adresse_id' => $adresse->id,
        ]);

        abort_if($adresse->user_id !== Auth::id(), 403);
        return view('adresses.edit', compact('adresse'));
    }

    // Mise à jour
    public function update(Request $request, Adresse $adresse)
    {
        abort_if($adresse->user_id !== Auth::id(), 403);

        $request->validate([
            'nom' => 'required|string|max:255',
            'rue' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|string|max:20',
            'pays' => 'required|string|max:255',
        ]);

        $adresse->update($request->all());

        return redirect()->route('paniers.index')->with('message', 'Adresse mise à jour avec succès !');
    }

    // Supprimer adresse
    public function destroy(Adresse $adresse)
    {


        abort_if($adresse->user_id !== Auth::id(), 403);
        $adresse->delete();

        return redirect()->route('paniers.index')->with('message', 'Adresse supprimée avec succès !');
    }

    // Afficher une adresse
    public function show(Adresse $adresse)
    {
        abort_if($adresse->user_id !== Auth::id(), 403);
        return view('adresses.show', compact('adresse'));
    }

}
