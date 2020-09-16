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
    public $show_imei;
    //public $to;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $purchase, $header_text, $subject, $track = true, $show_imei = false, $track_user = false)
    {
        $this->user = $user;
        $this->purchase = $purchase;
        $this->header_text = $header_text;
        $this->subject = $subject;
        $this->show_imei = $show_imei;
        if (!$track_user) {
            $track_user = $user;
        }
        if ($track) {
            $this->callbacks[] = (function ($message) use ($track_user) {$message->getHeaders()->addTextHeader('user_id', $track_user->id);});
        } else {
            $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
        }
        //dd($this);
        //dd('test');
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
