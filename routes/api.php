<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CocktailApiController;
use App\Http\Controllers\Api\TypeApiController;
use App\Http\Controllers\Api\IngredientApiController;
use App\Http\Controllers\CocktailController;



//Route::get('cocktails/{id}/image', [CocktailController::class, 'image']);

Route::name('api.')->group(function () {

     // CRUD completo per i cocktail (inclusi index e show)
     Route::apiResource('cocktails', CocktailApiController::class)
          ->only(['index', 'show']);

     // Endpoint per ottenere la lista di tutti i tipi
     Route::apiResource('types', TypeApiController::class)
          ->only(['index']);

     // Endpoint per ottenere la lista di tutti gli ingredienti
     Route::apiResource('ingredients', IngredientApiController::class)
          ->only(['index']);
});
