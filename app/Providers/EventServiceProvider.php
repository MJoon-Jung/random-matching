<?php

namespace App\Providers;

use App\Domains\Channel\Events\ChatMessage;
use App\Domains\Channel\Events\NewChannelEvent;
use App\Domains\Channel\Listeners\ChatNotification;
use App\Domains\Channel\Listeners\NewChannelNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [SendEmailVerificationNotification::class],
        ChatMessage::class => [ChatNotification::class],
        NewChannelEvent::class => [NewChannelNotification::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
