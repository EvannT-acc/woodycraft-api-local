<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Puzzle;
use Illuminate\Http\Request;

class PuzzleController extends Controller
{
    // GET /api/puzzles
    public function index()
    {
        $puzzles = Puzzle::orderBy('id', 'desc')->get();
        return response()->json($puzzles, 200);
    }

    // POST /api/puzzles
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'          => 'required|string|max:255',
            'categorie_id' => 'required|integer|exists:categories,id',
            'description'  => 'required|string|max:500',
            'image'        => 'required|string|max:255',
            'prix'         => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
        ]);

        $puzzle = Puzzle::create($validated);

        return response()->json([
            'message' => 'Puzzle créé avec succès',
            'data'    => $puzzle
        ], 201);
    }

    // GET /api/puzzles/{id}
    public function show(string $id)
    {
        $puzzle = Puzzle::find($id);

        if (!$puzzle) {
            return response()->json([
                'message' => 'Puzzle introuvable'
            ], 404);
        }

        return response()->json($puzzle, 200);
    }

    // PUT /api/puzzles/{id}
    public function update(Request $request, string $id)
    {
        $puzzle = Puzzle::find($id);

        if (!$puzzle) {
            return response()->json([
                'message' => 'Puzzle introuvable'
            ], 404);
        }

        $validated = $request->validate([
            'nom'          => 'required|string|max:255',
            'categorie_id' => 'required|integer|exists:categories,id',
            'description'  => 'required|string|max:500',
            'image'        => 'required|string|max:255',
            'prix'         => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
        ]);

        $puzzle->update($validated);

        return response()->json([
            'message' => 'Puzzle mis à jour',
            'data'    => $puzzle
        ], 200);
    }

    // DELETE /api/puzzles/{id}
    public function destroy(string $id)
    {
        $puzzle = Puzzle::find($id);

        if (!$puzzle) {
            return response()->json([
                'message' => 'Puzzle introuvable'
            ], 404);
        }

        $puzzle->delete();

        return response()->json([
            'message' => 'Puzzle supprimé avec succès'
        ], 200);
    }
}