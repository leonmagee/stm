<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailCredit extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $credit;
    public $type;
    public $account_id;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $credit, $type, $account_id, $date)
    {
        $this->user = $user;
        $this->credit = $credit;
        $this->type = $type;
        $this->account_id = $account_id;
        $this->date = $date;
        $this->subject('Credit Cash Out Request');
        $this->callbacks[] = (function ($message) use ($user) {$message->getHeaders()->addTextHeader('user_id', $user->id);});

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-credit');
    }
}
