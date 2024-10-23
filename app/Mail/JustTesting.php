<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JustTesting extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function build()
{
    return $this->from('jdgenest19@gmail.com')
		        ->to('j.d.genest@hotmail.com')
                   ->subject('Auf Wiedersehen')
                   ->view('mail.test');
                  
    }
}
