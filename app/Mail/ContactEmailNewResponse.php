<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ContactEmailNewResponse extends Mailable
{
    use Queueable, SerializesModels;

    // public $admin;
    // public $business;
    // public $email;
    // public $phone;
    // public $message;
    // public $date;
    public $name;
    public $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    //public function __construct(User $admin, $business, $email, $phone, $message)
    public function __construct($text, $name, $subject)
    {
        // $this->admin = $admin;
        // $this->business = $business;
        // $this->email = $email;
        // $this->phone = $phone;
        // $this->message = $message;
        // $date = \Carbon\Carbon::now()->format('F j, Y');
        // $this->date = $date;
        $this->name = $name;
        $this->text = $text;
        $this->subject = $subject;
        $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-contact-new-response');
    }
}
