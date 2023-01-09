<?php

use App\Http\Controllers\Api\ProdutoApiController;
use App\Http\Controllers\Api\UsuarioApiController;
use App\Http\Controllers\Api\VendaApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UsuarioApiController::class);
Route::apiResource('produtos', ProdutoApiController::class);
Route::POST('filtro', [ProdutoApiController::class, 'filtro']);
Route::POST('produtos/{id}/vendas', [VendaApiController::class, 'vendas']);
Route::GET('vendas', [VendaApiController::class, 'indexVendas']); 

