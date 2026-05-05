<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PuzzleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\AdresseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CategorieController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('puzzles', PuzzleController::class);


    Route::resource('paniers', PanierController::class)->middleware('auth');
    Route::get('/paiement', [PanierController::class, 'paiement'])->name('paniers.paiement');
    Route::post('/paiement', [PanierController::class, 'store'])->name('paiement.store');
    Route::get('/facture/pdf', [PanierController::class, 'facturePdf'])->name('facture.pdf');


    Route::resource('adresses', AdresseController::class)->middleware('auth');
    
    Route::get('/puzzle/add/{id}', [PuzzleController::class, 'ajouterAuPanier'])->name('puzzle.add');
    

    Route::resource('categories', CategorieController::class);

});



require __DIR__.'/auth.php';
