<?php

use App\Http\Controllers\GameCommentController;
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
Route::post('/games/{gameId}/comments', [GameCommentController::class, 'store'])
    ->middleware('auth')
    ->name('games.comments.store');
Route::post('/favorites/toggle', [RandomGameController::class, 'toggleFavorite'])->name('favorites.toggle');
Route::get('/random', [RandomGameController::class, 'random'])->name('games.random');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
