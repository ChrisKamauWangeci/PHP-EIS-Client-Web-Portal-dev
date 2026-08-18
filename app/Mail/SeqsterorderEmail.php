<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SeqsterorderEmail extends Mailable
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
                'seqsterorder' => $this->data['seqsterorder'],
                'ehrworkorder' => $this->data['ehrworkorder'],
                'hospitalraw' => $this->data['hospitalraw'],
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
