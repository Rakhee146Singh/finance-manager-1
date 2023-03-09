<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\FinancialYearController;
use App\Http\Controllers\V1\CompOffRequestController;
use App\Http\Controllers\V1\ExpenseRequestController;
use App\Http\Controllers\V1\LeaveTypeMasterController;

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


Route::prefix('V1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::controller(CompOffRequestController::class)->prefix('compoff')->group(function () {
            Route::post('/',  'list');
            Route::post('create', 'create');
            Route::get('get/{id}',  'get');
            Route::post('update/{id}', 'update');
            Route::post('delete/{id}', 'delete');
            Route::post('approval/{id}', 'approval');
        });
        Route::controller(ExpenseRequestController::class)->prefix('expense')->group(function () {
            Route::post('/',  'list');
            Route::post('create', 'create');
            Route::get('get/{id}',  'get');
            Route::post('update/{id}', 'update');
            Route::post('delete/{id}', 'delete');
            Route::post('approval/{id}', 'approval');
        });
        Route::controller(FinancialYearController::class)->prefix('finance')->group(function () {
            Route::post('/', 'list');
            Route::post('create', 'create');
            Route::get('show/{id}', 'show');
            Route::post('update/{id}', 'update');
            Route::post('delete/{id}', 'delete');
            Route::post('status/{id}', 'status');
        });

        Route::controller(LeaveTypeMasterController::class)->prefix('leave')->group(function () {
            Route::post('/', 'list');
            Route::post('create', 'create');
            Route::get('show/{id}', 'show');
            Route::post('update/{id}', 'update');
            Route::post('delete/{id}', 'delete');
            Route::post('status/{id}', 'status');
        });
    });
});
