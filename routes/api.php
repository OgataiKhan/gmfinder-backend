<?php

use App\Http\Controllers\Api\GameMasterController;
use App\Http\Controllers\Api\GameSystemController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\Payments\PaymentController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ReviewController;
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
Route::get('/game_masters/{slug}', [GameMasterController::class, 'show']);
Route::get('game_systems', [GameSystemController::class, 'index']);
Route::get('payments/generate',[PaymentController::class, 'generate']);

Route::post('messages', [MessageController::class, 'store']);
Route::post('ratings', [RatingController::class, 'store']);
Route::post('reviews', [ReviewController::class, 'store']);
Route::post('payments/make/payment',[PaymentController::class, 'makePayment'])->name('api.makePayment');
