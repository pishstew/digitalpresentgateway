<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
     public function boot(): void
    {
        // Force HTTPS di production (Railway)
        // Ini fix Mixed Content error: asset() akan generate https:// bukan http://
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
}

}
