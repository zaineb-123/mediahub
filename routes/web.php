
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\AuthController;

// Pages publiques
Route::get('/', [PageController::class, 'accueil'])->name('accueil');
Route::get('/a-propos', [PageController::class, 'aPropos'])->name('a-propos');

// Catégories
Route::resource('categories', CategorieController::class)
    ->parameters(['categories' => 'categorie']);

// Authentification : visiteurs non connectés uniquement
Route::middleware('guest')->group(function () {
    Route::get('/inscription', [AuthController::class, 'create'])
        ->name('inscription');
    Route::post('/inscription', [AuthController::class, 'store']);

    Route::get('/connexion', [AuthController::class, 'creerConnexion'])
        ->name('connexion');
    Route::post('/connexion', [AuthController::class, 'connecter']);
});

// Déconnexion : utilisateurs connectés uniquement
Route::middleware('auth')->post('/deconnexion', [AuthController::class, 'deconnecter'])
    ->name('deconnexion');

// Actions sur les publications réservées aux utilisateurs connectés
Route::middleware('auth')->group(function () {
    Route::resource('contenus', ContenuController::class)
        ->parameters(['contenus' => 'contenu'])
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
});

// Publications consultables publiquement
Route::resource('contenus', ContenuController::class)
    ->parameters(['contenus' => 'contenu'])
    ->only(['index', 'show']);

// Administration
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [AdminController::class, 'index'])
        ->name('dashboard');
});
