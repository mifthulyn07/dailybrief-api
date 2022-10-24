<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AbsensiController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->namespace('Auth')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::get('profil', [AuthController::class, 'profil']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::prefix('user')->group(function(){
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{user}', [UserController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/{user}', [UserController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{user}', [UserController::class, 'destroy'])->where('id', '[0-9]+');
    });

    Route::prefix('absensi')->group(function(){
        Route::get('/', [AbsensiController::class, 'index']);
        Route::get('/history-absen', [AbsensiController::class, 'historyAbsen']);
        Route::post('/absen-masuk', [AbsensiController::class, 'absenMasuk']);
        Route::post('/absen-pulang/{id}', [AbsensiController::class, 'absenPulang']);
    });
});

