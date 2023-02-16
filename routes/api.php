<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cars\CarsController;
use App\Http\Controllers\Client\Provider as ClientProviders;
use App\Http\Controllers\Client\Booking\BookingController as ClientBookingController;
use App\Http\Controllers\Provider\Services;
use App\Http\Controllers\Provider\StaffMembers as ProviderStaffMembers;
use App\Http\Controllers\Provider\ServiceCategories;
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


    Route::get('/providers/paginate', [ClientProviders::class, 'paginateProviders']);
    Route::get('/providers/cities', [ClientProviders::class, 'listCities']);
    Route::put('/', [ClientProviders::class, 'listCities']);

    Route::get('services-categories', [ServiceCategories::class, 'paginate']);
    Route::get('services/groupby/categories', [ServiceCategories::class, 'groupByCategory']);
    Route::get('services-categories/{category}', [ServiceCategories::class, 'getByCategory']);
        
    Route::middleware(['jwt.auth'])->group(function () {

        Route::prefix('cars')->name('cars.')->group(function () {
            Route::get('/my', [CarsController::class, 'myCars']); 
            Route::put('create', [CarsController::class, 'create']); 
            Route::post('edit/{car}', [CarsController::class, 'edit']); 
            Route::delete('delete/{car}', [CarsController::class, 'destroy']); 
        });
        
        Route::prefix('booking')->name('bkgs.')->group(function () {
            Route::put('client-create', [ClientBookingController::class, 'create']); 
        });

        Route::post('services/category/{category}', [ServiceCategories::class, 'update']);
        Route::delete('services/category/{category}', [ServiceCategories::class, 'delete']);

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

            // Route::get('services-paginate', [Services::class, 'paginateServices']);
            Route::put('services', [Services::class, 'createService']);
            Route::get('my-services', [Services::class, 'getMyServices']);
            Route::get('service-types', [Services::class, 'getServiceTypes']);
            Route::post('my-services/update', [Services::class, 'update']);
            
            // Route::get('services/{service}', [Services::class, 'getService']);
            // Route::delete('services/{service}', [Services::class, 'delete']);    
            
            Route::get('staff/paginate', [ProviderStaffMembers::class, 'paginateStaff']);
            Route::put('staff', [ProviderStaffMembers::class, 'storeMember']);
            Route::post('staff/{user}', [ProviderStaffMembers::class, 'updateMember']);
            Route::get('staff/{user}', [ProviderStaffMembers::class, 'getUser']);
            Route::delete('staff/{user}', [ProviderStaffMembers::class, 'delete']);
        
            Route::post('staff/toggle/service/{user}/{service}', [ProviderStaffMembers::class, 'toggleServiceType']);
            
            Route::post('toggle/service/{provider}/{service}', [Services::class, 'toggleServiceType']);
            Route::post('services/update/{serviceType}', [Services::class, 'updateService']);
            Route::post('services/toggleDisplay/{serviceType}', [Services::class, 'toggleDisplay']);
            // Route::delete('services/{serviceType}', [ProviderServices::class, 'destroyService']);
        });
    });
});





