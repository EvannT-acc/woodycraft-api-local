<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PuzzleController;
use App\Http\Controllers\Api\PanierController;

// Puzzles
Route::apiResource('puzzles', PuzzleController::class);

// Paniers
Route::prefix('paniers')->group(function () {
    Route::get('/', [PanierController::class, 'index']);       // Tous les paniers en cours
    Route::post('/', [PanierController::class, 'store']);     // Créer
});
