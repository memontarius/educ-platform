<?php

namespace App\Providers;

use App\Common\ResponseBuilder;
use App\Services\ModelService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        ModelService::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ResponseBuilder::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
