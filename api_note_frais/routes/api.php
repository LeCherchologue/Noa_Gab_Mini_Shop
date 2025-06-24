<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/premiere-connexion', [App\Http\Controllers\AuthController::class, 'index']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);


Route::get('/tests', [App\Http\Controllers\TestController::class, 'index']);
Route::post('/tests', [App\Http\Controllers\TestController::class, 'store']);
Route::get('/tests/{id}', [App\Http\Controllers\TestController::class, 'show']);
Route::post('/tests/{id}/update', [App\Http\Controllers\TestController::class, 'update']);
Route::post('/tests/{id}/destroy', [App\Http\Controllers\TestController::class, 'destroy']);
Route::post('/tests/destroy-group', [App\Http\Controllers\TestController::class, 'destroy_group']);


Route::get('/personnes', [App\Http\Controllers\PersonneController::class, 'index']);
Route::post('/personnes', [App\Http\Controllers\PersonneController::class, 'store']);
Route::get('/personnes/{id}', [App\Http\Controllers\PersonneController::class, 'show']);
Route::post('/personnes/{id}/update', [App\Http\Controllers\PersonneController::class, 'update']);
Route::post('/personnes/{id}/destroy', [App\Http\Controllers\PersonneController::class, 'destroy']);
Route::post('/personnes/destroy-group', [App\Http\Controllers\PersonneController::class, 'destroy_group']);


Route::get('/frais', [App\Http\Controllers\FraiController::class, 'index']);
Route::post('/frais', [App\Http\Controllers\FraiController::class, 'store']);
Route::get('/frais/{id}', [App\Http\Controllers\FraiController::class, 'show']);
Route::post('/frais/{id}/update', [App\Http\Controllers\FraiController::class, 'update']);
Route::post('/frais/{id}/destroy', [App\Http\Controllers\FraiController::class, 'destroy']);
Route::post('/frais/destroy-group', [App\Http\Controllers\FraiController::class, 'destroy_group']);

Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
Route::post('/users', [App\Http\Controllers\UserController::class, 'store']);
Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show']);
Route::post('/users/{id}/reset-password', [App\Http\Controllers\UserController::class, 'reset_password']);
Route::post('/users/{id}/update', [App\Http\Controllers\UserController::class, 'update']);
Route::post('/users/{id}/destroy', [App\Http\Controllers\UserController::class, 'destroy']);
Route::post('/users/destroy-group', [App\Http\Controllers\UserController::class, 'destroy_group']);
