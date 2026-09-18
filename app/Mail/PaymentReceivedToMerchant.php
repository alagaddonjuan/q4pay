<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceivedToMerchant extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;
    public $merchantName;

    /**
     * Create a new message instance.
     */
    public function __construct($transaction, $merchantName)
    {
        $this->transaction = (object) $transaction;
        $this->merchantName = $merchantName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Received: ₦' . number_format($this->transaction->amount, 2),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payments.merchant_notification',
            with: [
                'transaction' => $this->transaction,
                'merchantName' => $this->merchantName
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
