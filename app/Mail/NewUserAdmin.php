<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class NewUserAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $author;
    public $recipient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $author, $recipient)
    {
        $this->user = $user;
        $this->author = $author;
        $this->recipient = $recipient;
        $this->subject('STM - New User Added');
        $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new-user-admin');
    }
}
