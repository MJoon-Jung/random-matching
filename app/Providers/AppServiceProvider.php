<?php

namespace App\Providers;

use App\Domains\Channel\Models\Channel;
use App\Domains\Channel\Observers\ChannelObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Channel::observe(ChannelObserver::class);
    }
}
