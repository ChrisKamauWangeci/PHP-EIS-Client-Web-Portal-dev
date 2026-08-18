<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Emailer extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {

        $sender = $this->data['sender'] ?? 'info@expressimagingservices.com';

        return new Envelope(
            from: new Address($sender, 'Express Imaging Services'),
            subject: $this->data['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.emailer',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        // Support multiple attachments via 'attachments' array
        if (isset($this->data['attachments']) && is_array($this->data['attachments'])) {
            foreach ($this->data['attachments'] as $path) {
                $attachments[] = Attachment::fromPath($path);
            }
        }

        // Support single attachment via 'attachment' (backward compatibility)
        if (isset($this->data['attachment'])) {
            $attachments[] = Attachment::fromPath($this->data['attachment']);
        }

        return $attachments;
    }
}
