<?php

use App\Http\Controllers\CocktailController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('cocktails.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Cocktail routes (protected)
Route::middleware('auth')->group(function () {
    // Resource routes for cocktails
    Route::resource('cocktails', CocktailController::class);

    // Dedicated endpoint to serve the BLOB image
    Route::get('cocktails/{cocktail}/image', [CocktailController::class, 'image'])
        ->name('cocktails.image');

    // CRUD for Types e Ingredients
    Route::resource('types', TypeController::class);
    Route::resource('ingredients', IngredientController::class);
});

require __DIR__ . '/auth.php';
