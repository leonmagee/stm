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
    public $ads_array;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
        $message = null,
        $subject = 'GS Wireless',
        $file = null,
        $file2 = null,
        $file3 = null,
        $file4 = null,
        $width = null,
        $hello = null,
        $ads_array = null
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
        if ($file4) {
            $this->attach($file4->path(), [
                'as' => $file4->getClientOriginalName(),
                'mime' => $file4->getMimeType(),
            ]);
        }

        $this->ads_array = $ads_array;

        $this->callbacks[] = (function ($message) use ($user) {$message->getHeaders()->addTextHeader('user_id', $user->id);});

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
