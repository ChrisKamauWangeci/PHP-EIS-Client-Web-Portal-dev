<x-user-layout title="Workorder Insurance">

    <h1>Workorder Insurance</h1>

    <form method="GET"
          action="{{ route('user.woins.index') }}">

        <div class="row">

            <div class="col-md-2">
                <x-form.input name="WI_WorkOrder"
                              label="Workorder ID"
                              :value="request('WI_WorkOrder')"
                              autocomplete="off" />
            </div>

            <div class="col-md-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.woins.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />
    <br />

    {{ $woins->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>WI_WorkOrder</td>
                    <th>WI_InsName</td>
                    <th>WI_InvoiceNo</td>
                    <th>WI_InsPolicy</td>
                    <th>WI_ContractCd</td>
                    <th>WI_ContractFee</td>
                    <th>WI_CommPayrollNo</td>
                    <th>WI_CommAmount</td>
                    <th>WI_Underwriter</td>
                    <th>WI_DateRequest</td>
                    <th>WI_DateApprove</td>
                    <th>WI_Valid</td>
                    <th>WI_ValidDate</td>
                    <th>WI_ReferenceNo</td>
                    <th>WI_AuthFee</td>
                    <th>WI_LargeCase</td>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($woins as $woin)
                    <tr>
                        <td>{{ $woin->WI_WorkOrder }}</td>
                        <td>{{ $woin->WI_InsName }}</td>
                        <td>{{ $woin->WI_InvoiceNo }}</td>
                        <td>{{ $woin->WI_InsPolicy }}</td>
                        <td>{{ $woin->WI_ContractCd }}</td>
                        <td>{{ $woin->WI_ContractFee }}</td>
                        <td>{{ $woin->WI_CommPayrollNo }}</td>
                        <td>{{ $woin->WI_CommAmount }}</td>
                        <td>{{ $woin->WI_Underwriter }}</td>
                        <td>{{ $woin->WI_DateRequest }}</td>
                        <td>{{ $woin->WI_DateApprove }}</td>
                        <td>{{ $woin->WI_Valid }}</td>
                        <td>{{ $woin->WI_ValidDate }}</td>
                        <td>{{ $woin->WI_ReferenceNo }}</td>
                        <td>{{ $woin->WI_AuthFee }}</td>
                        <td>{{ $woin->WI_LargeCase }}</td>
                        <td><a href="{{ route('user.woins.show', $woin->WI_WorkOrder) }}"
                               class="btn btn-xs btn-secondary">view</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $woins->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>
