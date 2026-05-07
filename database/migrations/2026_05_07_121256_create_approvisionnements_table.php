<?php

// Ce fichier dit à Laravel comment créer la table "approvisionnements" dans MySQL.
// Une migration = une instruction de création/modification de table.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * La méthode up() est exécutée quand tu fais "php artisan migrate".
     * Elle crée la table.
     */
    public function up(): void
    {
        Schema::create('approvisionnements', function (Blueprint $table) {
            $table->id(); // Colonne id auto-incrémentée (1, 2, 3...)

            // Clé étrangère : lie chaque approvisionnement à un puzzle existant
            // Si le puzzle est supprimé, ses approvisionnements sont aussi supprimés (cascade)
            $table->foreignId('puzzle_id')
                  ->constrained('puzzles')
                  ->onDelete('cascade');

            $table->integer('quantite');       // Combien de puzzles ont été reçus
            $table->string('fournisseur');     // Nom du fournisseur (ex: "FourniBois SARL")

            // created_at et updated_at sont créés automatiquement par timestamps()
            $table->timestamps();
        });
    }

    /**
     * La méthode down() est exécutée quand tu fais "php artisan migrate:rollback".
     * Elle supprime la table (annule le up).
     */
    public function down(): void
    {
        Schema::dropIfExists('approvisionnements');
    }
};