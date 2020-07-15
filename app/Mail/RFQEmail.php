<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RFQEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $rfq;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rfq)
    {
        $this->rfq = $rfq;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('emails/rfq_status');
        return $this->to($this->rfq->to)->cc($this->rfq->cc)->bcc($this->rfq->bcc)
            ->subject('RFQ #' . $this->rfq->id . ' Notification');
    }
}
