<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyStatEmail extends Mailable
{
    use Queueable, SerializesModels;

    public array $counts;

    public string $startDate;

    public string $endDate;

    public function __construct(array $counts, string $startDate, string $endDate)
    {
        $this->counts = $counts;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function build(): self
    {
        return $this->subject("Daily Stats: {$this->startDate} - {$this->endDate}")
            ->view('emails.daily_stat');
    }
}
