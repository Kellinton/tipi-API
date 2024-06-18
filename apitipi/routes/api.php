<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Models\Instrutor;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('aluno', 'App\Http\Controllers\AlunoController');

Route::post('login', [AlunoController::class, 'login']);

Route::middleware(['auth:sanctum', 'aluno'])->group(function() {
    Route::apiResource('aluno', AlunoController::class);
    Route::get('/aluno/{id}/matricula', [AlunoController::class, 'getMatricula']);
    Route::get('/aluno/{id}/plano', [AlunoController::class, 'getPlano']);
    Route::get('/aluno/{id}/aula', [AlunoController::class, 'getAula']);
});

// Rota para funcionários (Instrutores)
Route::apiResource('funcionario', Instrutor::class);
