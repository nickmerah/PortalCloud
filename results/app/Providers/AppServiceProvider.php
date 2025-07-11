<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $view->with([
                'schoolname' => 'DELTA STATE POLYTECHNIC, OGWASHI-UKU',
                'pageTitle'  => 'DELTA STATE POLYTECHNIC, OGWASHI-UKU .:: Result',
            ]);
        });
    }
}
