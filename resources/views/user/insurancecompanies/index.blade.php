<x-user-layout title="">

    <div class="row">
        <div class="col-6">
            <h1>Insurance Companies</h1>
        </div>
        <div class="col-6 text-end">
            <!-- <a href="{{ route('user.insurancecompanies.create') }}" class="btn btn-sm btn-secondary">Create New</a> -->
        </div>
    </div>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.insurancecompanies.index') }}">

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="I_Name"
                              id="I_Name"
                              label="Name"
                              :value="request('I_Name')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.insurancecompanies.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </div>

    </form>

    <br />

    {{ $insurancecompanies->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'I_ID', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'I_Name', 'sort_direction' => $sort_direction]) }}">Name</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'I_LOR', 'sort_direction' => $sort_direction]) }}">LOR</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'I_LORExpirationDate', 'sort_direction' => $sort_direction]) }}">LOR
                            Expiration Date</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'I_DirectBilling', 'sort_direction' => $sort_direction]) }}">Direct
                            Billing</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'I_ActiveWebsite', 'sort_direction' => $sort_direction]) }}">Active
                            Website</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($insurancecompanies as $insurancecompany)
                    <tr>
                        <td>{{ $insurancecompany->I_ID }}</td>
                        <td>{{ $insurancecompany->I_Name }}</td>
                        <td>{{ $insurancecompany->I_LOR }}</td>
                        <td
                            class="@if ($insurancecompany->I_LORExpirationDate) @if ($insurancecompany->I_LORExpirationDate->isPast())
                            text-danger
                        @elseif ($insurancecompany->I_LORExpirationDate->between(now(), now()->addMonths(3)))
                            text-warning @endif
                    @endif">
                            {{ $insurancecompany->I_LORExpirationDate?->format('Y-m-d') }}
                        </td>
                        <td><img src="/img/icon_{{ $insurancecompany->I_DirectBilling }}.png"
                                 alt=""></td>
                        <td><img src="/img/icon_{{ $insurancecompany->I_ActiveWebsite }}.png"
                                 alt=""></td>
                        <td class="actions">
                            @if ($postname)
                                <button class="btn btn-xs btn-success"
                                        onclick="post_value('{{ $insurancecompany->A_CopyService }}');">Select</button>
                            @endif
                            <a href="{{ route('user.insurancecompanies.show', $insurancecompany->I_ID) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $insurancecompanies->withQueryString()->links() }}

</x-user-layout>
