<?php

namespace App\Providers;


use App\Domains\Repository\Interface\RedisRepositoryInterface;
use App\Domains\Repository\RedisRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RedisRepositoryInterface::class, RedisRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
