<x-user-layout title="">

    @if ($postname)
        <script>
            function post_value(value) {
                opener.hospitalform.copyservice.value = value;
                self.close();
            }
        </script>
    @endif

    <div class="row">
        <div class="col-6">
            <h1>Copy Services</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('user.copyservices.create') }}"
               class="btn btn-sm btn-secondary">Create New</a>
        </div>
    </div>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.copyservices.index') }}">

        @if ($postname)
            <input type="hidden"
                   name="postname"
                   value="1">
        @endif

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="C_CopyService"
                              id="C_CopyService"
                              label="Copy Service"
                              :value="request('C_CopyService')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="C_Phone"
                              id="C_Phone"
                              label="Phone"
                              :value="request('C_Phone')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="C_Address"
                              id="C_Address"
                              label="Address"
                              :value="request('C_Address')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="C_City"
                              id="C_City"
                              label="City"
                              :value="request('C_City')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.select name="C_State"
                               id="C_State"
                               label="State"
                               :options="Helper::states()"
                               empty="-"
                               :default="request('C_State')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="C_Zip"
                              id="C_Zip"
                              label="Zip Code"
                              :value="request('C_Zip')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.copyservices.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $copyservices->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_CopyService', 'sort_direction' => $sort_direction]) }}">
                            Copy Service</a></th>
                    <th>
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Address', 'sort_direction' => $sort_direction]) }}">Address</a>
                        /
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_City', 'sort_direction' => $sort_direction]) }}">City</a>
                        /
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_State', 'sort_direction' => $sort_direction]) }}">State</a>
                        /
                        <a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Zip', 'sort_direction' => $sort_direction]) }}">Zip</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Phone', 'sort_direction' => $sort_direction]) }}">Phone</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_Fax', 'sort_direction' => $sort_direction]) }}">Fax</a>
                    </th>
                    @if ($subdomain == 'eisdev')
                        <th><a
                               href="{{ Request::fullUrlWithQuery(['sort_field' => 'attestation_required', 'sort_direction' => $sort_direction]) }}">Attestation
                                Required</a></th>
                        <th><a
                               href="{{ Request::fullUrlWithQuery(['sort_field' => 'attestation_file', 'sort_direction' => $sort_direction]) }}">Attestation
                                File</a></th>
                        <th><a
                               href="{{ Request::fullUrlWithQuery(['sort_field' => 'attestation_expiration', 'sort_direction' => $sort_direction]) }}">Attestation
                                Expiration</a></th>
                    @endif
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'C_UpdateDate', 'sort_direction' => $sort_direction]) }}">Updated
                            at</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($copyservices as $copyservice)
                    <tr>
                        <td>{{ $copyservice->C_CopyService }}</td>
                        <td>
                            {{ $copyservice->C_Address }}
                            <br />
                            {{ $copyservice->C_City }}
                            {{ $copyservice->C_State }}
                            {{ $copyservice->C_Zip }}
                        </td>
                        <td>{{ $copyservice->C_Phone }}</td>
                        <td>{{ $copyservice->C_Fax }}</td>
                        @if ($subdomain == 'eisdev')
                            <td><img src="/img/icon_{{ $copyservice->attestation_required }}.png"
                                     alt=""></td>
                            <td>{{ $copyservice->attestation_file }}</td>
                            <td>{{ $copyservice->attestation_expiration }}</td>
                        @endif
                        <td>{{ $copyservice->C_UpdateDate }}</td>
                        <td>
                            @if ($postname)
                                <button class="btn btn-xs btn-success"
                                        onclick="post_value('{{ $copyservice->C_CopyService }}');">Select</button>
                            @endif
                            <a href="{{ route('user.copyservices.show', $copyservice->C_ID) }}"
                               class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $copyservices->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>
