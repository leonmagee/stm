<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $purchase;
    public $header_text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $purchase, $header_text, $subject)
    {
        $this->user = $user;
        $this->purchase = $purchase;
        $this->header_text = $header_text;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-purchase');
    }
}
