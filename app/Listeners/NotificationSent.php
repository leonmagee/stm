<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Str;

class NotificationSent
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
     * @param  object  $event
     * @return void
     */
    public function handle(MessageSending $event)
    {
        // Get Swift_Message obj
        $message = $event->message;

        // Get Message Headers
        $headers = $message->getHeaders();
        $ignore_array = ['Reset Password Notification'];
        if (in_array($headers->get('subject')->getValue('value'), $ignore_array)) {
            // Append custom header
            $headers->addTextHeader('X-No-Track', Str::random(10));
            //dd('headers updated');

        }
        // else {
        //     dd('vaue does not match');
        // }

        //dd($headers->get('subject')->getValue('value'));

    }
}
