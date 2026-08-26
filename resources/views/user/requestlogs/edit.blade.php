<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Edit Request Log</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="/user/requestlogs"
               class="btn btn-sm btn-secondary">Request Logs</a>
            <a href="/user/requestlogs/{{ $requestlog->id }}"
               class="btn btn-sm btn-secondary">View Request Log</a>
        </div>
    </div>

    <br />

    <h2>{{ $requestlog->workorder_id }}</h2>

    <br />

    <div class="row">
        <div class="col-md-6">

            <form method="post"
                  action="{{ route('user.requestlogs.update', $requestlog->id) }}">
                @csrf
                @method('PATCH')

                @php
                    $options = [
                        'new' => 'new',
                        'incomplete' => 'incomplete',
                        'canceled' => 'canceled',
                        'completed' => 'completed',
                    ];
                @endphp
                <x-form.select name="status"
                               id="status"
                               label="Status"
                               :options="$options"
                               empty="-"
                               :default="old('status', $requestlog->status)" />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>
        </div>
    </div>

    <br />
    <br />

</x-user-layout>
