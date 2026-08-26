<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h2>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_MiddleInit }}
                {{ $workorder->W_LastName }}</h2>
        </div>
        <div class="col text-end">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <br />

    @if ($workorderduplicates->count()) :
        <span class="text-danger fw-bold">This workorder has already duplicated to following workorders:</span>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered w-auto">
                <thead>
                    <th>old workorder</th>
                    <th>new workorder</th>
                    <th>hospital id</th>
                    <th>contractor</th>
                    <th>created</th>
                </thead>
                <tbody>
                    @foreach ($workorderduplicates as $workorderduplicate)
                        <tr>
                            <td>{{ $workorderduplicate->oldworkorder }}</td>
                            <td><a
                                   href="{{ route('user.workorders.show', $workorderduplicate->newworkorder) }}">{{ $workorderduplicate->newworkorder }}</a>
                            </td>
                            <td>{{ $workorderduplicate->hospitalid }}</td>
                            <td>{{ $workorderduplicate->username }}</td>
                            <td>{{ $workorderduplicate->created }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <br />

    <div class="row">
        <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4">

            <h3>Duplicate Workorder</h3>

            <form method="post"
                  action="{{ route('user.workorders.duplicateupdate', $workorder->W_WorkOrder) }}">
                @method('PATCH')
                @csrf

                <x-form.checkbox name="duplicatehospital"
                                 label="Duplicate with existing hospital?" />

                <x-form.checkbox name="confirm"
                                 label="Are you sure ?"
                                 required />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>
