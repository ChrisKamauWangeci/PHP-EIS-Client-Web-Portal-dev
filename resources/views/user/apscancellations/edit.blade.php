<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Edit Cancellation Request</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.apscancellations.index') }}"
               class="btn btn-sm btn-secondary">Cancellation Requests</a>
        </div>
    </div>

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>CancellationID</td>
            <td>{{ $apscancellation->CancellationID }}</td>
        </tr>
        <tr>
            <td>EISWorkOrderID</td>
            <td>{{ $apscancellation->EISWorkOrderID }}</td>
        </tr>
        <tr>
            <td>RequestID</td>
            <td>{{ $apscancellation->RequestID }}</td>
        </tr>
        <tr>
            <td>CompanyID</td>
            <td>{{ $apscancellation->CompanyID }}</td>
        </tr>
        <tr>
            <td>CompanyName</td>
            <td>{{ $apscancellation->CompanyName }}</td>
        </tr>
        <tr>
            <td>IsNotified</td>
            <td>{{ $apscancellation->IsNotified }}</td>
        </tr>
        <tr>
            <td>CancellationStatusID</td>
            <td>{{ $apscancellation->CancellationStatusID }}</td>
        </tr>
        <tr>
            <td>Username</td>
            <td>{{ $apscancellation->Username }}</td>
        </tr>
        <tr>
            <td>Requested Date UTC</td>
            <td>{{ $apscancellation->Inserted }}</td>
        </tr>
    </table>

    <br />

    <div class="row">
        <div class="col-md-6">

            <form method="post"
                  action="{{ route('user.apscancellations.update', $apscancellation->CancellationID) }}">
                @csrf
                @method('PATCH')

                <x-form.checkbox name="IsNotified"
                                 id="IsNotified"
                                 label="Is Notified"
                                 value="1"
                                 :checked="in_array(1, (array) old('IsNotified', $apscancellation->IsNotified ?? []))" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>
        </div>
    </div>

    <br />
    <br />

</x-user-layout>
