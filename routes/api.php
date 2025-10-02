<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
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
});


// Middleware doesn't work here
// Route::group(['prefix' => 'v1'], function () {
//     #author routes
//     Route::group(['prefix' => 'authors'], function () {
//         Route::get('/', [AuthorController::class, 'index']);
//     });
// });

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum']], function () {
    // location routes
    Route::group(['prefix' => 'locations'], function () {
        Route::get('/', [LocationController::class, 'index']);
        Route::post('/', [LocationController::class, 'store']);
        Route::put('/{id}', [LocationController::class, 'update']);
    });

    // author routes
    Route::group(['prefix' => 'author'], function () {
        Route::get('/', [AuthorController::class, 'index']);
    });
});


// Route::group(['prefix' => 'v'], function () {
//     Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'master'], function () {});

//     Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'transaction'], function () {});

//     Route::group(['prefix' => 'department'], function () {});
// });


// http://localhost:8000/api/v1/master/authors...
// http://localhost:8000/api/v1/transaction/grn...
