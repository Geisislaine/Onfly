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
Route::post('/cadastro', [\App\Http\Controllers\UserController::class, 'salvar']);
Route::get('/email-unique/{email}', [\App\Http\Controllers\UserController::class, 'uniqueEmail']);


################# AUTH ################
Route::group([ 'middleware' => 'api', 'prefix' => 'auth' ], function () {
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});

################# DESPESAS ################
Route::group(['middleware' => 'jwtApi'], function () {

    Route::resource('despesas', DespesaController::class);
    Route::get('/despesas-por-user/{id}', [\App\Http\Controllers\DespesaController::class, "listarPorIdUser"]);
    Route::post('/despesas/update-arquivo/{id}', [\App\Http\Controllers\DespesaController::class, "salvarArquivo"]);


    //Route::prefix('despesas')->namespace('\\App\\Http\\Controllers\\')->group(function () {
    //    Route::get('/', [DespesaController::class, "listar"]);
    //    Route::get('/{id}', [DespesaController::class, "listarPorId"]);
    //    Route::delete('/{id}', [DespesaController::class, "deletar"]);
    //    Route::post('/', [DespesaController::class, "salvar"]);
    //    Route::post('/{id}', [DespesaController::class, "atualizar"]);
    //});
});
