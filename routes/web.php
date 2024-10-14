<?php

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
    Route::post('/auth', 'auth')->name('auth');
});

// ユーザー関係のルーティング
Route::controller(UserController::class)->group(function(){
    // Route::get('/', 'index')->name('index');
});

// 口コミ関係のルーティング
Route::controller(ReviewController::class)->group(function(){
    // Route::get('/', 'index')->name('index');
});