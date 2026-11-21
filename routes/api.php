
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\AuthController;

// Route pour récupérer l'utilisateur connecté
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes publiques : lecture des publications
Route::apiResource('publications', PublicationController::class)
    ->only(['index', 'show']);

// Routes protégées : création, modification et suppression
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('publications', PublicationController::class)
        ->except(['index', 'show']);
});
Route::post('/connexion', [AuthController::class, 'connecter']);
