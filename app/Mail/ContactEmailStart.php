<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ContactEmailStart extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $token)
    {
        //$this->email = $email;
        $this->subject = $subject;
        $this->token = $token;
        $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-contact-start');

    }
}
