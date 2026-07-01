<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. Tambahkan baris ini

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
        // // 2. Tambahkan baris ini agar semua CSS/JS menggunakan HTTPS
        // if (env('APP_ENV') !== 'local' || request()->header('x-forwarded-proto') === 'https') {
        //      URL::forceScheme('https');
        // }

        // // Atau untuk cara yang lebih agresif saat pakai Ngrok, cukup gunakan 1 baris ini saja:
        // URL::forceScheme('https');

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
