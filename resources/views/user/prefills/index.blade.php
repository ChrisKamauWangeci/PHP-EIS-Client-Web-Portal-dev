<x-user-layout title="">

    <h1>Prefills</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.prefills.index') }}">

        <div class="row">

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="workorder_id"
                              label="Workorder ID"
                              :value="request('workorder_id')"
                              autocomplete="off"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="slug"
                              label="Slug"
                              :value="request('slug')"
                              autocomplete="off"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="applicant"
                              label="Applicant"
                              :value="request('applicant')"
                              autocomplete="off"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="username"
                              label="Username"
                              :value="request('username')"
                              autocomplete="off"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="created_at_from"
                              label="Created From"
                              :value="request('created_at_from')"
                              type="date"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <x-form.input name="created_at_to"
                              label="Created To"
                              :value="request('created_at_to')"
                              type="date"
                              autocomplete="off" />
            </div>

            <div class="col-6 col-md-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.prefills.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $prefills->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'db', 'sort_direction' => $sort_direction]) }}">DB</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'workorder_id', 'sort_direction' => $sort_direction]) }}">Workorder
                            ID</a></th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'applicant', 'sort_direction' => $sort_direction]) }}">Applicant</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'slug', 'sort_direction' => $sort_direction]) }}">Slug</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'username', 'sort_direction' => $sort_direction]) }}">Username</a>
                    </th>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => $sort_direction]) }}">Created
                            At</a></th>
                    <th>
                        File Preferred
                        <br />
                        ( Ghostscript )

                    </th>
                    {{-- <th>
                        File
                        <br />
                        ( Backup )
                    </th> --}}
                    <!-- <th></th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($prefills as $prefill)
                    <tr>
                        <td>{{ $prefill->id }}</td>
                        <td>{{ $prefill->db }}</td>
                        <td>{{ $prefill->workorder_id }}</td>
                        <td>{{ $prefill->applicant }}</td>
                        <td>{{ $prefill->slug }}</td>
                        <td>{{ $prefill->username }}</td>
                        <td>{{ $prefill->created_at }}</td>
                        <td nowrap>
                            @php
                                $file = '//ftpserver/documents/sign/' . $prefill->workorder_id . '-prefill-gs.pdf';
                            @endphp
                            @if (is_file($file))
                                <a href="/user/files?file=//ftpserver/documents/sign/{{ $prefill->workorder_id }}-prefill-gs.pdf&amp;download=0"
                                   target="_blank"
                                   class="btn btn-xs btn-secondary">View GS</a>
                                <a href="/user/files?file=//ftpserver/documents/sign/{{ $prefill->workorder_id }}-prefill-gs.pdf&amp;download=1"
                                   target="_blank"
                                   class="btn btn-xs btn-secondary">Download GS</a>
                            @endif
                        </td>
                        {{-- <td nowrap>
                            @php
                                $file = '//ftpserver/documents/sign/' . $prefill->workorder_id . '-prefill.pdf';
                            @endphp
                            @if (is_file($file))
                                <a href="/user/files?file=//ftpserver/documents/sign/{{ $prefill->workorder_id }}-prefill.pdf&amp;download=0" target="_blank" class="btn btn-xs btn-secondary">View</a>
                                <a href="/user/files?file=//ftpserver/documents/sign/{{ $prefill->workorder_id }}-prefill.pdf&amp;download=1" target="_blank" class="btn btn-xs btn-secondary">Download</a>
                            @endif
                        </td> --}}
                        <!-- <td class="actions">
                            <a href="{{ route('user.prefills.show', $prefill->id) }}" class="btn btn-xs btn-secondary">view</a>
                        </td> -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $prefills->withQueryString()->links() }}

    <br />
    <br />

    <a href="{{ route('user.prefills.stats') }}"
       class="btn btn-sm btn-secondary">Stats</a>

    <br />
    <br />

</x-user-layout>
