<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Provider\Services as ProviderServices;
use App\Http\Controllers\Provider\StaffMembers as ProviderStaffMembers;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Provider\PhotosGallery as ProviderPhotosGallery;

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
            Route::post('me', [AuthController::class, 'updateUser']);
            Route::delete('me', [AuthController::class, 'destroyUser']);
        });

        Route::post('upload', [FileUploadController::class, 'upload']);

        Route::prefix('provider')->name('provider.')->group(function () {
            Route::post('/', [AuthController::class, 'updateProvider']);

            Route::get('/photo-gallery', [ProviderPhotosGallery::class, 'getPhotos']);
            Route::delete('/photo-gallery/{photo}', [ProviderPhotosGallery::class, 'remove']);

            Route::get('services', [ProviderServices::class, 'getProviderServices']);
            Route::post('services', [ProviderServices::class, 'createService']);
            Route::post('toggleServiceType/{user}/{service}', [ProviderServices::class, 'createService']);

            Route::put('staff', [ProviderStaffMembers::class, 'storeMember']);
            Route::post('staff/{user}', [ProviderStaffMembers::class, 'updateMember']);
            Route::get('staff/{user}', [ProviderStaffMembers::class, 'getUser']);
            Route::get('staff/paginate', [ProviderStaffMembers::class, 'paginateStaff']);

            Route::post('staff/toggle/service/{user}/{service}', [ProviderStaffMembers::class, 'toggleServiceType']);


            Route::post('services/update/{serviceType}', [ProviderServices::class, 'updateService']);
            Route::post('services/toggleDisplay/{serviceType}', [ProviderServices::class, 'toggleDisplay']);
            Route::delete('services/{serviceType}', [ProviderServices::class, 'destroyService']);
        });
    });
});





