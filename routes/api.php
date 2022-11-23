<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Provider\Services as ProviderServices;

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

        Route::prefix('user')->name('users.')->group(function () {
            Route::get('me', [AuthController::class, 'me']);
//            Route::post('me', [AuthController::class, 'updateUser']);
        });

        // Route::post('uploadFile', [AuthController::class, 'uploadFile']);
        Route::prefix('provider')->name('provider.')->group(function () {
            Route::get('services', [ProviderServices::class, 'getProviderServices']);
//            Route::post('services', [ProviderServices::class, 'getProviderServices']);
        });
    });
});





