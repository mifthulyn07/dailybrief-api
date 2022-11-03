<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AbsensiController;
use App\Http\Controllers\API\ManagementReportController;

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
        Route::get('/profil', [AuthController::class, 'profil']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::prefix('user')->group(function(){
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('absensi')->group(function(){
        Route::get('/', [AbsensiController::class, 'index']);
        Route::get('/history-absen', [AbsensiController::class, 'historyAbsen']);
        Route::get('/show/{id}', [AbsensiController::class, 'show']);
        Route::post('/absen-masuk', [AbsensiController::class, 'absenMasuk']);
        Route::post('/absen-pulang/{id}', [AbsensiController::class, 'absenPulang']);
    });

    Route::prefix('management-report')->group(function(){
        Route::get('/', [ManagementReportController::class, 'index']);
        Route::post('/', [ManagementReportController::class, 'store']);
        Route::get('/{id}', [ManagementReportController::class, 'show']);
        Route::post('/{id}', [ManagementReportController::class, 'update']);
        Route::delete('/{id}', [ManagementReportController::class, 'destroy']);
    });
});

