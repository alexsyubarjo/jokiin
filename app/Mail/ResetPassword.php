<?php

namespace App\Mail;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    public function build()
    {
        $w = Website::where("key", "main")->first();
        $s = Website::where("key", "socials")->first();

        $data["web"] = $w ? json_decode($w->value, false) : null;
        $data["soc"] = $s ? json_decode($s->value, false) : null;

        return $this->view("emails.reset-password", $data);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: "Reset Password");
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(view: "view.name");
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
