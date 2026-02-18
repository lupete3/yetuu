<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
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
        // Partager les paramètres à toutes les vues
        View::composer('*', function ($view) {
            $settings = Setting::all()->pluck('value', 'key')->toArray();
            $view->with('settings', $settings);
        });

        Paginator::useBootstrap();

    }
}
