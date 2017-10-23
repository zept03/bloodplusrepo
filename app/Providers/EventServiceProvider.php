<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UsersTextBlasted' => [
            'App\Listeners\SendTextBlastNotification',
        ],
        'App\Events\UserTexted' => [
            'App\Listeners\UserSendSMS',
        ],
        'App\Events\DonorsTextBlasted' => [
            'App\Listeners\DonorsTextBlastNotification',
        ],
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
