<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;


// Rotas para lidar com requisições relacionadas aos jogos na API
Route::get('/api', [GameController::class, 'home']); // Rota para a página inicial
Route::get('/api/search/{query}', [GameController::class, 'search']); // Rota para busca de jogos
Route::get('/api/favorites', [GameController::class, 'favorites']); // Rota para jogos favoritos
Route::get('/api/game/{query}', [GameController::class, 'select']);

Route::post('/api/wishlist', [GameController::class, 'store']);

Route::get('/api/login', [UserController::class, 'index']);

Route::post('/api/register', [UserController::class, 'insert']);

Route::get('/try', function(){
    return view('register');
});

Route::get('/csrf-token', function() {
    return response()->json(['csrfToken' => csrf_token()]);
});
