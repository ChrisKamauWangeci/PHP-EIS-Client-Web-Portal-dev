<x-user-layout title="">

    <div class="row">
        <div class="col-auto">
            <h1>Shipping Labels, Workorder: {{ $workorder->W_WorkOrder }} - {{ $workorder->W_FirstName }}
                {{ $workorder->W_LastName }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $workorder->W_WorkOrder) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
        </div>
    </div>

    <br />

    <h4>Shipping Labels</h4>

    @php
        $d = new RecursiveDirectoryIterator('\\\server2\eisaccess\fedex\\');
        $dir = new RecursiveIteratorIterator($d);
        $files = new RegexIterator($dir, "/$workorder->W_WorkOrder.*(\.pdf)/i");
    @endphp

    <table class="table table-sm table-bordered w-auto">
        @foreach ($files as $file)
            <tr>
                <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=0"
                       target="_blank">view</a></td>
                <td><a href="/user/workorderfiles/file?file={{ urlencode($file) }}&amp;workorder_id={{ $workorder->W_WorkOrder }}&amp;download=1"
                       target="_blank">download</a></td>
                <td class="mono">{{ $file->getFilename() }}</td>
            </tr>
        @endforeach
    </table>

    <br />

    <h4>Upload Shipping Label</h4>

    <div class="row">
        <div class="col-sm-8 col-md-5">

            <form method="post"
                  action="{{ route('user.shippinglabels.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <input type="hidden"
                       name="W_WorkOrder"
                       value="{{ $workorder->W_WorkOrder }}">

                @php
                    $options = [
                        1 => 'Label 1',
                        2 => 'Label 2',
                    ];
                @endphp

                <x-form.select name="label"
                               label="Label"
                               :options="$options"
                               empty=" "
                               required />
                <br />

                <x-form.input type="text"
                              name="W_Tracking"
                              label="Tracking Number"
                              required />
                <br />

                <x-form.input type="file"
                              name="shipping_label"
                              label="Shipping Label"
                              accept="application/pdf"
                              required />
                <br />

                <x-form.errors />

                <button class="btn btn-sm btn-secondary"
                        type="submit">Submit</button>

            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>
