<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $info; 

    public function __construct($info)
    {
        $this->info = $info; 

    }

    public function build()
    {
        // return $this->subject('Mail from camara')->markdown('emails.contact-us');
        return $this->subject('Mail from camara')->markdown('emails.contact-us');
    }
}

