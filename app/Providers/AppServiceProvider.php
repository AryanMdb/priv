<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        Response::macro('withCustomHeader', function ($value) {
            return Response::make('Custom Response with Header')
                ->header('ngrok-skip-browser-warning', 'any');
        });
        
    }
}
