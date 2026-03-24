<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model
{
    use HasFactory;

    protected $table = 'puzzles';

    protected $fillable = [
        'nom',
        'categorie_id',
        'description',
        'image',
        'prix',
        'stock',
        'seuil_alerte',
        'created_at',
        'updated_at',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function paniers()
    {
        return $this->belongsToMany(
            Panier::class,
            'appartient',
            'puzzle_id',
            'panier_id'
        )->withPivot('quantite');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'puzzle_id');
    }
}