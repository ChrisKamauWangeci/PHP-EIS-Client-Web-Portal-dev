<x-emailseqster>

    <img src="https://www.expressimagingservices.com/img/prudential.jpg" alt="Prudential">
    <br />
    <br />
    Dear {{ $seqsterorder->first_name }},
    <br />
    <br />
    Thank you for your interest in PRUDENTIAL.
    <br />
    <br />
    As part of your application process, we need to evaluate your medical records. With your consent, these records can be quickly and securely shared with PRUDENTIAL through our trusted partner, EIS/SEQSTER.
    <br />
    <br />
    To begin, please click the link below to connect to your patient portal and authorize the release of your medical records:
    <br />
    <br />

    <center>
        <table align="center" cellspacing="0" cellpadding="0" width="100%" border="0">
            <tr>
                <td align="center" style="padding: 10px;">
                    <table cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td align="center" bgcolor="#007AC1" style="background-color: #007AC1; margin: auto; max-width: 600px; border-radius: 4px; padding: 15px 20px;" width="100%">
                                <a href="https://www.expressimagingservices.com/seqsterorders/step1/{{ $seqsterorder->uuid }}" target="_blank" style="font-size: 15px; color: #ffffff; font-weight:bold; text-align:center; background-color: #007AC1; text-decoration: none; border: none; border-radius: 4px; display: inline-block;">
                                    <span style="font-size: 15px; color: #ffffff; font-weight:bold; line-height:1.5em; text-align:center;">CLICK TO BEGIN</span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>

    <br />
    <br />

    @php
    $expiresAt = $seqsterorder->created->copy()->addDays(7);
    $remainingDays = now()->startOfDay()->diffInDays($expiresAt->startOfDay(), false);
    @endphp

    <strong>Note:</strong> This link will expire at: <strong>{{ $expiresAt->format('m/d/Y') }}</strong>

    <br />

    <strong>Doctor/Facility Name:</strong> {{ $hospitalraw?->R_Hospital ?? '' }}

    <br />
    <br />

    Once you click the link, you'll be directed to your dashboard. To connect records, simply click the "Connect More Records" card and follow the prompts. Please have your login credentials ready.
    <br />
    <br />
    Rest assured, your personal and health information will only be shared with your permission and is protected by bank-level security and privacy standards. All data is hosted on a fully HIPAA-compliant platform certified to meet the highest healthcare industry security standards.
    <br />
    If you need assistance or have questions:
    <br />
    For insurance application inquiries, contact customer service at {{ $ehrworkorder->R_Email ?? 'info@expressimagingservices.com' }}
    <br />
    <br />
    For help with connecting medical records, reach out to eis_support@seqster.com.
    <br />
    <br />
    Thank you

    <br />
    <br />

    <br />
    <br />

    <small>
        CONFIDENTIALITY NOTICE: This message is intended to be viewed only by the listed recipient(s). It may contain information that is privileged, confidential and/or exempt from disclosure under applicable law. Any dissemination, distribution or copying of this message is strictly prohibited without our prior written permission. If you are not an intended recipient, or if you have received this communication in error, please notify us immediately by return e-mail and permanently remove the original message and any copies from your computer and all back-up systems.
    </small>

    <br />

    <img src="https://www.expressimagingservices.com/seqsterorders/track?uuid={{ $seqsterorder->uuid }}" alt="" width="1" height="1">

</x-emailseqster>