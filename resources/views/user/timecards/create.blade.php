<x-user-layout title="">

    <h1>Create Timecard</h1>

    <form method="POST" action="{{ route('user.timecards.store') }}">
        @csrf

        <label>Date</label>
        <input type="date" name="work_date" class="form-control" required>

        <label>Clock In</label>
        <input type="time" name="clock_in" class="form-control" required>

        <label>Break Start</label>
        <input type="time" name="break_start" class="form-control">

        <label>Break End</label>
        <input type="time" name="break_end" class="form-control">

        <label>Clock Out</label>
        <input type="time" name="clock_out" class="form-control" required>

        <button class="btn btn-primary mt-3">Save</button>
    </form>

    <br />
    <br />

</x-user-layout>