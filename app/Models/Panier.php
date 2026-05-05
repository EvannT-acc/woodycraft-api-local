<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $fillable = ['statut', 'total', 'mode_paiement', 'user_id'];

    // Relation avec Puzzle via table pivot "appartient"
    public function puzzles()
    {
        return $this->belongsToMany(Puzzle::class, 'appartient')
                    ->withPivot('quantite');
    }

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
