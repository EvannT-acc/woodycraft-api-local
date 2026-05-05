<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('appartient', function (Blueprint $table) {
            $table->unsignedBigInteger('puzzle_id');   // clé étrangère vers puzzles
            $table->unsignedBigInteger('panier_id');   // clé étrangère vers paniers
            $table->integer('quantite')->default(1);
    
            // Clé primaire composite
            $table->primary(['puzzle_id', 'panier_id']);
    
            // Contraintes
            $table->foreign('puzzle_id')->references('id')->on('puzzles')->onDelete('cascade');
            $table->foreign('panier_id')->references('id')->on('paniers')->onDelete('cascade');
        });
    }
    
};
