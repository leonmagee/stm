<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailBlast extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $message;
    public $hello;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
        $message = null,
        $subject = 'Sim Track Manager',
        $file = null,
        $file2 = null,
        $file3 = null,
        $width = null,
        $hello = null
    ) {
        $this->user = $user;
        $this->message = $message;
        $this->subject($subject);
        $this->hello = $hello;
        if ($file) {
            $this->attach($file->path(), [
                'as' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
            ]);
        }
        if ($file2) {
            $this->attach($file2->path(), [
                'as' => $file2->getClientOriginalName(),
                'mime' => $file2->getMimeType(),
            ]);
        }
        if ($file3) {
            $this->attach($file3->path(), [
                'as' => $file3->getClientOriginalName(),
                'mime' => $file3->getMimeType(),
            ]);
        }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-blast');
    }
}
