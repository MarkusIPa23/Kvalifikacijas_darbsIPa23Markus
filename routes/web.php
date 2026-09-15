<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RandomGameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $favoriteGames = $request->user()?->favorite_games
        ?? $request->session()->get('favorite_games', []);

    return view('welcome', [
        'favoriteGames' => array_values($favoriteGames),
    ]);
})->name('home');

Route::get('/games', [RandomGameController::class, 'search'])->name('games.search');
Route::post('/favorites/toggle', [RandomGameController::class, 'toggleFavorite'])->name('favorites.toggle');
Route::get('/random', [RandomGameController::class, 'random'])->name('games.random');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
