<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Timecard;
use Illuminate\Http\Request;

class TimecardController extends Controller
{
    public function index()
    {
        $timecards = Timecard::query()
            ->where('contractor', session('user.contractor.C_Name'))
            ->latest()
            ->get();

        return view('user.timecards.index', compact('timecards'));
    }

    public function show(Timecard $timecard)
    {
        return view('user.timecards.show', compact('timecard'));
    }

    public function clockin(Request $request)
    {
        $contractor = session('user.contractor.C_Name');
        $workDate = now()->format('Y-m-d');

        $existing = Timecard::query()
            ->where('contractor', $contractor)
            ->orderBy('id', 'desc')
            ->first();

        if (! $existing->clock_out) {
            return back()->with('danger', 'You have not clocked out from your previous shift.');
        }

        $timecard = Timecard::create([
            'contractor' => $contractor,
            'work_date' => $workDate,
            'clock_in' => now(),
        ]);

        return back()->with('success', 'Clocked in successfully!');
    }

    public function clockout(Request $request)
    {
        $contractor = session('user.contractor.C_Name');
        $workDate = now()->format('Y-m-d');

        $timecard = Timecard::query()
            ->where('contractor', $contractor)
            ->where('work_date', $workDate)
            ->whereNotNull('clock_in')
            ->orderBy('id', 'desc')
            ->first();

        if (! $timecard) {
            return back()->with('danger', 'You have not clocked in.');
        }

        if ($timecard->clock_out) {
            return back()->with('danger', 'You have already clocked out.');
        }

        if ($timecard->break_start && ! $timecard->break_end) {
            return back()->with('danger', 'You must end your break before clocking out.');
        }

        $timecard->clock_out = now();
        $timecard->total_hours = $timecard->calculateTotalTime();
        $timecard->total_minutes = $timecard->calculateTotalTime(true);
        $timecard->save();

        return back()->with('success', 'Clocked out successfully!');
    }

    public function breakstart(Request $request)
    {
        $contractor = session('user.contractor.C_Name');
        $workDate = now()->format('Y-m-d');

        $timecard = Timecard::query()
            ->where('contractor', $contractor)
            ->where('work_date', $workDate)
            ->whereNotNull('clock_in')
            ->whereNull('clock_out')
            ->first();

        if (! $timecard) {
            return back()->with('danger', 'You must be clocked in to start a break.');
        }

        if ($timecard->break_start) {
            return back()->with('danger', 'You have already started a break.');
        }

        $timecard->break_start = now();
        $timecard->save();

        return back()->with('success', 'Break started successfully!');
    }

    public function breakend(Request $request)
    {
        $contractor = session('user.contractor.C_Name');
        $workDate = now()->format('Y-m-d');

        $timecard = Timecard::query()
            ->where('contractor', $contractor)
            ->where('work_date', $workDate)
            ->whereNotNull('break_start')
            ->first();

        if (! $timecard) {
            return back()->with('danger', 'You must start a break before ending it.');
        }

        if ($timecard->break_end) {
            return back()->with('danger', 'You have already ended your break.');
        }

        $timecard->break_end = now();
        $timecard->total_hours = $timecard->calculateTotalTime();
        $timecard->total_minutes = $timecard->calculateTotalTime(true);
        $timecard->save();

        return back()->with('success', 'Break ended successfully!');
    }

    public function store(Request $request) {}

    public function edit(Timecard $timecard) {}

    public function update(Request $request, Timecard $timecard) {}

    public function destroy(Timecard $timecard)
    {
        $timecard->delete();

        return back()->with('success', 'Timecard deleted successfully!');
    }
}
