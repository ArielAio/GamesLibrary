<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

// Rotas para lidar com requisições relacionadas aos jogos na API
Route::get('/api', [GameController::class, 'home']); // Rota para a página inicial
Route::get('/api/search/{query}', [GameController::class, 'search']); // Rota para busca de jogos
Route::get('/api/favorites', [GameController::class, 'favorites']); // Rota para jogos favoritos
Route::get('/api/game/{slugGame}', [GameController::class, 'select']);
