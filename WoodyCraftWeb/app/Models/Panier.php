<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $table = 'paniers';

    protected $fillable = [
        'statut',
        'total',
        'mode_paiement',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function puzzles()
    {
        return $this->belongsToMany(
            Puzzle::class,
            'appartient',
            'panier_id',
            'puzzle_id'
        )->withPivot('quantite');
    }
}