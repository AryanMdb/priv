<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactUs;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactUs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactUs $contactUs)
    {
        $this->contactUs = $contactUs;
    }


    public function build()
    {
        return $this->view('emails.contact-us')
            ->subject('New Contact Us Submission');
    }
}
