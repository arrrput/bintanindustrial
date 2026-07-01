<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminContactNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    public function build()
    {
        return $this->subject('Pesan Baru dari Website BIIE: ' . $this->contactData['subject'])
                    ->replyTo($this->contactData['email'], $this->contactData['name'])
                    ->view('Emails.contact');
    }
}