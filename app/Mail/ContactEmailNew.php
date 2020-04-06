<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ContactEmailNew extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $name;
    public $business;
    public $email;
    public $phone;
    public $message;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $admin, $name, $business, $email, $phone, $message)
    {
        $this->admin = $admin;
        $this->name = $name;
        $this->business = $business;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
        $date = \Carbon\Carbon::now()->format('F j, Y');
        $this->date = $date;
        $this->subject = 'Contact Form Submission';
        $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-contact-new');
    }
}
