<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailTesting extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private string $name)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mail Testing',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.test-mail',
            with: ['name' => $this->name]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
