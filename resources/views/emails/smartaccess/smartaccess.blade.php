<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">
    <meta name="supported-color-schemes" content="light">
    <title>Email</title>
</head>

<body style="margin:0; padding:0; background-color:#FFFFFF; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:1.5; color:#333333;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF">

        <tr>
            <td align="center" style="padding:0">

                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px; background-color:#ffffff;">

                    <tr>
                        <td style="border-top:15px solid {{ $theme['headercolor'] }};"></td>
                    </tr>

                    <tr>
                        <td style="padding:20px; text-align:center; color:#ffffff;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto; ">
                                @if ($theme['slug'] !== 'eis')
                                <tr>
                                    <td align="center" style="padding-bottom:10px;">
                                        <img src="https://www.expressimagingservices.com/images/smartaccess/{{ $theme['slug'] }}.png?" alt="{{ $theme['company_name'] }}" height="300" style="height:60px;display:block;" />
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td align="center">
                                        <img src="https://www.expressimagingservices.com/images/smartaccess/eis.png" alt="Express Imaging Services" width="60" height="60" style="width:60px;height:60px;display:block;" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:30px;">

                            {{-- <span style="font-weight:bold; color:#000000;">
                                S.M.A.R.T. Access&trade;
                            </span>
                            <br />
                            <span style="font-size:11px; color:#222222;">TRUSTED EXCHANGE FRAMEWORK</span> --}}

                            <span style="font-weight:bold; color:#000000; font-size:16px;">
                                Hello {{ $ehrorder->first_name }},
                            </span>

                            <br />

                            <p>
                                You have been invited to connect with <strong>S.M.A.R.T. Access&trade;</strong> - the secure health data platform that gives you verified, real-time access to your complete medical records through the Trusted Exchange Framework.
                                <br />
                                <br />
                                By connecting, you authorize the secure retrieval of your health records to support your application process.
                                Your data is protected under HIPAA and accessed exclusively through ONC-certified networks.

                                @if ($theme['slug'] === 'mfin')
                                    <br />
                                    <br />
                                    M Financial Holdings Incorporated supports a network of independent insurance professionals and works with leading insurance carriers to help facilitate the life insurance application process. To streamline underwriting, we have partnered with Express Imaging Services, Inc (EIS, Inc.), a trusted medical records provider, to securely obtain the medical information needed to evaluate your application.
                                @endif

                            </p>

                            <br />

                            <table role="presentation" width="100%" cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse; border-color:#ffffff; margin:0px 0; background-color:#f7f7f7; border-left:5px solid {{ $theme['headercolor'] }};">
                                <tr>
                                    <td>
                                        <p style="font-weight:bold; color:#777777; margin-left:10px;">HOW IT WORKS</p>

                                        <table role="presentation" width="100%" cellpadding="8" cellspacing="0" border="0" style="border-collapse:collapse; border-color:#FFFFFF; margin:10px 0;">
                                            <tr>
                                                <td width="20" align="center" valign="top" style=""><span style="display:inline-block; min-width:16px; padding:4px; background-color:#333333; color:#ffffff; font-weight:bold;">1</span></td>
                                                <td><strong>Verify Your Identity</strong> — Click the button below and securely confirm who you are.</td>
                                            </tr>
                                            <tr>
                                                <td width="20" align="center" valign="top" style=""><span style="display:inline-block; min-width:16px; padding:4px; background-color:#333333; color:#ffffff; font-weight:bold;">2</span></td>
                                                <td><strong>Connect</strong> — Authorize access through the Trusted Exchange Framework.</td>
                                            </tr>
                                            <tr>
                                                <td width="20" align="center" valign="top" style=""><span style="display:inline-block; min-width:16px; padding:4px; background-color:#333333; color:#ffffff; font-weight:bold;">3</span></td>
                                                <td><strong>Retrieve</strong> — Your complete records are retrieved instantly, structured, and delivered securely.</td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="margin:25px auto;">
                                <tr>
                                    <td align="center" bgcolor="#333333" style="background-color:#333333; border:2px solid #222222;">

                                        <a href="https://{{ config('site_config.eis_client_portal_subdomain') }}.expressimagingservices.com/express/smartaccess?id={{ $ehrorder->uuid }}"
                                            style="display:block; padding:12px 24px; color:#ffffff; text-decoration:none; font-weight:bold;">
                                            →&nbsp; Connect &amp; Authorize Access
                                        </a>

                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0; color:#777777;">
                                Or copy this link: <a href="https://{{ config('site_config.eis_client_portal_subdomain') }}.expressimagingservices.com/express/smartaccess?id={{ $ehrorder->uuid }}" style="color:#c72228;">https://{{ config('site_config.eis_client_portal_subdomain') }}.expressimagingservices.com/express/smartaccess?id={{ $ehrorder->uuid }}</a>
                            </p>

                            <br />

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0;">
                                <tr>
                                    <td style="background:#fff8ed; border:1px solid #f5c842; color:#7a5800; padding:10px;">
                                        &#9203; This invitation link expires in <strong>72 hours</strong>. Please complete before <strong>{{ now()->addHours(72)->format('F j, Y') }}</strong>.
                                    </td>
                                </tr>
                            </table>

                            <br />

                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f2f2f2;border:1px solid #eeeeee;">
                                <tr>
                                    <td style="padding:20px">
                                        <p style="margin-bottom:10px;">WHY S.M.A.R.T. ACCESS&#8482;</p>
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="width:50%;vertical-align:top;padding:0 8px 10px 0;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>&#10003;</td>
                                                            <td style="padding-left:8px;">Verified identity-driven access</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="width:50%;vertical-align:top;padding-bottom:10px;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>&#10003;</td>
                                                            <td style="padding-left:8px;">Real-time medical data retrieval</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:50%;vertical-align:top;padding:0 8px 10px 0;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>&#10003;</td>
                                                            <td style="padding-left:8px;">Most complete records available</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="width:50%;vertical-align:top;padding-bottom:10px;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>&#10003;</td>
                                                            <td style="padding-left:8px;">Structured, normalized output</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:50%;vertical-align:top;padding-right:8px;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>&#10003;</td>
                                                            <td style="padding-left:8px;">HIPAA &amp; ONC certified</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="width:50%;vertical-align:top;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td>&#10003;</td>
                                                            <td style="padding-left:8px;">Faster underwriting decisions</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <br />

                            SMART Access provides secure, verified, and real-time retrieval of your health records through trusted national exchange networks.

                            <br />
                            <br />

                            If you have any questions, please contact us at <a href="mailto:info@expressimagingservices.com">info@expressimagingservices.com</a>
                            <br />
                            <br />
                            Warm regards,
                            <br />
                            <strong>The S.M.A.R.T. Access™ Team</strong>

                            <br />
                            <br />

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="border-top:1px solid #eeeeee;"></td>
                                </tr>
                            </table>

                            <br />

                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="vertical-align:middle; padding:10px;">
                                        <img src="https://www.expressimagingservices.com/images/smartaccess/eis.png" alt="Express Imaging Services" width="40" height="40" style="width:40px;height:40px;display:block;" />
                                    </td>
                                    <td style="vertical-align:middle; text-align:left;">
                                        <span style="font-weight:bold; color:#000000; font-size:13px;">
                                            S.M.A.R.T. <span style="font-weight:bold; color:#AA0000;">Access&trade;</span>
                                        </span>
                                        <div style="font-size:10px; color:#222222;">Verified Identity - Instant Access - Complete Records</div>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td bgcolor="{{ $theme['headercolor'] }}" cellpadding="20" style="padding:20px; text-align:center; color:#ffffff; font-size:11px;">

                            <a href="https://www.expressimagingservices.com/express/privacy" style="color:#FFFFFF;text-decoration:underline;">Privacy Notice</a>
                            &nbsp;
                            <a href="https://www.expressimagingservices.com/" style="color:#FFFFFF;text-decoration:underline;">Help & Support</a>

                            <br />
                            <br />

                            This message was sent because you are an applicant in our system.

                            <br />
                            <br />

                            &copy; {{ date('Y') }} Express Imaging Services, Inc. All rights reserved.

                            <br />

                        </td>

                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>