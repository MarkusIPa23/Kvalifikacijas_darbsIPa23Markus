<?php

use App\Http\Controllers\RandomGameController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (\Illuminate\Http\Request $request) {
    return view('welcome', [
        'favoriteGames' => array_values($request->session()->get('favorite_games', [])),
    ]);
})->name('home');

Route::get('/games', [RandomGameController::class, 'search'])->name('games.search');
Route::post('/favorites/toggle', [RandomGameController::class, 'toggleFavorite'])->name('favorites.toggle');
Route::get('/random', [RandomGameController::class, 'random'])->name('games.random');
