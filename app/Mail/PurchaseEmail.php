<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

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
    public function __construct($user, $purchase, $header_text, $subject, $track = true)
    {
        $this->user = $user;
        $this->purchase = $purchase;
        $this->header_text = $header_text;
        $this->subject = $subject;
        if ($track) {
            $this->callbacks[] = (function ($message) use ($user) {$message->getHeaders()->addTextHeader('user_id', $user->id);});
        } else {
            $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
        }
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
