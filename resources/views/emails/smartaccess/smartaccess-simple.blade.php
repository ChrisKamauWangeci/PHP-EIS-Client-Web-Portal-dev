<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>You're Invited - S.M.A.R.T. Access™</title>
  <!--[if mso]>
  <noscript><xml><o:OfficeDocumentSettings>
    <o:PixelsPerInch>96</o:PixelsPerInch>
  </o:OfficeDocumentSettings></xml></noscript>
  <![endif]-->
  <style>
    body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}
    table,td{mso-table-lspace:0pt;mso-table-rspace:0pt}
    img{-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:none;text-decoration:none}
    body{margin:0!important;padding:0!important;background-color:#f2f2f2}
    @media only screen and (max-width:620px){
      .email-container{width:100%!important}
      .em-pad{padding:20px!important}
      .em-body-pad{padding:24px!important}
      .em-footer-pad{padding:16px 24px!important}
      .em-stack td{display:block!important;width:100%!important;padding:0 0 10px 0!important}
      .em-btn{padding:14px 20px!important}
    }
  </style>
</head>
<body style="margin:0;padding:0;background-color:#f2f2f2;font-family:Arial,Helvetica,sans-serif;">

<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f2f2f2;">
  <tr>
    <td align="center" class="em-pad" style="padding:24px 12px;">
      <table role="presentation" class="email-container" border="0" cellpadding="0" cellspacing="0" width="620" style="width:620px;background-color:#ffffff;border:1px solid #d9d9d9;border-collapse:collapse;">
        <tr>
          <td style="padding:24px 32px;background-color:#ffffff;border-bottom:1px solid #d9d9d9;text-align:left;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td width="72" valign="middle" style="padding-right:12px;">
                  <img src="https://www.expressimagingservices.com/images/eis-logo.png" alt="EiS" width="56" height="56" style="display:block;width:56px;height:56px;" />
                </td>
                <td valign="middle" style="font-size:18px;line-height:22px;font-weight:bold;color:#1a1618;">
                  S.M.A.R.T. <span style="color:#c72228;">Access&#8482;</span><br />
                  <span style="font-size:12px;line-height:16px;font-weight:normal;color:#666666;">Trusted Exchange Framework</span>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="em-body-pad" style="padding:32px 32px 24px 32px;background-color:#ffffff;color:#333333;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td style="font-size:20px;line-height:28px;font-weight:bold;color:#1a1618;padding:0 0 16px 0;">
                  Hello {{ $ehrorder->first_name }},
                </td>
              </tr>
              <tr>
                <td style="font-size:14px;line-height:22px;color:#444444;padding:0 0 14px 0;">
                  You have been invited to connect with <strong>S.M.A.R.T. Access&#8482;</strong>, the secure health data platform that gives you verified, real-time access to your medical records.
                </td>
              </tr>
              <tr>
                <td style="font-size:14px;line-height:22px;color:#444444;padding:0 0 20px 0;">
                  By connecting, you authorize the retrieval of your health records to support your application process. Your data is protected under HIPAA and accessed through ONC-certified networks.
                </td>
              </tr>
              <tr>
                <td style="padding:0 0 20px 0;">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #d9d9d9;border-collapse:collapse;">
                    <tr>
                      <td style="padding:14px 16px;background-color:#f7f7f7;font-size:12px;line-height:16px;font-weight:bold;color:#1a1618;border-bottom:1px solid #d9d9d9;">
                        How It Works
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:16px;">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tr>
                            <td width="28" valign="top" style="font-size:14px;line-height:20px;font-weight:bold;color:#c72228;padding:0 0 10px 0;">1.</td>
                            <td valign="top" style="font-size:14px;line-height:20px;color:#444444;padding:0 0 10px 0;">Verify your identity using the secure link below.</td>
                          </tr>
                          <tr>
                            <td width="28" valign="top" style="font-size:14px;line-height:20px;font-weight:bold;color:#c72228;padding:0 0 10px 0;">2.</td>
                            <td valign="top" style="font-size:14px;line-height:20px;color:#444444;padding:0 0 10px 0;">Authorize access through the Trusted Exchange Framework.</td>
                          </tr>
                          <tr>
                            <td width="28" valign="top" style="font-size:14px;line-height:20px;font-weight:bold;color:#c72228;padding:0;">3.</td>
                            <td valign="top" style="font-size:14px;line-height:20px;color:#444444;padding:0;">Your records are retrieved and delivered securely.</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td align="center" style="padding:0 0 16px 0;">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#c72228" style="padding:14px 22px;text-align:center;">
                        <a href="https://{{ config('site_config.eis_client_portal_subdomain') }}.expressimagingservices.com/express/smartaccess/auth?id={{ $ehrorder->uuid }}" style="font-size:14px;line-height:18px;font-weight:bold;color:#ffffff;text-decoration:none;display:inline-block;">
                          Connect &amp; Authorize Access
                        </a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td align="center" style="font-size:12px;line-height:18px;color:#666666;padding:0 0 20px 0;word-break:break-word;">
                  Or copy this link: <a href="https://{{ config('site_config.eis_client_portal_subdomain') }}.expressimagingservices.com/express/smartaccess/auth?id={{ $ehrorder->uuid }}" style="color:#c72228;text-decoration:underline;">https://{{ config('site_config.eis_client_portal_subdomain') }}.expressimagingservices.com/express/smartaccess/auth?id={{ $ehrorder->uuid }}</a>
                </td>
              </tr>
              <tr>
                <td style="padding:0 0 20px 0;">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #e5c34a;border-collapse:collapse;">
                    <tr>
                      <td style="padding:12px 14px;background-color:#fff9e6;font-size:13px;line-height:20px;color:#6b5200;">
                        This invitation link expires in <strong>72 hours</strong>. Please complete before <strong>{{ now()->addHours(72)->format('F j, Y') }}</strong>.
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="padding:0 0 20px 0;">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #d9d9d9;border-collapse:collapse;">
                    <tr>
                      <td style="padding:14px 16px;background-color:#f7f7f7;font-size:12px;line-height:16px;font-weight:bold;color:#1a1618;border-bottom:1px solid #d9d9d9;">
                        Why S.M.A.R.T. Access&#8482;
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:16px;">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tr class="em-stack">
                            <td width="50%" valign="top" style="padding:0 12px 10px 0;font-size:13px;line-height:20px;color:#444444;">Verified identity-driven access</td>
                            <td width="50%" valign="top" style="padding:0 0 10px 0;font-size:13px;line-height:20px;color:#444444;">Real-time medical data retrieval</td>
                          </tr>
                          <tr class="em-stack">
                            <td width="50%" valign="top" style="padding:0 12px 10px 0;font-size:13px;line-height:20px;color:#444444;">Most complete records available</td>
                            <td width="50%" valign="top" style="padding:0 0 10px 0;font-size:13px;line-height:20px;color:#444444;">Structured, normalized output</td>
                          </tr>
                          <tr class="em-stack">
                            <td width="50%" valign="top" style="padding:0 12px 0 0;font-size:13px;line-height:20px;color:#444444;">HIPAA &amp; ONC certified</td>
                            <td width="50%" valign="top" style="padding:0;font-size:13px;line-height:20px;color:#444444;">Faster underwriting decisions</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="border-top:1px solid #d9d9d9;font-size:1px;line-height:1px;padding:0;">&nbsp;</td>
              </tr>
              <tr>
                <td style="padding:18px 0 0 0;font-size:13px;line-height:21px;color:#444444;">
                  If you have any questions, please contact us at <a href="mailto:info@expressimagingservices.com" style="color:#c72228;text-decoration:none;">info@expressimagingservices.com</a>.
                </td>
              </tr>
              <tr>
                <td style="padding:10px 0 0 0;font-size:13px;line-height:21px;color:#444444;">Warm regards,</td>
              </tr>
              <tr>
                <td style="padding:0;font-size:13px;line-height:21px;color:#1a1618;font-weight:bold;">The S.M.A.R.T. Access&#8482; Team</td>
              </tr>
              <tr>
                <td style="padding:18px 0 0 0;">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td width="64" valign="middle" style="padding-right:10px;">
                        <img src="https://www.expressimagingservices.com/img/eis-logo.png" alt="EiS" width="40" height="40" style="display:block;width:40px;height:40px;" />
                      </td>
                      <td valign="middle" style="font-size:12px;line-height:18px;color:#666666;">
                        <strong style="color:#1a1618;">S.M.A.R.T. <span style="color:#c72228;">Access&#8482;</span></strong><br />
                        Verified Identity &middot; Real-Time Access &middot; Complete Records
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="em-footer-pad" style="padding:18px 32px;background-color:#1a1618;text-align:center;color:#ffffff;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr>
                <td align="center" style="font-size:12px;line-height:18px;padding:0 0 8px 0;">
                  <a href="https://www.expressimagingservices.com/express/privacy" style="color:#d6d6d6;text-decoration:none;">Privacy Notice</a>
                  &nbsp;|&nbsp;
                  <a href="mailto:info@expressimagingservices.com" style="color:#d6d6d6;text-decoration:none;">Help &amp; Support</a>
                </td>
              </tr>
              <tr>
                <td align="center" style="font-size:11px;line-height:17px;color:#bcbcbc;">
                  &copy; {{ now()->year }} Express Imaging Services Inc.&#8482;. All rights reserved.<br />
                  This message was sent because you are an applicant in our system.
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>