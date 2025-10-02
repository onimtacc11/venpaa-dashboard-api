<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });

    Route::prefix('locations')->group(function () {
        Route::get('/', [LocationController::class, 'index']);
        Route::post('/', [LocationController::class, 'store']);
        Route::get('/{loca_code}', [LocationController::class, 'show']);
        Route::put('/{loca_code}', [LocationController::class, 'update']);
        Route::get('/generate-code', [LocationController::class, 'generateCode']);
    });
});