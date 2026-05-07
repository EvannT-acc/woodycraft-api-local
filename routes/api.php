<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PuzzleController;
use App\Http\Controllers\Api\PanierController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApprovisionnementController; // ← NOUVEAU

// --- Auth (public) -----------------------------------------------------------
Route::post('/login',    [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);

// --- Puzzles -----------------------------------------------------------------
Route::apiResource('puzzles', PuzzleController::class);

// --- Paniers / Commandes -----------------------------------------------------
Route::prefix('paniers')->group(function () {
    Route::get('/',              [PanierController::class, 'index']);
    Route::post('/',             [PanierController::class, 'store']);
    Route::get('/{id}',          [PanierController::class, 'show']);
    Route::delete('/{id}',       [PanierController::class, 'destroy']);
    Route::put('/{id}/validate', [PanierController::class, 'valider']);
    Route::put('/{id}/checkout', [PanierController::class, 'expedier']);
});

// --- Stocks ------------------------------------------------------------------
Route::get('/stocks', [StockController::class, 'index']);
Route::match(['put', 'patch'], '/stocks/{id}', [StockController::class, 'update']);

// --- Dashboard ---------------------------------------------------------------
Route::prefix('dashboard')->group(function () {
    Route::get('/resume',            [DashboardController::class, 'resume']);
    Route::get('/commandes-attente', [DashboardController::class, 'commandesEnAttente']);
    Route::get('/stock-bas',         [DashboardController::class, 'stockBas']);
    Route::get('/stats-ventes',      [DashboardController::class, 'statsVentes']);
    Route::get('/top-puzzles',       [DashboardController::class, 'topPuzzles']);
});

// --- Approvisionnements
// GET  /api/approvisionnements --> historique 
// POST /api/approvisionnements -> créer un appro + ey met à jour le stock
Route::get('/approvisionnements',  [ApprovisionnementController::class, 'index']);
Route::post('/approvisionnements', [ApprovisionnementController::class, 'store']);

// --- User authentifié --------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user',    fn(Request $r) => $r->user());
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});