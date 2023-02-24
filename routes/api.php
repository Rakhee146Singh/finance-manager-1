<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\CompOffRequestController;
use App\Http\Controllers\v1\ExpenceRequestController;

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


Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::controller(CompOffRequestController::class)->prefix('compoff')->group(function () {
            Route::post('list',  'list');
            Route::post('create', 'create');
            Route::get('view/{id}',  'view');
            Route::post('update/{id}', 'update');
            Route::post('delete/{id}', 'delete');
            Route::post('approval/{id}', 'approval');
        });
        Route::controller(ExpenceRequestController::class)->prefix('expence')->group(function () {
            Route::post('list',  'list');
            Route::post('create', 'create');
            Route::get('view/{id}',  'view');
            Route::post('update/{id}', 'update');
            Route::post('delete/{id}', 'delete');
            Route::post('approval/{id}', 'approval');
        });
    });
});
