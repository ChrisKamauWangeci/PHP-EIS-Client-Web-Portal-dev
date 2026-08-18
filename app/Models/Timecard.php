<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timecard extends Model
{
    protected $connection = 'eisuat';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'work_date' => 'date',
            'clock_in' => 'datetime',
            'clock_out' => 'datetime',
            'break_start' => 'datetime',
            'break_end' => 'datetime',
        ];
    }

    public function calculateTotalTime($inMinutes = false)
    {
        if (! $this->clock_in || ! $this->clock_out) {
            return 0;
        }

        if ($this->clock_out->lt($this->clock_in)) {
            return 0;
        }

        $totalMinutes = $this->clock_in->diffInMinutes($this->clock_out);

        if ($this->break_start && $this->break_end && $this->break_end->gt($this->break_start)) {
            $totalMinutes -= $this->break_start->diffInMinutes($this->break_end);
        }

        $totalMinutes = max($totalMinutes, 0);

        return $inMinutes ? round($totalMinutes) : round($totalMinutes / 60, 2);
    }
}
