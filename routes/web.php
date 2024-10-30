<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VRChatController;
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
// VRChat関係のルーティング
Route::controller(VRChatController::class)->group(function () {
    Route::get('/auth_2FA', 'auth_2FA')->name('auth_2FA');
    // Route::get('/auth_2FA_first', 'auth_2FA_first')->name('auth_2FA_first');
    // Route::post('/auth_2FA_second', 'auth_2FA_second')->name('auth_2FA_second');
    // Route::get('/getOneTimeCode', 'getOneTimeCode')->name('getOneTimeCode');
});

// ワールド関係のルーティング
Route::controller(WorldController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    // Route::get('/worlds', 'worlds')->name('worlds');
    Route::post('/worlds/search', 'search')->name('search');
    Route::get('/worlds/search', 'index')->name('index');
    Route::get('/worlds/{world_id}', 'world')->name('world');
});

// ユーザー関係のルーティング
Route::controller(UserController::class)->group(function () {
    // ユーザーページ表示
    Route::get('/users/{user_name}', 'userpage')->name('userpage');
});

Route::controller(UserController::class)->middleware(['auth'])->group(function () {
    // favorite編集
    Route::post('/users/{user_id}/favorite/{world_id}', 'toggle_favorite')->name('favorite.toggle');
    // Route::delete('/users/{user_id}/favorite/{world_id}', 'delete_favorite')->name('favorite.delete');
    // visited編集
    Route::post('/users/{user_id}/visited/{world_id}', 'toggle_visited')->name('visited.toggle');
    // Route::delete('/users/{user_id}/visited/{world_id}', 'delete_visited')->name('visited.delete');
});

// 口コミ関係のルーティング
Route::controller(ReviewController::class)->middleware(['auth'])->group(function () {
    // 口コミ作成
    Route::get('/reviews/{world_id}/create', 'create')->name('review.create');
    Route::post('/reviews', 'store')->name('review.store');

    // 各口コミ設定
    // Route::get('/reviews/{review_id}', 'show')->name('review.show');
    Route::get('/reviews/{world_id}/{review_id}/edit', 'edit')->name('review.edit');
    Route::put('/reviews/{review_id}', 'update')->name('review.update');
    Route::delete('/reviews/{review_id}', 'delete')->name('review.delete');
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

require __DIR__ . '/auth.php';
