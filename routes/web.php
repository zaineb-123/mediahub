<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
Route::resource('categories', CategorieController::class)
    ->parameters(['categories' => 'categorie']);
Route::get('/', [PageController::class, 'accueil'])
    ->name('accueil');

Route::get('/a-propos', [PageController::class, 'aPropos'])
    ->name('a-propos');

Route::resource('contenus', ContenuController::class);

    Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [AdminController::class, 'index'])
        ->name('dashboard');
});