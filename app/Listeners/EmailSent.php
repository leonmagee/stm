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
        $matches = [];
        $header = preg_match('/user_id: ([0-9]*)/', $event->sent_email->headers, $matches);
        $email = SentEmail::find($event->sent_email->id);
        if ($header) {
            $number = intval($matches[1]);
            $user = User::find($number);
            if ($user) {
                if ($company = $user->company) {
                    $email->company = $company;
                    $email->email_address = $user->email;
                    $email->save();
                }
            }
        } else {
            $recipient = $event->sent_email->recipient;
            $email_matches = [];
            $email_match = preg_match('/<(.*)>/', $recipient, $email_matches);
            if ($email_match && isset($email_matches[1])) {
                $email->email_address = $email_matches[1];
                $email->save();
            }
        }

    }
}
