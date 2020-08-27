<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class UserUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $old_user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, User $old_user)
    {
        $this->user = $user;
        $this->old_user = $old_user;
        $this->subject('STM - User Details Update');
        $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user-update');
    }
}
