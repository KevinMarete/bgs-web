<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BusinessMetricsEmail extends Mailable
{
  use Queueable, SerializesModels;
  public $metric;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($metric)
  {
    $this->metric = $metric;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $this->view('emails/business_metrics');
    return $this->bcc($this->metric->email)
      ->subject(config('app.label').' Business Metrics # ' . $this->metric->date);
  }
}
