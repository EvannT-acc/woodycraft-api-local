<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PuzzleController;
use App\Http\Controllers\Api\PanierController;
use App\Http\Controllers\Api\DashboardController;

// -- Puzzles ----------------------------------------------------------------------------------------------------------------------
Route::apiResource('puzzles', PuzzleController::class); // GET  /api/puzzles

// -- Paniers / Commandes ----------------------------------------------------------------------------------------------------------
Route::prefix('paniers')->group(function () {
    Route::get('/',     [PanierController::class, 'index']); // GET  /api/paniers
    Route::post('/',    [PanierController::class, 'store']); // POST /api/paniers
    Route::get('/{id}', [PanierController::class, 'show']);  // GET  /api/paniers/{id}
});

// -- Dashboard --------------------------------------------------------------------------------------------------------------------
Route::prefix('dashboard')->group(function () {
    Route::get('/resume',            [DashboardController::class, 'resume']);            // GET /api/dashboard/resume
    Route::get('/commandes-attente', [DashboardController::class, 'commandesEnAttente']); // GET /api/dashboard/commandes-attente 
    Route::get('/stock-bas',         [DashboardController::class, 'stockBas']);          // GET /api/dashboard/stock-bas
    Route::get('/stats-ventes',      [DashboardController::class, 'statsVentes']);       // GET /api/dashboard/stats-ventes
    Route::get('/top-puzzles',       [DashboardController::class, 'topPuzzles']);        // GET /api/dashboard/top-puzzles
});

//  -- Auth ------------------------------------------------------------------------------------------------------------------------
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});