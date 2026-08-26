<x-pdf-layout title="">

    <table width="100%"
           height="100%">
        <tr>
            <td style="position: relative">
                <img style="position:absolute; bottom:0; right:0"
                     src="data:image/svg+xml;base64,{{ base64_encode(QrCode::size(60)->generate($workorder->W_WorkOrder)) }}"
                     class="m-2">
            </td>
        </tr>
    </table>

</x-pdf-layout>
