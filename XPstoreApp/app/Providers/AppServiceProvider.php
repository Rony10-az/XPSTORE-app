<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\InMemoryUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind repository interface to in-memory implementation for demo
        // Esto permite cambiar a Eloquent más adelante sin tocar la lógica.
        $this->app->bind(UserRepositoryInterface::class, InMemoryUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
