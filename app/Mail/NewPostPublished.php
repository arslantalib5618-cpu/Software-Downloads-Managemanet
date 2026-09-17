<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPostPublished extends Mailable
{
    use Queueable, SerializesModels;

    public $software;

    public function __construct($software)
    {
        $this->software = $software;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Software Published',
        );
    }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.new-post',
        );
    }


    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}