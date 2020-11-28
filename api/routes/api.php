<?php

use App\Http\Controllers\DespesaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

################# CADASTRO ################

################# USER ################

################# DESPESAS ################
Route::prefix('despesas')->namespace('\\App\\Http\\Controllers\\')->group(function () {
    Route::get('/', [DespesaController::class, "listar"]);
    Route::get('/{id}', [DespesaController::class, "listarPorId"]);
    Route::delete('/{id}', [DespesaController::class, "deletar"]);
    Route::post('/', [DespesaController::class, "salvar"]);
    Route::put('/{id}', [DespesaController::class, "atualizar"]);
});
