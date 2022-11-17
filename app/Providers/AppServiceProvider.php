<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\EncryptHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register SD CMS encrypt helper
        $this->app->singleton('SdCmsEncryptHelper', function ($app) {
            return new EncryptHelper(
                config('services.sdcms_encrypt.salt_length'),
                config('services.sdcms_encrypt.algorithm'),
                config('services.sdcms_encrypt.iterations'),
                config('services.sdcms_encrypt.key_length')
            );
        });
    }
}
