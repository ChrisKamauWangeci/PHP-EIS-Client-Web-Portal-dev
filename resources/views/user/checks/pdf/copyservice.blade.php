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
                        {{ $copyservice->C_CopyService }}
                        <br />
                        {{ $copyservice->C_Address }}
                        <br />
                        {{ $copyservice->C_City }}, {{ $copyservice->C_State }} {{ $copyservice->C_Zip }}
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
