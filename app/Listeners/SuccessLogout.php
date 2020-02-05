<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class SuccessLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = \Auth::user();
        //dd($user);
    }
}
