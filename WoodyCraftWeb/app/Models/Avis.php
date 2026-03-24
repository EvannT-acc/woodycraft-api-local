<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $table = 'avis';

    protected $fillable = [
        'user_id',
        'puzzle_id',
        'commande_id',
        'note',
        'commentaire',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class, 'puzzle_id');
    }
}