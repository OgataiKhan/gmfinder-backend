<?php

use App\Http\Controllers\Api\GameMasterController;
use App\Http\Controllers\Api\GameSystemrController;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::get('game_masters', [GameMasterController::class, 'index']);
Route::get('/game_masters/{id}',[GameMasterController::class,'show']);
Route::get('game_systems', [GameSystemrController::class, 'index']);
