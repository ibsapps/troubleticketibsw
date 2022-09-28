<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public $subj_mail;
  public $sender;
  public $data;
  public $pic;
  public function __construct($subj_mail, $sender, $data, $pic)
  {
    //
    $this->subject = $subj_mail;
    $this->sender = $sender;
    $this->data = $data;
    $this->pic = $pic;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->from($this->sender, 'Support IT')->subject($this->subject)->view('emails.notification');
  }
}
