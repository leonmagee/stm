<?php

namespace App\Mail;

use App\Invoice;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $invoice;
    public $subtotal;
    public $discount;
    public $total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Invoice $invoice, $subtotal, $discount, $total, $admin, $recipient)
    {
        $this->user = $user;
        $this->invoice = $invoice;
        $this->subtotal = $subtotal;
        $this->discount = $discount;
        $this->total = $total;
        $this->subject('INVOICE #' . $invoice->id);
        if ($admin) {
            $this->callbacks[] = (function ($message) {$message->getHeaders()->addTextHeader('X-No-Track', Str::random(10));});
        } else {
            if ($recipient) {
                $this->callbacks[] = (function ($message) use ($recipient) {$message->getHeaders()->addTextHeader('user_id', $recipient->id);});
            }
        }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email-invoice');
    }
}
