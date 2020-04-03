<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class EmailBalance extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $previous;
    public $difference;
    public $current;
    public $note;
    public $date;
    public $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $previous, $difference, $current, $note, $date, $admin = false)
    {
        $this->user = $user;
        $this->previous = $previous;
        $this->difference = $difference;
        $this->current = $current;
        $this->note = $note;
        $this->date = $date;
        $this->admin = $admin;
        $this->subject('Credit Balance Update');
        if ($admin) {
            $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
        } else {
            $this->callbacks[] = (function ($message) use ($user) {$message->getHeaders()->addTextHeader('user_id', $user->id);});
        }
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
