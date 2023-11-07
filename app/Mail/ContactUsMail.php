<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * data
     *
     * @var array<mixed>
     */
    public array $data = [];

    /**
     * Create a new message instance.
     *
     * @param  array<mixed>  $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact-us')
            ->to(config('custom.contact_us_email'), config('custom.site_title'))
            ->subject(trans('global.email.contact-us'));
    }
}
