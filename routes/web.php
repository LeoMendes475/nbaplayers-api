<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;

use Fruitcake\Cors\HandleCors;

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'players',
], function () {
    Route::get('/findAll', [PlayersController::class, 'findAll']);
    Route::get('/fetch-and-save', [PlayersController::class, 'fetchAndSavePlayers']);
    Route::put('/{id}', [PlayersController::class, 'updatePlayer']);
    Route::delete(
        '/{id}',
        [PlayersController::class, 'deletePlayer']
    );
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/teste-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

