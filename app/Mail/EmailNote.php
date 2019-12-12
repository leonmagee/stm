<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class EmailNote extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $note;
    public $author;
    public $date;
    public $agent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $note = null, $author = null, $date = null, $agent = null)
    {
        $this->user = $user;
        $this->note = $note;
        $this->author = $author;
        $this->date = $date;
        $this->agent = $agent;
        $this->subject('New Note Added');
        $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
        //$this->getSwiftMessage()->getHeaders()->addTextHeader('x-mailgun-native-send', 'true');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-note');
    }
}
