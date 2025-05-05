<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CocktailApiController;

Route::name('api.')
    ->group(function () {
        Route::apiResource('cocktails', CocktailApiController::class);
    });
