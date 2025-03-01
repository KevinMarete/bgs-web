<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OffersEmail extends Mailable
{
  use Queueable, SerializesModels;
  public $mailing_list;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($mailing_list)
  {
    $this->mailing_list = $mailing_list;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $this->view('emails/offers_mailing_list');
    return $this->bcc($this->mailing_list->email)
      ->subject(config('app.label').' Offers # ' . $this->mailing_list->date);
  }
}
