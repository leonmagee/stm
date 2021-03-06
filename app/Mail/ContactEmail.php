<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $admin;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, User $admin, $message)
    {
        $this->user = $user;
        $this->admin = $admin;
        $this->message = $message;
        $this->subject = 'STM Contact Form';
        $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-contact');
    }
}
