<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::name('api.')->group(static function () {

    Route::post('/register/provider', [AuthController::class, 'registerProvider']);
    Route::post('/register/client', [AuthController::class, 'registerClient']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::any('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/password/email', [AuthController::class, 'sendResetLinkEmail']);
    Route::post('/auth/password/reset', [AuthController::class, 'reset']);

    Route::middleware(['jwt.auth'])->group(function () {
        Route::get('/user/me', [AuthController::class, 'me']);
    });
});





