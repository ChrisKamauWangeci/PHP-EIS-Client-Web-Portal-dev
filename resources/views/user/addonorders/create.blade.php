<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h2>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }}
                {{ $workorder->W_LastName }}</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
            <a href="{{ route('user.addonorders.index') }}"
               class="btn btn-sm btn-secondary">View Addon Orders</a>
        </div>
    </div>

    <br />

    @if (!$addonorders->isEmpty())
        <span class="text-danger fw-bold">This workorder has already addonorders:</span>
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-auto">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Requestor</th>
                        <th>New Order Type</th>
                        <th>New Work Order ID</th>
                        <th>Gender</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($addonorders as $addonorder)
                        <tr>
                            <td>{{ $addonorder->id }}</td>
                            <td>{{ $addonorder->requestor }}</td>
                            <td>{{ $addonorder->newordertype }}</td>
                            <td>{{ $addonorder->newworkorder_id }}</td>
                            <td>{{ $addonorder->gender }}</td>
                            <td>{{ $addonorder->created }}</td>
                            <td>{{ $addonorder->Updated }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <br />

    @if ($addonorders->isEmpty())
        <div class="row">
            <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4">

                <h3>Create Addon Order</h3>

                <form method="post"
                      action="{{ route('user.addonorders.store') }}">
                    @csrf

                    <input type="hidden"
                           name="workorder_id"
                           value="{{ $workorder->W_WorkOrder }}" />
                    <br />

                    @php
                        $options = [
                            'ehr' => 'EHR',
                            'ehl' => 'EHL',
                        ];
                    @endphp
                    <x-form.select name="newordertype"
                                   label="New Order Type"
                                   id="newordertype"
                                   :options="$options"
                                   empty="-"
                                   :default="old('newordertype')"
                                   required />
                    <br />

                    @php
                        $options = [
                            'F' => 'F',
                            'M' => 'M',
                        ];
                    @endphp
                    <x-form.select name="gender"
                                   label="Gender"
                                   id="gender"
                                   :options="$options"
                                   empty=" "
                                   :default="old('gender', $workorder->W_Gender)" />
                    <br />

                    <x-form.button>Submit</x-form.button>
                </form>

            </div>
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
