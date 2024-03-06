<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GameMasterController;
use App\Http\Controllers\Admin\GameSystemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PromotionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        Route::resource('game_master', GameMasterController::class);

        // Promotions
        Route::get('/promotions/new', [PromotionController::class, 'create'])->name('promotions.create');
        Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
    });

Route::middleware('auth')->group(function () {
    Route::get('/game_systems', [GameSystemController::class, 'index'])->name('game_systems.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
