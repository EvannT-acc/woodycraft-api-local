<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LignePanier extends Model
{
    use HasFactory;

    protected $table = 'ligne_paniers';

    protected $fillable = [
        'puzzle_id',
        'panier_id',
        'quantite',
    ];

    public function panier()
    {
        return $this->belongsTo(Panier::class, 'panier_id');
    }

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class, 'puzzle_id');
    }
}