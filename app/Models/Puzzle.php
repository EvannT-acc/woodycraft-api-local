<?php

// Le modèle Puzzle représente la table "puzzles".
// On lui ajoute la relation vers les approvisionnements.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'image',
        'prix',
        'categorie_id',
        'stock',
    ];

    /**
     * Relation : un puzzle POSSÈDE PLUSIEURS approvisionnements.
     * Cela permet d'écrire $puzzle -_--> approvisionnements pour voir tout son historique.
     */
    public function approvisionnements()
    {
        return $this->hasMany(Approvisionnement::class);
    }

    /**
     * Relation vers la catégorie (déjà existante dans ton projet,
     * on la garde pour ne rien casser)
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}