<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Crée une nouvelle instance du message.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Construit le message.
     */
    public function build()
    {
        return $this->subject('Nouveau message de contact')
                    ->view('emails.contact-form')
                    ->with(['data' => $this->data]);
    }
}