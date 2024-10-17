<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorldController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;


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

// Route::get('/', function () {
//     return view('mainpage');
// });

// ワールド関係のルーティング
Route::controller(WorldController::class)->group(function(){
    Route::get('/', 'home')->name('home');
    Route::get('/auth_2FA_first', 'auth_2FA_first')->name('auth_2FA_first');
    Route::post('/auth_2FA_second', 'auth_2FA_second')->name('auth_2FA_second');
    Route::get('/world', 'world')->name('world');

});

// ユーザー関係のルーティング
Route::controller(UserController::class)->middleware(['auth'])->group(function(){
    // Route::get('/', 'index')->name('index');
});

// 口コミ関係のルーティング
Route::controller(ReviewController::class)->middleware(['auth'])->group(function(){
    // Route::get('/', 'index')->name('index');
});

// breeze由来のルーティング
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
