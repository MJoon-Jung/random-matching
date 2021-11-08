<?php

namespace App\Providers;

use App\Domains\Matching\Repository\Interface\MatchingRepositoryInterface;
use App\Domains\Matching\Repository\MatchingRepository;
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
        $this->app->bind(MatchingRepositoryInterface::class, MatchingRepository::class);
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
