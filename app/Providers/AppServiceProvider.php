<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Cek apakah kita sedang menggunakan Tunnel (berdasarkan settingan .env)
        // Jika APP_URL di .env mengandung 'devtunnels', kita paksa ikut itu.
        if (str_contains(config('app.url'), 'devtunnels.ms')) {
            
            // 1. Paksa HTTPS (biar gembok aman & CSS muncul)
            URL::forceScheme('https');

            // 2. Paksa Root URL (biar redirect TIDAK balik ke localhost)
            // Ini akan memaksa Laravel memakai link https://pxqnsc... saat redirect
            URL::forceRootUrl(config('app.url'));
        }
    }
}
