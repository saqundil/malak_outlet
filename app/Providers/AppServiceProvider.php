<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register services for dependency injection
        $this->app->bind(\App\Services\ProductService::class, \App\Services\ProductService::class);
        $this->app->bind(\App\Services\DashboardService::class, \App\Services\DashboardService::class);
        $this->app->bind(\App\Services\ImageUploadService::class, \App\Services\ImageUploadService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191); // optional, for older MySQL versions
        
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        // Share categories with header component
        view()->composer('components.header', function ($view) {
            try {
                $categories = \App\Models\Category::where('is_active', true)->get();
                $view->with('categories', $categories);
            } catch (\Exception $e) {
                $view->with('categories', collect());
            }
        });
    }
}
