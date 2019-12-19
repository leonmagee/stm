<?php

namespace App\Listeners;

use jdavidbakr\MailTracker\Events\PermanentBouncedMessageEvent;
use jdavidbakr\MailTracker\Model\SentEmail;

class BouncedEmail
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
     * @param  PermanentBouncedMessageEvent  $event
     * @return void
     */
    public function handle(PermanentBouncedMessageEvent $event)
    {
        // Access the email address using $event->email_address...
        if ($event->email_address) {
            $email = SentEmail::where('email_address', $event->email_address)->orderBy('id', 'DESC')->first();
            $email->bounced = 1;
            $email->save();
        }
        //\Log::notice('Email was bounced new');
        //$json_data = json_encode($event);
        //\Log::notice($json_data);
    }
}
