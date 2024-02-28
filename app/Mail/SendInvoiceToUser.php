<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
class SendInvoiceToUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $path,$customer_name;
    /**
     * Create a new message instance.
     */
    public function __construct($path,$customer_name)
    {
        //
        $this->path= $path['path'];
        $this->customer_name= $customer_name['customer_name'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Invoice To User',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view:'Admin.invoice',
            with:['customer_name'=>$this->customer_name],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->path)
            ->as('order.pdf')
            ->withMime('application/pdf'),
        ];
    }
}
