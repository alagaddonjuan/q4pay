<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptToCustomer extends Mailable implements ShouldQueue
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
            subject: 'Payment Receipt: ' . $this->merchantName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payments.customer_receipt',
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
