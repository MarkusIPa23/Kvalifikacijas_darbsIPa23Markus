<?php

use App\Http\Controllers\GameCommentController;
use App\Http\Controllers\GameRatingController;
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

Route::get('/future', function () {
    return view('future.index');
})->name('future');

Route::get('/future/hybrid', function () {
    return view('future.hybrid');
})->name('future.hybrid');

Route::get('/future/random', function () {
    return view('future.random');
})->name('future.random');

Route::get('/future/comparison', function () {
    return view('future.comparison');
})->name('future.comparison');

Route::get('/future/matches', function () {
    return view('future.matches');
})->name('future.matches');

Route::get('/future/tournament', function () {
    return view('future.tournament');
})->name('future.tournament');

Route::get('/games', [RandomGameController::class, 'search'])->name('games.search');
Route::get('/future/games', [RandomGameController::class, 'futureGames'])
    ->middleware('throttle:60,1')
    ->name('future.games');
Route::get('/games/{gameId}', [RandomGameController::class, 'show'])
    ->whereNumber('gameId')
    ->name('games.show');
Route::post('/games/{gameId}/comments', [GameCommentController::class, 'store'])
    ->middleware('auth')
    ->name('games.comments.store');
Route::post('/games/{gameId}/ratings', [GameRatingController::class, 'store'])
    ->middleware('auth')
    ->name('games.ratings.store');
Route::post('/favorites/toggle', [RandomGameController::class, 'toggleFavorite'])->name('favorites.toggle');
Route::get('/random', [RandomGameController::class, 'random'])->name('games.random');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
