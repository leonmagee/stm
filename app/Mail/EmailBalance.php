<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailBalance extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $previous;
    public $difference;
    public $current;
    public $note;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $previous, $difference, $current, $note, $date)
    {
        $this->user = $user;
        $this->previous = $previous;
        $this->difference = $difference;
        $this->current = $current;
        $this->note = $note;
        $this->date = $date;
        $this->subject('Transaction Balance Update');
        $this->callbacks[] = (function ($message) use ($user) {$message->getHeaders()->addTextHeader('user_id', $user->id);});

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-balance');
    }
}
