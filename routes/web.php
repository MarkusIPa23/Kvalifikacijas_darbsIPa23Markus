<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RandomGameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function (\Illuminate\Http\Request $request) {
    return view('welcome', [
        'favoriteGames' => array_values($request->session()->get('favorite_games', [])),
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
