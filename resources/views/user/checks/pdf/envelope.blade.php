<x-pdf-layout title="">

    <div class="h5">
        <strong>
            Express Imaging Services, Inc.
            <br />
            1805 W 208th St #202
            <br />
            Torrance, CA 90501
        </strong>
    </div>

    <br />
    <br />

    <table width="100%">
        <tr>
            <td align="right">
                <div class="h4">
                    <strong>

                        {{ $hospital->H_Hospital2 ?: $hospital->H_Hospital }}
                        <br />

                        @if (trim($hospital->H_Affiliate ?? ''))
                            {{ $hospital->H_Affiliate }}
                            <br />
                        @endif

                        {{ $hospital->H_Address }}
                        <br />
                        {{ $hospital->H_City }}, {{ $hospital->H_State }} {{ $hospital->H_Zip }}
                    </strong>
                </div>
            </td>
        </tr>
    </table>

    <br />

    <div class="h5">
        <strong>
            WO# {{ $workorder->W_WorkOrder }}
        </strong>
    </div>

</x-pdf-layout>
