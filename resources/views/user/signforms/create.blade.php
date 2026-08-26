<x-user-layout title="">

    <script src="/js/pdf-lib.js"></script>
    <script src="/js/fontkit.umd.min.js"></script>
    <script src="/js/download.min.js"></script>

    <div class="row">
        <div class="col-auto">
            <h1>In-house Prefill: {{ $data['workorder_id'] }} - {{ $data['patient_full_name'] }}</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.workorders.show', $data['workorder_id']) }}"
               class="btn btn-sm btn-secondary">View Workorder</a>
            <a href="{{ route('user.prefills.index') }}"
               class="btn btn-sm btn-secondary">View Prefills</a>
        </div>
    </div>

    <br />
    <br />

    <button onclick="fillForm()"
            class="btn btn-sm btn-warning">1. Create PDF</button>
    &nbsp;
    <a id="downloadlink"
       href="/user/files?file=//ftpserver/documents/sign/{{ $data['workorder_id'] }}-prefill-gs.pdf&amp;download=0"
       target="_blank"
       class="btn btn-sm btn-success d-none">2. Download Prefill</a>
    &nbsp;
    <a href="{{ route('user.prefills.index', ['workorder_id' => $data['workorder_id']]) }}"
       class="btn btn-sm btn-secondary">View Prefills</a>
    <br />
    <div id="messageBox"
         class="text-success"></div>
    <br />

    <table class="table table-sm table-striped table-bordered w-auto">
        @foreach ($data as $key => $value)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
    </table>

    <br />
    <br />

    <script>
        const {
            PDFDocument
        } = PDFLib


        async function fillForm() {
            // Fetch the PDF with form fields
            const formUrl = '/user/files?file=//ftpserver/ftpserver/facilityformsfillable/{!! $data['slug'] !!}.pdf';
            const formPdfBytes = await fetch(formUrl).then(res => res.arrayBuffer());

            const fontUrl = '/css/prefill.ttf';
            const fontBytes = await fetch(fontUrl).then((res) => res.arrayBuffer());

            // Load a PDF with form fields
            const pdfDoc = await PDFDocument.load(formPdfBytes);

            const pages = pdfDoc.getPages();
            const page = pages[0];

            pdfDoc.registerFontkit(fontkit);
            const customfont = await pdfDoc.embedFont(fontBytes);

            // Get the form containing all the fields
            const form = pdfDoc.getForm();

            const pdfformfields = [];

            const fields = form.getFields();
            console.log(fields);
            fields.forEach(field => {
                const type = field.constructor.name;
                const name = field.getName();
                console.log(`${type}: ${name}`);
                pdfformfields.push(`${name}`);
            });

            console.log(pdfformfields);

            // if (pdfformfields.includes("signature")) {
            //     const signature = form.getTextField('signature');
            //     signature.setText('{!! $data['patient_full_name'] !!}');
            //     form.updateFieldAppearances(customfont);
            // }

            // if (pdfformfields.includes("date_signed")) {
            //     const date_signed = form.getTextField('date_signed');
            //     date_signed.setText('{{ date('m/d/Y') }}');
            // }

            if (pdfformfields.includes("workorder_id")) {
                const workorder_id = form.getTextField('workorder_id');
                workorder_id.setText('{!! $data['workorder_id'] !!}');
            }

            if (pdfformfields.includes("patient_first_name")) {
                const patient_first_name = form.getTextField('patient_first_name');
                patient_first_name.setText('{!! $data['patient_first_name'] !!}');
            }

            if (pdfformfields.includes("patient_middle_name")) {
                const patient_middle_name = form.getTextField('patient_middle_name');
                patient_middle_name.setText('{!! $data['patient_middle_name'] !!}');
            }

            if (pdfformfields.includes("patient_last_name")) {
                const patient_last_name = form.getTextField('patient_last_name');
                patient_last_name.setText('{!! $data['patient_last_name'] !!}');
            }

            if (pdfformfields.includes("patient_full_name")) {
                const patient_full_name = form.getTextField('patient_full_name');
                patient_full_name.setText('{!! $data['patient_full_name'] !!}');
            }

            if (pdfformfields.includes("patient_birth_date")) {
                const patient_birth_date = form.getTextField('patient_birth_date');
                patient_birth_date.setText('{!! $data['patient_birth_date'] !!}');
            }

            if (pdfformfields.includes("patient_birth_date_mdy")) {
                const patient_birth_date_mdy = form.getTextField('patient_birth_date_mdy');
                patient_birth_date_mdy.setText('{!! $data['patient_birth_date_mdy'] !!}');
            }

            if (pdfformfields.includes("patient_social_security")) {
                const patient_social_security = form.getTextField('patient_social_security');
                patient_social_security.setText('{!! $data['patient_social_security'] !!}');
            }

            if (pdfformfields.includes("patient_social_security_full")) {
                const patient_social_security_full = form.getTextField('patient_social_security_full');
                patient_social_security_full.setText('{!! $data['patient_social_security_full'] !!}');
            }

            if (pdfformfields.includes("patient_email")) {
                const patient_email = form.getTextField('patient_email');
                patient_email.setText('{!! $data['patient_email'] !!}');
            }

            if (pdfformfields.includes("patient_phone")) {
                const patient_phone = form.getTextField('patient_phone');
                patient_phone.setText('{!! $data['patient_phone'] !!}');
            }

            if (pdfformfields.includes("patient_address")) {
                const patient_address = form.getTextField('patient_address');
                patient_address.setText('{!! $data['patient_address'] !!}');
            }

            if (pdfformfields.includes("patient_city")) {
                const patient_city = form.getTextField('patient_city');
                patient_city.setText('{!! $data['patient_city'] !!}');
            }

            if (pdfformfields.includes("patient_state")) {
                const patient_state = form.getTextField('patient_state');
                patient_state.setText('{!! $data['patient_state'] !!}');
            }

            if (pdfformfields.includes("patient_zip_code")) {
                const patient_zip_code = form.getTextField('patient_zip_code');
                patient_zip_code.setText('{!! $data['patient_zip_code'] !!}');
            }

            if (pdfformfields.includes("patient_city_state_zip")) {
                const patient_city_state_zip = form.getTextField('patient_city_state_zip');
                patient_city_state_zip.setText('{!! $data['patient_city_state_zip'] !!}');
            }

            if (pdfformfields.includes("patient_full_address")) {
                const patient_full_address = form.getTextField('patient_full_address');
                patient_full_address.setText('{!! $data['patient_full_address'] !!}');
            }

            if (pdfformfields.includes("dates_of_service_from")) {
                const dates_of_service_from = form.getTextField('dates_of_service_from');
                dates_of_service_from.setText('{!! $data['dates_of_service_from'] !!}');
            }

            if (pdfformfields.includes("dates_of_service_from_ymd")) {
                const dates_of_service_from_ymd = form.getTextField('dates_of_service_from_ymd');
                dates_of_service_from_ymd.setText('{!! $data['dates_of_service_from_ymd'] !!}');
            }

            if (pdfformfields.includes("dates_of_service_to")) {
                const dates_of_service_to = form.getTextField('dates_of_service_to');
                dates_of_service_to.setText('{!! $data['dates_of_service_to'] !!}');
            }

            if (pdfformfields.includes("dates_of_service_to_ymd")) {
                const dates_of_service_to_ymd = form.getTextField('dates_of_service_to_ymd');
                dates_of_service_to_ymd.setText('{!! $data['dates_of_service_to_ymd'] !!}');
            }

            if (pdfformfields.includes("dates_of_service_combined")) {
                const dates_of_service_combined = form.getTextField('dates_of_service_combined');
                dates_of_service_combined.setText('{!! $data['dates_of_service_combined'] !!}');
            }

            if (pdfformfields.includes("dates_of_service_combined_ymd")) {
                const dates_of_service_combined_ymd = form.getTextField('dates_of_service_combined_ymd');
                dates_of_service_combined_ymd.setText('{!! $data['dates_of_service_combined_ymd'] !!}');
            }

            if (pdfformfields.includes("expiration_date_ymd")) {
                const expiration_date_ymd = form.getTextField('expiration_date_ymd');
                expiration_date_ymd.setText('{!! $data['expiration_date_ymd'] !!}');
            }

            if (pdfformfields.includes("eis_name")) {
                const eis_name = form.getTextField('eis_name');
                eis_name.setText('{!! $data['eis_name'] !!}');
            }

            if (pdfformfields.includes("eis_info")) {
                const eis_info = form.getTextField('eis_info');
                eis_info.setText('{!! $data['eis_info'] !!}');
            }

            if (pdfformfields.includes("eis_insurance")) {
                const eis_insurance = form.getTextField('eis_insurance');
                eis_insurance.setText('{!! $data['eis_insurance'] !!}');
            }

            if (pdfformfields.includes("eis_address")) {
                const eis_address = form.getTextField('eis_address');
                eis_address.setText('{!! $data['eis_address'] !!}');
            }

            if (pdfformfields.includes("eis_street")) {
                const eis_street = form.getTextField('eis_street');
                eis_street.setText('{!! $data['eis_street'] !!}');
            }

            if (pdfformfields.includes("eis_city")) {
                const eis_city = form.getTextField('eis_city');
                eis_city.setText('{!! $data['eis_city'] !!}');
            }

            if (pdfformfields.includes("eis_state")) {
                const eis_state = form.getTextField('eis_state');
                eis_state.setText('{!! $data['eis_state'] !!}');
            }

            if (pdfformfields.includes("eis_zip")) {
                const eis_zip = form.getTextField('eis_zip');
                eis_zip.setText('{!! $data['eis_zip'] !!}');
            }

            if (pdfformfields.includes("eis_phone")) {
                const eis_phone = form.getTextField('eis_phone');
                eis_phone.setText('{!! $data['eis_phone'] !!}');
            }

            if (pdfformfields.includes("eis_fax")) {
                const eis_fax = form.getTextField('eis_fax');
                eis_fax.setText('{!! $data['eis_fax'] !!}');
            }

            if (pdfformfields.includes("eis_email")) {
                const eis_email = form.getTextField('eis_email');
                eis_email.setText('{!! $data['eis_email'] !!}');
            }


            if (pdfformfields.includes("facility_dr")) {
                const facility_dr = form.getTextField('facility_dr');
                facility_dr.setText('{!! $data['facility_dr'] !!}');
            }

            if (pdfformfields.includes("facility_name")) {
                const facility_name = form.getTextField('facility_name');
                facility_name.setText('{!! $data['facility_name'] !!}');
            }

            if (pdfformfields.includes("facility_address")) {
                const facility_address = form.getTextField('facility_address');
                facility_address.setText('{!! $data['facility_address'] !!}');
            }

            if (pdfformfields.includes("facility_city")) {
                const facility_city = form.getTextField('facility_city');
                facility_city.setText('{!! $data['facility_city'] !!}');
            }

            if (pdfformfields.includes("facility_state")) {
                const facility_state = form.getTextField('facility_state');
                facility_state.setText('{!! $data['facility_state'] !!}');
            }

            if (pdfformfields.includes("facility_zip_code")) {
                const facility_zip_code = form.getTextField('facility_zip_code');
                facility_zip_code.setText('{!! $data['facility_zip_code'] !!}');
            }

            if (pdfformfields.includes("facility_city_state_zip")) {
                const facility_city_state_zip = form.getTextField('facility_city_state_zip');
                facility_city_state_zip.setText('{!! $data['facility_city_state_zip'] !!}');
            }

            if (pdfformfields.includes("facility_full_address")) {
                const facility_full_address = form.getTextField('facility_full_address');
                facility_full_address.setText('{!! $data['facility_full_address'] !!}');
            }

            if (pdfformfields.includes("facility_phone")) {
                const facility_phone = form.getTextField('facility_phone');
                facility_phone.setText('{!! $data['facility_phone'] !!}');
            }

            if (pdfformfields.includes("expiration_date")) {
                const expiration_date = form.getTextField('expiration_date');
                expiration_date.setText('{!! date('m/d/Y', strtotime(' + 1 year ')) !!}');
            }

            // const {
            //     width,
            //     height
            // } = page.getSize();

            // page.drawText('Express Imaging Services {{ date('m/d/Y H:i:s') }}', {
            //     x: 5,
            //     y: height - 15,
            //     size: 10
            // })

            // form.updateFieldAppearances(customfont);
            form.flatten();

            // Serialize the PDFDocument to bytes (a Uint8Array)
            const pdfBytes = await pdfDoc.save()

            // const pdfBytes = await pdfDoc.save()
            // await writeFile(pdfFilePath, pdfBytes) //nodejs fs
            // download(pdfBytes, "out.pdf", "application/pdf");

            var data = new FormData();
            data.append("_token", "{{ csrf_token() }}");
            data.append("db", "{{ $data['db'] }}");
            data.append("workorder_id", "{{ $data['workorder_id'] }}");
            data.append("slug", "{{ $data['slug'] }}");
            data.append("applicant", "{{ $data['patient_full_name'] }}");
            data.append("filename", "{{ $data['workorder_id'] }}-prefill.pdf");
            data.append("data", new Blob([pdfBytes], {
                type: "application/octet-stream",
            }));
            var xhr = new XMLHttpRequest();
            xhr.open('post', '/user/signforms', true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    const box = document.getElementById('messageBox');

                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                box.textContent = response.message;
                                box.className = 'text-success';
                                document.getElementById('downloadlink').classList.remove('d-none');
                            } else {
                                box.textContent = 'Error: ' + (response.message || 'Unknown error occurred');
                                box.className = 'text-danger';
                            }
                        } catch (e) {
                            // If response is not JSON, treat as success
                            box.textContent = 'Error: Failed to save PDF (Status: ' + xhr.status + ')';
                            box.className = 'text-danger';
                        }
                    } else {
                        box.textContent = 'Error: Failed to save PDF (Status: ' + xhr.status + ')';
                        box.className = 'text-danger';
                    }
                }
            };

            xhr.send(data);

            // Trigger the browser to download the PDF document
            // download(pdfBytes, "{{ $data['workorder_id'] }}-prefill.pdf", "application/pdf");

        }
    </script>

</x-user-layout>
