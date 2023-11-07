<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array<mixed>
     */
    public $data = [];

    /**
     * Create a new message instance.
     *
     * @param  array<mixed>  $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            to: $this->data['email'],
            from: config('custom.information_email'),
            subject: __('global.email.contact-us-thank-you'),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.contact-us-thank-you-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<mixed>
     */
    public function attachments()
    {
        return [];
    }
}
