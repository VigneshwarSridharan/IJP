<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use \TCG\Voyager\Events\BreadDataUpdated;
use \TCG\Voyager\Events\BreadDataAdded;
use App\Listeners\PostUpdateListener;
use App\Listeners\UserUpdateListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BreadDataUpdated::class => [
            PostUpdateListener::class,
            UserUpdateListener::class,
        ],
        BreadDataAdded::class => [
            UserUpdateListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
