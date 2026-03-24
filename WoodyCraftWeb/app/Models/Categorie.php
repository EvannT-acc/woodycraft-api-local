<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'nom',
        'description',
        'image',
        'created_at',
        'updated_at',
    ];

    public function puzzles()
    {
        return $this->hasMany(Puzzle::class, 'categorie_id');
    }
}