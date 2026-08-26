<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h2>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }}
                {{ $workorder->W_LastName }}</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
            <a href="{{ route('user.workorderdetails.index') }}"
               class="btn btn-sm btn-secondary">View Workorder Details</a>
        </div>
    </div>

    <br />

    @if (!$workorderdetails->isEmpty())
        <span class="text-danger fw-bold">This workorder has already workorderdetails:</span>
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-auto">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Workorder</th>
                        <th>Requestor Role</th>
                        <th>Created</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workorderdetails as $workorderdetail)
                        <tr>
                            <td>{{ $workorderdetail->id }}</td>
                            <td>{{ $workorderdetail->workorder_id }}</td>
                            <td>{{ $workorderdetail->requestorrole }}</td>
                            <td>{{ $workorderdetail->created_at }}</td>
                            <td>{{ $workorderdetail->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <br />

    @if ($workorderdetails->isEmpty())
        <div class="row">
            <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4">

                <h3>Create Workorder Detail</h3>

                <form method="post"
                      action="{{ route('user.workorderdetails.store') }}">
                    @csrf

                    <input type="hidden"
                           name="workorder_id"
                           value="{{ $workorder->W_WorkOrder }}" />
                    <br />

                    <x-form.select name="requestorrole"
                                   label="Requestor Role"
                                   :value="old('requestorrole')"
                                   :options="$requestorroles" />
                    <br />

                    <x-form.button>Submit</x-form.button>
                </form>

            </div>
        </div>
    @endif

    <br />
    <br />

</x-user-layout>
