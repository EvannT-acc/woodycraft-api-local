<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PuzzleController;
use App\Http\Controllers\Api\PanierController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\AuthController;

// --- AUTHENTIFICATION (Public) -----------------------------------------------
Route::post('/login', [AuthController::class, 'login']);

// --- ROUTES PROTÉGÉES (Nécessitent un token Sanctum) -------------------------
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // --- Puzzles ---
    Route::apiResource('puzzles', PuzzleController::class);

    // --- Paniers / Commandes ---
    Route::prefix('paniers')->group(function () {
        Route::get('/',     [PanierController::class, 'index']);
        Route::post('/',    [PanierController::class, 'store']);
        Route::get('/{id}', [PanierController::class, 'show']);
    });

    // --- Stocks ---
    Route::get('/stocks',        [StockController::class, 'index']);
    Route::patch('/stocks/{id}', [StockController::class, 'update']);

    // --- Dashboard ---
    Route::prefix('dashboard')->group(function () {
        Route::get('/resume',            [DashboardController::class, 'resume']);
        Route::get('/commandes-attente', [DashboardController::class, 'commandesEnAttente']);
        Route::get('/stock-bas',         [DashboardController::class, 'stockBas']);
        Route::get('/stats-ventes',      [DashboardController::class, 'statsVentes']);
        Route::get('/top-puzzles',       [DashboardController::class, 'topPuzzles']);
    });
});