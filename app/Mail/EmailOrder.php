<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class EmailOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $sims;
    public $date;
    public $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $sims, $date, $admin = null)
    {
        $this->user = $user;
        $this->sims = $sims;
        $this->date = $date;
        $this->admin = $admin;
        $this->subject('STM New Sims / POS Order');
        $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-order');
    }
}
