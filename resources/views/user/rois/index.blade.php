<x-user-layout title="">

    @if ($postname)
        <script>
            function post_value(value) {
                opener.hospitalform.roi.value = value;
                self.close();
            }
        </script>
    @endif

    <div class="row">
        <div class="col-6">
            <h1>ROI</h1>
        </div>
        <div class="col-6 text-end">
            <a href="{{ route('user.rois.create') }}" class="btn btn-sm btn-secondary">Create New</a>
        </div>
    </div>

    <form method="get" accept-charset="utf-8" id="searchform" action="{{ route('user.rois.index') }}">

        @if ($postname)
            <input type="hidden" name="postname" value="1">
        @endif

        <div class="row">

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="R_ROIname" label="ROI Name" :value="request('R_ROIname')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="R_City" label="City" :value="request('R_City')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.select name="R_State" label="State" :options="Helper::states()" empty="-" :default="request('R_State')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="R_Zip" label="Zip" :value="request('R_Zip')" maxlength="10" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="R_Phone" label="Phone" :value="request('R_Phone')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <x-form.input name="R_Fax" label="Fax" :value="request('R_Fax')" />
            </div>

            <div class="col-4 col-md-2 col-lg-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.rois.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />

    {{ $rois->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a href="{{ Request::fullUrlWithQuery(['sort_field' => 'R_ROIname', 'sort_direction' => $sort_direction]) }}">ROI Name</a></th>
                    <th>
                        Address /
                        City /
                        State /
                        Zip
                    </th>
                    <th>Phone</th>
                    <th>Fax</th>
                    <th>Updated</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rois as $roi)
                    <tr>
                        <td>{{ $roi->R_ROIname }}</td>
                        <td>
                            {{ $roi->R_Address }}
                            <br />
                            {{ $roi->R_City }}
                            {{ $roi->R_State }}
                            {{ $roi->R_Zip }}
                        </td>
                        <td>{{ $roi->R_Phone }}</td>
                        <td>{{ $roi->R_Fax }}</td>
                        <td>{{ $roi->R_UpdateDate }}</td>
                        <td>
                            @if ($postname)
                                <button class="btn btn-xs btn-success" onclick="post_value('{{ $roi->R_ROIname }}');">Select</button>
                            @endif
                            <a href="{{ route('user.rois.show', $roi->R_ID) }}" class="btn btn-xs btn-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $rois->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>