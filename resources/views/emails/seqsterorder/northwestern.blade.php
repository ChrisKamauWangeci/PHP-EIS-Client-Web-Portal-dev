<x-emailseqster>

    <img src="https://www.expressimagingservices.com/img/northwesternmutual.png" alt="Northwestern Mutual">

    <br />
    <br />
    <strong>Medical Release Electronic Authorization Needed</strong>
    <br />
    <br />
    <br />
    Hello {{ str($seqsterorder->first_name)->lower()->title() }} {!! Helper::formatName($seqsterorder->last_name) !!},
    <br />
    <br />
    I am contacting you on behalf of Northwestern Mutual and your financial advisor {!! Helper::formatName($ehrworkorder->W_Agent ?? '') !!}.
    <br />
    My company, Express Imaging Services, partners with Northwestern Mutual to obtain medical records which are required to complete the review of your insurance application.
    <br />
    <br />
    Your assistance is needed to obtain your medical records from Veterans Affairs (VA).
    Please use the link below to begin the process of providing  electronic authorization for the release of your VA medical records.
    By  giving your approval directly with the VA, we can obtain your medical records within days instead of weeks or even months.
    <br />
    <br />
    <br />

    <table cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="left" bgcolor="#0A2340" style="background-color: #0A2340; margin: auto; max-width: 600px; border-radius: 4px; padding: 15px 20px;" width="100%">
                <a href="https://www.expressimagingservices.com/seqsterorders/step1/{{ $seqsterorder->uuid }}" target="_blank" style="font-size: 15px; color: #ffffff; font-weight:bold; text-align:center; background-color: #0A2340; text-decoration: none; border: none; border-radius: 4px; display: inline-block;">
                    <span style="font-size: 15px; color: #ffffff; font-weight:bold; line-height:1.5em; text-align:center;">CLICK TO BEGIN</span>
                </a>
            </td>
        </tr>
    </table>

    <br />
    <br />

    We understand that privacy and confidentiality are of utmost importance, and we assure you that your medical information will be handled with the highest level of security and discretion.
    Only necessary personnel involved in the insurance underwriting process will have access to your records, and they are bound by strict confidentiality agreements.
    Thank you for providing this approval at your earliest convenience to avoid delays in the processing of your insurance application.
    Should you have any questions or concerns regarding this authorization, please do not hesitate to contact us. Our team is here to assist you every step of the way and ensure a smooth and efficient process.
    <br />
    Thank you for your cooperation and prompt attention.
    <br />
    <br />
    Sincerely,<br />
    Zoe Hawkes (she/her)<br />
    888-846-8804 ext. 219<br />
    <br />

    <small>
        Financial Representative represents one or more, but not necessarily all of the entities shown.
        Recommendations and/or transactions involving equities and fixed income securities may only be offered and/or sold by appropriately registered and appointed representatives of NMIS or NMWMC.
        If you have any questions, please contact your Financial Representative.
        For general information, please visit us on the web at www.northwesternmutual.com.
        <br />
        <br />
        Add all communications from Northwestern Mutual to your address book to ensure notifications are not sent to your junk folder.
        <br />
        <br />
        If you feel you have received this message in error, or you did not make this request, please call Customer Service, (888) 846-8804, Monday - Friday 7:30am - 6:00pm CST.
        <br />
        <br />
        Note: This email was sent from a notifications-only email address. Please do not reply to this message.
        <br />
        <br />
        Copyright © 2026. The Northwestern Mutual Life Insurance Company. All Rights Reserved. Northwestern Mutual® is a trademark of The Northwestern Mutual Life Insurance Company.
        Northwestern Mutual is the marketing name for The Northwestern Mutual Life Insurance Company, 720 E. Wisconsin Ave., Milwaukee, WI 53202 (NM) (life and disability insurance, annuities, and life insurance with long-term care benefits), and its subsidiaries.
        Northwestern Long Term Care Insurance Company, Milwaukee, WI (NLTC) (long-term care insurance), is a subsidiary of NM. Northwestern Mutual Investment Services, LLC, Milwaukee, WI (NMIS) (securities), is a subsidiary of NM, broker-dealer, registered investment adviser, member FINRA and SIPC.
        Northwestern Mutual Wealth Management Company®, Milwaukee, WI (NMWMC) (fiduciary and fee-based financial planning services), is a subsidiary of NM and a federal savings bank.
        Investment products and trust services are not insured by the FDIC, are not deposits or other obligations of, or guaranteed by,
        NMWMC or its affiliates and are subject to investment risks, including possible loss of the principal amount invested.
        The products and services referenced are offered and sold only by appropriately appointed and licensed entities and representatives of such entities.
        Each Financial Representative represents one or more, but not necessarily all of the entities shown.
        Recommendations and/or transactions involving equities and fixed income securities may only be offered and/or sold by appropriately registered and appointed representatives of NMIS or NMWMC.
        If you have any questions, please contact your Financial Representative. For general information, please visit us on the web at www.northwesternmutual.com.
        <br />

    </small>

    <img src="https://www.expressimagingservices.com/seqsterorders/track?uuid={{ $seqsterorder->uuid }}" alt="" width="1" height="1">

</x-emailseqster>
