<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PuzzleController;
use App\Http\Controllers\Api\PanierController;

// ── Puzzles ─────────────────────────────────────────────
Route::apiResource('puzzles', PuzzleController::class);

// ── Paniers / Commandes ──────────────────────────────────
Route::prefix('paniers')->group(function () {
    Route::get('/',     [PanierController::class, 'index']); // GET    /api/paniers       → Théotime
    Route::post('/',    [PanierController::class, 'store']); // POST   /api/paniers       → Théotime
    Route::get('/{id}', [PanierController::class, 'show']);  // GET    /api/paniers/{id}  → Evann
});

// ── Auth ─────────────────────────────────────────────────
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});