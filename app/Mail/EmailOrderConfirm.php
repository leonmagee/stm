<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailOrderConfirm extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $sims;
    public $carrier;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $sims, $carrier, $date)
    {
        $this->user = $user;
        $this->sims = $sims;
        $this->carrier = $carrier;
        $this->date = $date;
        $this->subject('STM New Sims Order');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-order-confirm');
    }
}
