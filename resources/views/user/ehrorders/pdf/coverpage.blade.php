<x-pdf-layout title="">

    {{ date('M d, Y') }}

    <br />
    <br />

    <table width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td width="10%" valign="top" style="text-align: left; padding-top: 5px;">
                <img src="{{ public_path('img/eis-logo.png') }}" style="width: 80px;">
            </td>
            <td width="90%" valign="top" style="text-align: left; padding-left: 20px;">
                <div>P.O. Box 778, Torrance, CA 90508</div>
            </td>
        </tr>
    </table>

    <br />

    <strong>Letter of Request</strong><br />
    <br />
    Dear Provider / Medical Release Department,<br />
    <br />
    Patient Information<br />
    Workorder ID: <strong>{{ $ehrorder->workorder_id }}</strong><br />
    Patient Name: <strong>{{ $ehrorder->first_name }} {{ $ehrorder->last_name }}</strong><br />
    Date of Birth: <strong>{{ $ehrorder->birth_date?->format('m/d/Y') }}</strong><br />
    Social Security Number: <strong>{{ $ehrorder->social_security_number }}</strong><br />
    <br />
    We are requesting medical records for the patient named above, as authorized in the HIPAA<br />
    form below. This request is related to pursuing insurance claim.<br />
    <br />
    Please provide a complete copy of the patient's records between the following date ranges {{ $ehrorder->date_of_service_from?->format('m/d/Y') ?? '-' }} and {{ $ehrorder->date_of_service_to?->format('m/d/Y') ?? '-' }}, including but not limited to:<br />
    <br />
    - <strong>Clinical Records:</strong> Doctor's notes, hospital charts, admission and discharge summaries<br />
    - <strong>Diagnostic Records:</strong> Lab tests, imaging, and pathology reports<br />
    - <strong>Operation and Procedure Records:</strong> Operative, consultation, and treatment documents<br />
    - <strong>Treatment Records:</strong> Surgery reports, treatment plans, and specialist consultations<br />
    - <strong>Medication Records:</strong> Prescription history and pharmacy records<br />
    - <strong>Therapy Records:</strong> Physical therapy, rehabilitation, and related notes<br />
    <br />
    These records are essential to accurately assess the patient's diagnosis, treatment, and medical history for legal proceedings. Your help is greatly appreciated.<br />
    <br />
    Thank you for your help and assistance.<br />

    <div class="pt-2 float-end small text-muted">
        {{ date('Y-m-d H:i:s') }}
    </div>

</x-pdf-layout>
