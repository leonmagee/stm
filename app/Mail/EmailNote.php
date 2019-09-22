<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailNote extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $note;
    public $author;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $note = null, $author = null, $date = null)
    {
        $this->user = $user;
        $this->note = $note;
        $this->author = $author;
        $this->date = $date;
        $this->subject('New Note Added');
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
