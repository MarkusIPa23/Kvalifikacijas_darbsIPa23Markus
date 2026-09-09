<?php

use App\Http\Controllers\RandomGameController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/random', RandomGameController::class);
