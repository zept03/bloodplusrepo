<?php

namespace App\Listeners;

use App\Events\UsersTextBlasted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTextBlastNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UsersTextBlasted  $event
     * @return void
     */
    public function handle(UsersTextBlasted $event)
    {
        //
    }
}
