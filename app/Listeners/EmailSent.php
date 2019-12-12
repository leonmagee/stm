<?php

namespace App\Listeners;

use App\User;
use jdavidbakr\MailTracker\Events\EmailSentEvent;
use jdavidbakr\MailTracker\Model\SentEmail;

class EmailSent
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
     * @param  ViewEmailEvent  $event
     * @return void
     */
    public function handle(EmailSentEvent $event)
    {
        // Access the model using $event->sent_email...
        $matches = [];
        $header = preg_match('/user_id: [0-9]*/', $event->sent_email->headers, $matches);
        if ($header) {
            $number = intval(str_replace('user_id: ', '', $matches[0]));
            $user = User::find($number);
            $email = SentEmail::find($event->sent_email->id);
            if ($company = $user->company) {
                $email->company = $company;
                $email->save();
            }
        }
    }
}
