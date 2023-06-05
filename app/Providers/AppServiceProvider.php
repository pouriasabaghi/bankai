<?php

namespace App\Providers;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength('190');
        Paginator::useBootstrap();

        View::composer('admin.layouts.template.navbar', function($view){

            $data = [
                'notifications'=> DatabaseNotification::all(),
            ];
            $view->with($data);
        });
    }
}
