<x-user-layout title="">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('hospitalfax')?.addEventListener('click', function() {
                document.getElementById('fax_number').value = this.innerHTML;
            });

            document.getElementById('copyservicefax')?.addEventListener('click', function() {
                document.getElementById('fax_number').value = this.innerHTML;
            });

            document.getElementById('roifax')?.addEventListener('click', function() {
                document.getElementById('fax_number').value = this.innerHTML;
            });
        });
    </script>

    <div class="row">
        <div class="col-auto">
            <h1>Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }} {{ $workorder->W_LastName }}
            </h1>
        </div>
        <div class="col text-end d-print-none">
            <!-- <a href="{{ route('user.faxes.index') }}" class="btn btn-sm btn-secondary">Faxes</a>
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-secondary">View Workorder</a>
            <a href="{{ route('user.workorderfiles.show', $workorder->W_WorkOrder) }}" class="btn btn-sm btn-secondary">View Workorder Files</a> -->
        </div>
    </div>

    <br />

    <h4>Fax Send</h4>
    <br />

    <div class="row">
        <div class="col-md-6">

            <form method="post"
                  action="{{ route('user.faxes.store') }}">
                @csrf

                <input type="hidden"
                       name="workorder_id"
                       value="{{ $workorder->W_WorkOrder }}">
                <input type="hidden"
                       name="file"
                       value="{{ $file }}">

                File
                <br />
                <strong>{{ $file }}</strong>
                <br />
                <br />
                Hospital
                <br />
                <strong>{{ $hospital->H_Hospital }}</strong>
                <br />
                Fax: <span id="hospitalfax"
                      class="text-decoration-underline font-weight-bold">{{ $hospital->H_Fax }}</span>
                <br />
                <br />
                Copy Service
                <br />
                <strong>{{ $copyservice->C_CopyService ?? '-' }}</strong>
                <br />
                @if (isset($copyservice->C_Fax))
                    Fax: <span id="copyservicefax"
                          class="text-decoration-underline font-weight-bold">{{ $copyservice->C_Fax }}</span>
                    <br />
                @endif
                <br />
                Roi
                <br />
                <strong>{{ $roi->R_ROIname ?? '-' }}</strong>
                <br />
                @if (isset($roi->R_Fax))
                    Fax: <span id="roifax"
                          class="text-decoration-underline font-weight-bold">{{ $roi->R_Fax }}</span>
                    <br />
                @endif
                <br />
                <x-form.input type="number"
                              name="fax_number"
                              id="fax_number"
                              label="Fax Number"
                              :value="$hospital->H_Fax"
                              required
                              min=1000000000
                              max=99999999999 />
                <br />
                <br />
                <x-form.errors />
                <br />
                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

    @if ($usersession['debug'])
        <div class="bg-light small p-2 d-print-none">
            workorder
            @php dump(@$workorder) @endphp
            hospital
            @php dump(@$hospital) @endphp
        </div>
    @endif

</x-user-layout>
