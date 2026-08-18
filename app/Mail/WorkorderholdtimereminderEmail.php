<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WorkorderholdtimereminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->data['from'], 'Express Imaging Services'),
            subject: $this->data['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->data['view'],
            with: [
                'data' => $this->data['data'],
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
