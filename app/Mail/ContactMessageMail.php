<?php

namespace App\Mail;

use App\Models\ContactUs;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
  use Queueable, SerializesModels;

  public $contactMessage;

  /**
   * Create a new message instance.
   */
  public function __construct(ContactUs $contactMessage)
  {
    $this->contactMessage = $contactMessage;
  }

  public function build()
  {
    return $this->from(config('mail.from.address'), config('mail.from.name'))
      ->subject('Mesaj nou de contact de la ' . $this->contactMessage->name)
      ->view('emails.contact-message')
      ->with([
        'contactMessage' => $this->contactMessage,
      ]);
  }
}