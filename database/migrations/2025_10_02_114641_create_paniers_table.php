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
        Schema::create('paniers', function (Blueprint $table) {
            $table->id(); // id panier (PK auto-incrément)
            $table->string('statut')->default('en cours'); // statut du panier
            $table->decimal('total', 8, 2)->default(0); // total du panier
            $table->string('mode_paiement')->nullable(); // chèque ou paypal
            $table->unsignedBigInteger('user_id'); // utilisateur lié
            $table->timestamps();
    
            // clé étrangère vers utilisateurs
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
};
