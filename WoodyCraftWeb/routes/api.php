<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PuzzleController;
use App\Http\Controllers\Api\PanierController;
<<<<<<< HEAD
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\StockController;

// --- Puzzles ------------------------------------------------------------------
Route::apiResource('puzzles', PuzzleController::class);

// --- Paniers / Commandes ------------------------------------------------------------------
Route::prefix('paniers')->group(function () {
    Route::get('/',     [PanierController::class, 'index']); // GET  /api/paniers
    Route::post('/',    [PanierController::class, 'store']); // POST /api/paniers
    Route::get('/{id}', [PanierController::class, 'show']);  // GET  /api/paniers/{id}
    Route::put('/{id}/validate', [PanierController::class, 'validatePanier']);
    Route::put('/{id}/checkout', [PanierController::class, 'checkout']);
    Route::delete('/{id}', [PanierController::class, 'destroy']);
});



// --- Stocks ------------------------------------------------------------------
Route::get('/stocks',        [StockController::class, 'index']);  // GET   /api/stocks
Route::patch('/stocks/{id}', [StockController::class, 'update']); // PATCH /api/stocks/{id}

// --- Dashboard ------------------------------------------------------------------
Route::prefix('dashboard')->group(function () {
    Route::get('/resume',            [DashboardController::class, 'resume']);
    Route::get('/commandes-attente', [DashboardController::class, 'commandesEnAttente']);
    Route::get('/stock-bas',         [DashboardController::class, 'stockBas']);
    Route::get('/stats-ventes',      [DashboardController::class, 'statsVentes']);
    Route::get('/top-puzzles',       [DashboardController::class, 'topPuzzles']);
});

// --- Auth ------------------------------------------------------------------
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
=======

// Puzzles
Route::apiResource('puzzles', PuzzleController::class);

// Paniers
Route::prefix('paniers')->group(function () {
    Route::get('/', [PanierController::class, 'index']);       // Tous les paniers en cours
    Route::post('/', [PanierController::class, 'store']);     // Créer
});
>>>>>>> 8b084609477424c13c6d336d0cdb03c945478699
