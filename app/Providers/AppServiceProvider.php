<?php

namespace App\Providers;

use Illuminate\Support\Facades\{Auth, Blade};
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register () {
        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->is_admin;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot () {
        Builder::defaultStringLength(191); // Update defaultStringLength
    }
}
