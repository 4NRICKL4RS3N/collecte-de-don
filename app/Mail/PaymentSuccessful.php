<?php

namespace App\Mail;

use App\Models\Donation;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessful extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private Donation $donation, private Payment $payment)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Merci pour votre don!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-successful',
            with: [
                'donation' => $this->donation,
                'payment' => $this->payment
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
