<?php

namespace Tests\Unit;

use App\Models\Puzzle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PuzzleTest extends TestCase
{
    use RefreshDatabase;

    public function test_puzzle_can_be_created()
    {
        $puzzle = Puzzle::factory()->create([
            'nom' => 'Test Puzzle',
            'categorie' => 'Test Categorie',
            'description' => 'Ceci est un puzzle de test.',
            'prix' => 9.99,
            'image' => 'test_image.png', // Ajouter le champ image
        ]);

        $this->assertDatabaseHas('puzzles', [
            'nom' => 'Test Puzzle',
        ]);
    }

    public function test_puzzle_creation_fails_with_missing_data()
    {
        $this->expectException(ValidationException::class);

        $puzzleData = [
            'nom' => '',
            'categorie' => '',
            'description' => '',
            'prix' => '',
            'image' => '', // Ajouter le champ image
        ];

        // Valider les données manuellement
        $validator = Validator::make($puzzleData, [
            'nom' => 'required',
            'categorie' => 'required',
            'description' => 'required',
            'prix' => 'required|numeric',
            'image' => 'required',
        ]);

        $validator->validate();

        Puzzle::create($puzzleData);
    }

    public function test_puzzle_creation_fails_with_invalid_data()
    {
        $this->expectException(ValidationException::class);

        $puzzleData = [
            'nom' => str_repeat('A', 256), // Nom trop long
            'categorie' => 'Test Categorie',
            'description' => 'Ceci est un puzzle de test.',
            'prix' => -5.99, // Prix négatif
            'image' => 'test_image.png', // Ajouter le champ image
        ];

        // Valider les données manuellement
        $validator = Validator::make($puzzleData, [
            'nom' => 'required|max:255',
            'categorie' => 'required',
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'image' => 'required',
        ]);

        $validator->validate();

        Puzzle::create($puzzleData);
    }

    public function test_puzzle_creation_fails_with_duplicate_data()
    {
        $puzzleData = [
            'nom' => 'Unique Puzzle',
            'categorie' => 'Test Categorie',
            'description' => 'Ceci est un puzzle de test.',
            'prix' => 9.99,
            'image' => 'test_image.png', // Ajouter le champ image
        ];

        Puzzle::create($puzzleData);

        $this->expectException(ValidationException::class);

        // Valider les données manuellement avec la règle d’unicité
        $validator = Validator::make($puzzleData, [
            'nom' => 'required|unique:puzzles,nom',
            'categorie' => 'required',
            'description' => 'required',
            'prix' => 'required|numeric|min:0',
            'image' => 'required',
        ]);

        $validator->validate();

        Puzzle::create($puzzleData); // Création avec le même nom unique
        
    }
    public function test_puzzle_can_be_read()
    {
        // Création d'un puzzle en base avec des données spécifiques
        $puzzle = Puzzle::factory()->create([
            'nom' => 'Test Puzzle',
            'categorie' => 'Test Categorie',
            'description' => 'Ceci est un puzzle de test.',
            'prix' => 9.99,
        ]);
        $foundPuzzle = Puzzle::find($puzzle->id);

        //verifie que le puzzle zxiste
        $this->assertNotNull($foundPuzzle);

        //verifie que le nom du puzzle est truc
        $this->assertEquals('Test Puzzle', $foundPuzzle->nom);
        
    }
    
    public function test_puzzle_can_be_updated()
    {
    // Création d'un puzzle avec les données générées par la factory
    $puzzle = Puzzle::factory()->create();

    // Mise à jour du nom du puzzle
    $puzzle->nom = 'Nom mis a jour';
    $puzzle->save();

    // Récupérer à nouveau le puzzle depuis la base de données
    $updatedPuzzle = Puzzle::find($puzzle->id);

    // Vérifier que le nom a bien été mis à jour
    $this->assertEquals('Nom mis a jour', $updatedPuzzle->nom);
    }

    public function test_puzzle_can_be_deleted()
    {
    // Création d'un puzzle avec la factory
    $puzzle = Puzzle::factory()->create();
    

    // Suppression du puzzle
    $puzzle->delete();

    // Vérification que le puzzle n'existe plus en base de données
    $this->assertDatabaseMissing('puzzles', [
        'id' => $puzzle->id,
    ]);
    }


}
