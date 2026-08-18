<x-emailseqster>

    <img src="https://usaa.expressimagingservices.com/img/usaamembers.png" alt="USAA">
    <br />
    <br />
    <br />
    Hello {{ $seqsterorder->first_name }},
    <br />
    <br />
    <br />
    Thank you for your interest in a USAA life insurance policy.
    <br />
    <br />
    As part of your life insurance application, we need to evaluate your medical records.
    <br />
    <br />
    With your consent, your medical records can quickly and easily be shared with USAA through our trusted partner, SEQSTER.
    <br />
    <br />
    To get started, <strong>simply click on the link below</strong> and the process of connecting your medical records will begin. Please note this link expires after 7 days.
    <br />
    <br />
    <ul>
        <li>After clicking the link, you will be directed to your dashboard. You may see medical records already connected.<br /></li>
        <li>Next, if you have more medical records you need to connect, such as, VA, Tricare, or MHS Genesis, or another healthcare provider, you will need to add those to your dashboard. Click on the card which states, <strong>Connect More Records</strong>.<br />
            <ul>
                <li>Follow the prompts.<br /></li>
                <li>Be sure to have your log in username and password handy. For VA, Tricare or MHS Genesis, use your DOS Logon.<br /></li>
            </ul>
        </li>
    </ul>

    <br />

    <center>
        <table align="center" cellspacing="0" cellpadding="0" width="100%" border="0">
            <tr>
                <td align="center" style="padding: 10px;">
                    <table cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td align="center" bgcolor="#1a3258" style="background-color: #1a3258; margin: auto; max-width: 600px; border-radius: 4px; padding: 15px 20px;" width="100%">
                                <a href="https://usaa.expressimagingservices.com/seqsterorders/step1/{{ $seqsterorder->uuid }}" target="_blank" style="font-size: 15px; color: #ffffff; font-weight:bold; text-align:center; background-color: #1a3258; text-decoration: none; border: none; border-radius: 4px; display: inline-block;">
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

    Your personal and health information is only shared with your permission. Your data is protected by bank-level security and privacy. Your data is in a server hosted on a fully HIPAA compliant platform that has been certified with the most stringent health care industry security standards.
    <br />
    <br />
    Need help, have questions, contact one of the following teams:
    <br />
    <ul>
        <li>Insurance application questions: contact customer service at 1-800-531-8722, ext. 73647.<br /></li>
        <li>Medical records connection questions: eis_support@seqster.com<br /></li>
    </ul>
    <br />
    Thank you,
    <br />
    Your USAA Underwriter
    <br />
    <br />
    <img src="https://usaa.expressimagingservices.com/seqsterorders/track?uuid={{ $seqsterorder->uuid }}" alt="" width="1" height="1">

</x-emailseqster>