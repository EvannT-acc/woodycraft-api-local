<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adresse extends Model
{
    use HasFactory;

    protected $table = 'adresses'; // obligatoire pour être sûr

    protected $fillable = [
        'user_id', 'nom', 'rue', 'ville', 'code_postal', 'pays'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
