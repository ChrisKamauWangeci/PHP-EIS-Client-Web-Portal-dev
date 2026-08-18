<x-admin-layout title="">

    <h1>Account Managers</h1>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('admin.accountmanagers.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="Acc_Company" label="Company" :value="request('Acc_Company')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="Acc_Manager" label="Name" :value="request('Acc_Manager')" maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('admin.accountmanagers.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $accountmanagers->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Acc_Company', 'sort_direction' => $sort_direction]) }}">Company</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Acc_Manager', 'sort_direction' => $sort_direction]) }}">Name</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Acc_Phone', 'sort_direction' => $sort_direction]) }}">Phone</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Acc_PhoneExt', 'sort_direction' => $sort_direction]) }}">Phone Ext</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Acc_Fax', 'sort_direction' => $sort_direction]) }}">Fax</a></th>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'Acc_Email', 'sort_direction' => $sort_direction]) }}">Email</a></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accountmanagers as $accountmanager)
                    <tr>
                        <td>{{ $accountmanager->Acc_Company }} </td>
                        <td>{{ $accountmanager->Acc_Manager }} </td>
                        <td>{{ $accountmanager->Acc_Phone }} </td>
                        <td>{{ $accountmanager->Acc_PhoneExt }} </td>
                        <td>{{ $accountmanager->Acc_Fax }} </td>
                        <td>{{ $accountmanager->Acc_Email }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $accountmanagers->withQueryString()->links() }}

    <br />
    <br />

</x-admin-layout>