<?php

namespace App\Providers;

use App\Models\Contract;
use App\Repositories\Contract\ContractRepo;
use App\Repositories\Contract\ContractRepoInterface;
use App\Services\ContractService;
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

        // $this->app->bind(ContractService::class, function ($app) {
        //     return new ContractService(new ContractRepo(new Contract()));
        // });
    }
}
