<?php

declare(strict_types=1);

namespace App\Helper;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Helper
{
    public static function highlightGroup(?string $value): string
    {
        if ($value === 'Risk Team') {
            return '<span class="text-danger">' . e($value) . '</span>';
        }
        if ($value === 'Shell') {
            return '<span class="text-success">' . e($value) . '</span>';
        }

        return e((string) $value);
    }

    public static function formatName($name)
    {
        $name = (string) Str::of($name)->lower()->title(); // 👈 FIX

        // Fix Mc (McNamara, McDonald)
        $name = preg_replace_callback('/\bMc([a-z])/', function ($matches) {
            return 'Mc' . strtoupper($matches[1]);
        }, $name);

        // Fix O'Brien
        $name = preg_replace_callback("/\b([A-Za-z]+)'([a-z])/", function ($matches) {
            return $matches[1] . "'" . strtoupper($matches[2]);
        }, $name);

        return $name;
    }

    public static function extractEmails(?string $input): array
    {
        if (is_null($input)) {
            return [];
        }

        return collect(preg_split('/[\s,;]+/', $input))
            ->map(fn ($email) => trim($email))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->toArray();
    }

    public static function locations()
    {
        return [
            'Manila Night Shift' => 'Manila Night Shift',
            'Pampanga Night Shift 1' => 'Pampanga Night Shift 1',
            'Pampanga Night Shift 2' => 'Pampanga Night Shift 2',
            'Pampanga Day Shift 1' => 'Pampanga Day Shift 1',
            'US Remote' => 'US Remote',
            'US Onsite' => 'US Onsite',
            'RCC Night Shift' => 'RCC Night Shift',
            'inactive' => 'Inactive',
        ];
    }

    public static function platforms()
    {
        return [
            'CLARETO' => 'CLARETO',
            'EIS' => 'EIS',
            'EPIC' => 'EPIC',
            'MIB' => 'MIB',
            'VERADIGM' => 'VERADIGM',
            'SEQSTER' => 'SEQSTER',
            'FASTEN_HEALTH' => 'FASTEN_HEALTH',
            'HERMES_HEALTH' => 'HERMES_HEALTH',
            'C3HIE' => 'C3HIE',
        ];
    }

    public static function ehrproviders()
    {
        return [
            'epic' => 'epic',
            'veradigm' => 'veradigm',
            'fasten_health' => 'fasten_health',
            'c3hie' => 'c3hie',
        ];
    }

    public static function ordertypes()
    {
        return [
            'APS' => 'APS',
            'EHR' => 'EHR',
            'EHL' => 'EHL',
            'SMARTACCESS' => 'SMARTACCESS',
            'CAREMAP360' => 'CAREMAP360',
        ];
    }

    public static function ordertypes1()
    {
        return [
            'APS' => 'APS',
            'EHR' => 'EHR',
            'EHL' => 'EHL',
        ];
    }

    public static function submissiontypes()
    {
        return [
            'auto' => 'auto',
            'nonauto' => 'nonauto',
        ];
    }

    public static function authorizationuploadtype($domain)
    {
        if ($domain == 'eisuat') {
            return [
                'replace' => 'replace',
                'append' => 'append',
            ];
        }

        return [
            'replace' => 'replace',
        ];
    }

    public static function coverPageSubdomain($session)
    {
        if ($session['subdomain'] == 'nyl') {
            return 'nyl';
        }
        if ($session['subdomain'] == 'usaa') {
            return 'usaa';
        }

        return 'www';
    }

    public static function coverPagePhone($session)
    {
        if ($session['subdomain'] == 'nyl') {
            return '(888) 846-8804';
        }
        if ($session['subdomain'] == 'usaa') {
            return '(888) 846-8804';
        }

        return '(888) 846-8804';
    }

    public static function coverPageFax($session)
    {
        if ($session['subdomain'] == 'nyl') {
            return '(310) 905-3257';
        }
        if ($session['subdomain'] == 'usaa') {
            return '(310) 905-3258';
        }

        return '(310) 905-3256';
    }

    public static function coverPageFaxAlt($session)
    {
        if ($session['subdomain'] == 'nyl') {
            return '(888) 905-5309';
        }
        if ($session['subdomain'] == 'usaa') {
            return '(888) 905-5309';
        }

        return '(888) 905-5308';
    }

    public static function coverPageEmail($session, $email)
    {
        return $email ?? 'records@expressimagingservices.com';
    }

    public static function number($number = null)
    {
        if (! $number) {
            return $number;
        }

        return number_format($number, 2);
    }

    public static function tracking($tracking = null)
    {

        if (! isset($tracking) || empty($tracking)) {
            return $tracking;
        }

        if (strlen((string) $tracking) == 12) {
            // FedEx
            return '<a href="https://www.fedex.com/apps/fedextrack/?tracknumbers=' . $tracking . '" target="_blank">' . $tracking . '</a>';
        }

        if (strlen((string) $tracking) == 18) {
            // UPS
            return '<a href="https://www.ups.com/track?loc=en_US&tracknum=' . $tracking . '" target="_blank">' . $tracking . '</a>';
        }

        if (strlen((string) $tracking) == 22) {
            // USPS
            return '<a href="https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=' . $tracking . '" target="_blank">' . $tracking . '</a>';
        }

        return $tracking;
    }

    public static function ssn($usersession, $ssn, $force = null)
    {
        if (! $force) {
            if ($usersession['contractor']['accesslevel']) {
                return $ssn;
            }
        }
        if (isset($ssn) && ! empty($ssn) && is_numeric(substr($ssn, -4))) {
            // return 'xxx-xx-xxxx';
            return 'xxx-xx-' . substr($ssn, -4);
        }
    }

    public static function dateFormat($date, $format = null, $extra = null)
    {
        if (! empty($date)) {
            if (! empty($format)) {
                return $date->format($format) . $extra;
            }

            return $date->format('m/d/Y') . $extra;
        }
    }

    public static function formatPhoneFax($phoneOrig = null)
    {
        if (! $phoneOrig) {
            return $phoneOrig;
        }

        $digits = preg_replace('/\D/', '', $phoneOrig);

        if (strlen($digits) === 11) {
            return preg_replace("/^(\d{1})(\d{3})(\d{3})(\d{4})$/", '$1-$2-$3-$4', $digits);
        }

        if (strlen($digits) === 10) {
            return preg_replace("/^(\d{3})(\d{3})(\d{4})$/", '$1-$2-$3', $digits);
        }

        return $phoneOrig;
    }

    public static function faxStatus($status)
    {
        $statuses = [
            'Completed' => 'text-success',
            'Failed' => 'text-danger',
        ];
        if (array_key_exists($status, $statuses)) {
            return '<span class="' . $statuses[$status] . '">' . $status . '</span>';
        }

        return $status;
    }

    public static function badge($badge)
    {
        if ($badge) {
            $badgeClass = 'badge-success';
            $badgeName = 'Yes';
        } else {
            $badgeClass = 'badge-danger';
            $badgeName = 'No';
        }

        return '<span class="badge ' . $badgeClass . '">' . $badgeName . '</span>';
    }

    public static function yesNo($badge, $button = false)
    {
        if ($badge) {
            $badgeClass = 'badge-success';
            $badgeName = 'Yes';
        } else {
            $badgeClass = 'badge-danger';
            $badgeName = 'No';
        }
        if (! $button) {
            return $badgeName;
        }

        return '<span class="badge ' . $badgeClass . '">' . $badgeName . '</span>';
    }

    public static function labelColor($label)
    {
        $labels = [
            'valid' => 'text-success fw-bold text-uppercase',
            'expiring' => 'text-warning fw-bold text-uppercase',
            'expired' => 'text-danger fw-bold text-uppercase',
            'invalid' => 'text-danger fw-bold text-uppercase',
        ];
        if (array_key_exists($label, $labels)) {
            return '<span class="' . $labels[$label] . '">' . $label . '</span>';
        } else {
            return '<span class="' . $labels['invalid'] . '">' . $label . '</span>';
        }
    }

    public static function urgent($urgent)
    {
        if ($urgent) {
            return 'Urgent';
        } else {
            return 'Not Urgent';
        }
    }

    public static function urgentIcons($urgent)
    {
        if ($urgent) {
            return '<i class="fa-solid fa-exclamation-triangle text-danger"></i>';
        }
    }

    public static function method($method)
    {
        $options = [
            1 => 'Fax',
            2 => 'Fed Ex',
            3 => 'Mail',
            4 => 'Hand Serve',
            5 => 'E-mail',
        ];
        if (array_key_exists($method, $options)) {
            return $options[$method];
        }
    }

    public static function requirementoptions()
    {
        $options = [
            1 => 'Rejected for E-Signature',
            2 => 'TPO Statement Required',
            3 => 'Revocation Statement Required',
            4 => 'Facility Information Required',
            5 => 'Sensitive Information',
            6 => 'Illegible Form Provided',
            8 => 'Voice Signature Required',
            9 => 'Date of Signature Required',
            10 => 'Form Requested Per Requestor',
            11 => 'Facility Form Required',
            12 => 'Rejected for Docu-sign',
            13 => 'Disclosure/Redisclosure Statement Required',
            14 => 'Additional Patient Information Required',
            15 => 'Invalid Form Provided',
            16 => 'Other',
            17 => 'Rejected For Voice Signature',
        ];

        return $options;
    }

    public static function requirementoption($value = null)
    {
        $options = [
            1 => 'Rejected for E-Signature',
            2 => 'TPO Statement Required',
            3 => 'Revocation Statement Required',
            4 => 'Facility Information Required',
            5 => 'Sensitive Information',
            6 => 'Illegible Form Provided',
            8 => 'Voice Signature Required',
            9 => 'Date of Signature Required',
            10 => 'Form Requested Per Requestor',
            11 => 'Facility Form Required',
            12 => 'Rejected for Docu-sign',
            13 => 'Disclosure/Redisclosure Statement Required',
            14 => 'Additional Patient Information Required',
            15 => 'Invalid Form Provided',
            16 => 'Other',
            17 => 'Rejected For Voice Signature',
        ];
        if ($value && array_key_exists($value, $options)) {
            return $options[$value];
        }
    }

    public static function statusesIcons($status)
    {
        $statuses = [
            'Complete' => 'fa-regular fa-check-square text-success',
            'Incomplete' => 'fa-regular fa-list-alt text-warning',
            'Cancel' => 'fa-regular fa-window-close text-secondary',
            'Duplicate' => 'fa-regular fa-clone text-info',
            'Delete' => 'fa-regular fa-trash-can text-danger',
        ];
        if (array_key_exists($status, $statuses)) {
            return '<i class="' . $statuses[$status] . '"></i>';
        }
    }

    public static function statuses()
    {
        $options = [
            'Incomplete' => 'Incomplete',
            'Complete' => 'Complete',
            'Cancel' => 'Cancel',
            'Duplicate' => 'Duplicate',
            'Delete' => 'Delete',
        ];

        return $options;
    }

    public static function workorderrequestStatus($status)
    {
        $options = [
            'new' => 'fa-regular fa-list-alt text-warning',
            'pending' => 'fa-regular fa-tasks text-primary',
            'canceled' => 'fa-regular fa-window-close text-secondary',
            'completed' => 'fa-regular fa-check-square text-success',
        ];
        if (array_key_exists($status, $options)) {
            return '<i class="' . $options[$status] . '"></i> ' . $status;
        }
    }

    public static function docusignstatus($value = null)
    {
        $options = [
            'envelope-completed' => 'bg-success-subtle',
        ];
        if (array_key_exists($value, $options)) {
            return $options[$value];
        }

        return $value;
    }

    public static function sendmethod($key = null)
    {
        $options = [
            '1' => 'Faxed request to',
            '2' => 'FedEx request',
            '3' => 'Mailed request to',
            '4' => 'Mailed request to',
            '5' => 'Email request to',
        ];

        return $options[$key] ?? null;
    }

    public static function recordYears()
    {
        return [
            'ALL' => 'Entire Chart',
            'OTH' => 'Other',
            '1' => '1 Year',
            '2' => '2 Years',
            '3' => '3 Years',
            '4' => '4 Years',
            '5' => '5 Years',
            '6' => '6 Years',
            '7' => '7 Years',
            '10' => '10 Years',
        ];
    }

    public static function recordYear($key = null)
    {
        $options = [
            'ALL' => 'Entire Chart',
            'OTH' => 'Other',
            '1' => '1 Year',
            '2' => '2 Years',
            '3' => '3 Years',
            '4' => '4 Years',
            '5' => '5 Years',
            '6' => '6 Years',
            '7' => '7 Years',
            '10' => '10 Years',
        ];

        if (isset($key)) {
            if (array_key_exists($key, $options)) {
                return $options[$key];
            }
        }

        return '';
    }

    public static function recordYearsFrom($value = null, $W_ReceiveDate = null, $W_DOB = null, $format = 'm/d/Y')
    {
        $options = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '10' => '10',
        ];

        if (array_key_exists($value, $options)) {
            $receivedate = new Carbon($W_ReceiveDate);
            $fromdate = $receivedate->modify('-' . $value . ' years');

            return '' . $fromdate->format($format);
        }

        if ($value == 'OTH') {
            return 'Other';
        }

        if ($value == 'ALL') {
            if ($W_DOB) {
                $date = new Carbon($W_DOB);

                return $date->format($format);
            }

            return 'Entire Chart';
        }

        return '';
    }

    public static function recordYearsTo($value = null, $W_ReceiveDate = null, $W_DOB = null, $format = 'm/d/Y')
    {
        $options = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '10' => '10',
        ];

        if (array_key_exists($value, $options)) {
            if ($W_ReceiveDate) {
                $receivedate = new Carbon($W_ReceiveDate);

                return $receivedate->format($format);
            }

            return date($format);
        }

        if ($value == 'OTH') {
            return 'Other';
        }

        if ($value == 'ALL') {
            return 'Entire Chart';
        }

        return '';
    }

    public static function recordYearsFromTo($value = null, $W_ReceiveDate = null, $W_DOB = null, $session = null, $format = 'm/d/Y')
    {

        $options = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '10' => '10',
        ];

        if (array_key_exists($value, $options)) {
            $receivedate = new Carbon($W_ReceiveDate);
            $receivedate1 = new Carbon($W_ReceiveDate);
            $fromdate = $receivedate->modify('-' . $value . ' years');

            if (isset($session) && $session['subdomain'] != 'usaa') {
                return $fromdate->format($format) . ' - PRESENT';
            }

            return $fromdate->format($format) . ' - ' . $receivedate1->format($format);
        }

        if ($value == 'OTH') {
            return 'OTHER';
        }

        if ($value == 'ALL') {
            if ($W_DOB) {
                $date = new Carbon($W_DOB);
                $receivedate1 = new Carbon($W_ReceiveDate);

                if (isset($session) && $session['subdomain'] != 'usaa') {
                    return $date->format($format) . ' - PRESENT';
                }

                return $date->format($format) . ' - ' . $receivedate1->format($format);
            }

            return 'ENTIRE CHART';
        }

        return 'ENTIRE CHART';
    }

    public static function requesttypes()
    {
        $options = [
            'CANCELPAYMENT' => 'CANCEL PAYMENT',
            'CC REQUEST' => 'CC REQUEST',
            'CHECK WITH DRIVER' => 'CHECK WITH DRIVER',
            'EMAIL CC INFO' => 'EMAIL CC INFO',
            'EMAIL CC INFO TO COPYSERVICE' => 'EMAIL CC INFO TO COPYSERVICE',
            'FAX' => 'FAX',
            'FAX CC INFO' => 'FAX CC INFO',
            'FAX COPY OF CHECK' => 'FAX COPY OF CHECK',
            'FAX FOLLOW UP' => 'FAX FOLLOW UP',
            'MAIL' => 'MAIL',
            'ONLINE CC PAYMENT' => 'ONLINE CC PAYMENT',
            'OVERNIGHT' => 'OVERNIGHT',
            'OVERNIGHT BLANK CHECK' => 'OVERNIGHT BLANK CHECK',
            'OVERNIGHT WITH PAYMENT' => 'OVERNIGHT WITH PAYMENT',
            'PAYMENT BY CC' => 'PAYMENT BY CC',
            'PAYMENT BY MAIL' => 'PAYMENT BY MAIL',
            'PAYMENT BY MAIL BLANK CHECK' => 'PAYMENT BY MAIL BLANK CHECK',
            'PAYMENT CC TO COPYSERVICE' => 'PAYMENT CC TO COPYSERVICE',
            'RE-FAX' => 'RE-FAX',
            'REFUND FROM COPYSERVICE' => 'REFUND FROM COPYSERVICE',
            'REFUND FROM FACILITY' => 'REFUND FROM FACILITY',
            'REQUEST TO EXPORT' => 'REQUEST TO EXPORT',
            'URGENT PAYMENT' => 'URGENT PAYMENT',
        ];
        asort($options);

        return $options;
    }

    public static function ticketstatuses()
    {
        return [
            'open' => 'open',
            'closed' => 'closed',
        ];
    }

    public static function ticketpriorities()
    {
        return [
            'medium' => 'Medium',
            'high' => 'High',
            'low' => 'Low',
        ];
    }

    public static function ticketStatusIcon(string $status): string
    {
        $options = [
            'open' => '<i class="fa-fw fa-solid fa-folder-open text-warning"></i>',
            'closed' => '<i class="fa-fw fa-solid fa-square-check text-success"></i>',
        ];

        return $options[$status] ?? '';
    }

    public static function businessHours()
    {
        return [
            '6:00:00 AM' => '6:00:00 AM',
            '6:30:00 AM' => '6:30:00 AM',
            '7:00:00 AM' => '7:00:00 AM',
            '7:30:00 AM' => '7:30:00 AM',
            '8:00:00 AM' => '8:00:00 AM',
            '8:30:00 AM' => '8:30:00 AM',
            '9:00:00 AM' => '9:00:00 AM',
            '9:30:00 AM' => '9:30:00 AM',
            '10:00:00 AM' => '10:00:00 AM',
            '10:30:00 AM' => '10:30:00 AM',
            '11:00:00 AM' => '11:00:00 AM',
            '11:30:00 AM' => '11:30:00 AM',
            '12:00:00 PM' => '12:00:00 PM',
            '12:30:00 PM' => '12:30:00 PM',
            '1:00:00 PM' => '1:00:00 PM',
            '1:30:00 PM' => '1:30:00 PM',
            '2:00:00 PM' => '2:00:00 PM',
            '2:30:00 PM' => '2:30:00 PM',
            '3:00:00 PM' => '3:00:00 PM',
            '3:30:00 PM' => '3:30:00 PM',
            '4:00:00 PM' => '4:00:00 PM',
            '4:30:00 PM' => '4:30:00 PM',
            '5:00:00 PM' => '5:00:00 PM',
            '5:30:00 PM' => '5:30:00 PM',
            '6:00:00 PM' => '6:00:00 PM',
        ];
    }

    public static function states($id = null)
    {
        $options = [
            'OT' => 'OTHER',
            'AL' => 'AL Alabama',
            'AK' => 'AK Alaska',
            'AS' => 'AS American Samoa',
            'AZ' => 'AZ Arizona',
            'AR' => 'AR Arkansas',
            'AE' => 'AE Armed Forces Africa',
            'AA' => 'AA Armed Forces Americas',
            'AE' => 'AE Armed Forces Canada',
            'AE' => 'AE Armed Forces Europe',
            'AE' => 'AE Armed Forces Middle East',
            'AP' => 'AP Armed Forces Pacific',
            'CA' => 'CA California',
            'CO' => 'CO Colorado',
            'CT' => 'CT Connecticut',
            'DE' => 'DE Delaware',
            'DC' => 'DC District of Columbia',
            'FM' => 'FM Federated States of Micronesia',
            'FL' => 'FL Florida',
            'GA' => 'GA Georgia',
            'GU' => 'GU Guam',
            'HI' => 'HI Hawaii',
            'ID' => 'ID Idaho',
            'IL' => 'IL Illinois',
            'IN' => 'IN Indiana',
            'IA' => 'IA Iowa',
            'KS' => 'KS Kansas',
            'KY' => 'KY Kentucky',
            'LA' => 'LA Louisiana',
            'ME' => 'ME Maine',
            'MH' => 'MH Marshall Islands',
            'MD' => 'MD Maryland',
            'MA' => 'MA Massachusetts',
            'MI' => 'MI Michigan',
            'MN' => 'MN Minnesota',
            'MS' => 'MS Mississippi',
            'MO' => 'MO Missouri',
            'MT' => 'MT Montana',
            'NE' => 'NE Nebraska',
            'NV' => 'NV Nevada',
            'NH' => 'NH New Hampshire',
            'NJ' => 'NJ New Jersey',
            'NM' => 'NM New Mexico',
            'NY' => 'NY New York',
            'NC' => 'NC North Carolina',
            'ND' => 'ND North Dakota',
            'MP' => 'MP Norther Mariana Islands',
            'OH' => 'OH Ohio',
            'OK' => 'OK Oklahoma',
            'OR' => 'OR Oregon',
            'PA' => 'PA Pennsylvania',
            'PR' => 'PR Puerto Rico',
            'PW' => 'PW Palau',
            'RI' => 'RI Rhode Island',
            'SC' => 'SC South Carolina',
            'SD' => 'SD South Dakota',
            'TN' => 'TN Tennessee',
            'TX' => 'TX Texas',
            'UT' => 'UT Utah',
            'VT' => 'VT Vermont',
            'VI' => 'VI Virgin Islands',
            'VA' => 'VA Virginia',
            'WA' => 'WA Washington',
            'WV' => 'WV West Virginia',
            'WI' => 'WI Wisconsin',
            'WY' => 'WY Wyoming',
        ];
        if ($id) {
            if (isset($options[$id])) {
                return $options[$id];
            }
        } else {
            return $options;
        }
    }

    public static function integrationid($id = null)
    {

        $options = [
            1 => 'Website Order',
            2 => 'Website Order',
            3 => 'Website Order',
            10 => 'SmartOffice',
            22 => 'Northwestern Mutual',
            28 => 'Protective',
            30 => 'Transamerica',
            40 => 'NFP',
            50 => 'Agency Integrator',
            55 => 'Ladder Life',
            62 => 'Equitable',
            69 => 'Nationwide',
            70 => 'NIIT',
            80 => 'Transamerica LTC',
            85 => 'OneHQ',
            88 => 'USAA',
            90 => 'NYL',
            94 => 'Northwestern Mutual LTC',
        ];

        if ($id) {
            if (isset($options[$id])) {
                return $options[$id];
            }
        }

        return false;
    }

    public static function timezones($timezone = null)
    {
        $timezones = [
            'AK' => -1,
            'AL' => 2,
            'AR' => 2,
            'AZ' => 0,
            'CA' => 0,
            'CO' => 1,
            'CT' => 3,
            'DC' => 3,
            'DE' => 3,
            'FL' => 3,
            'GA' => 3,
            'HI' => -3,
            'IA' => 2,
            'ID' => 1,
            'IL' => 2,
            'IN' => 2,
            'KS' => 2,
            'KY' => 3,
            'LA' => 2,
            'MA' => 3,
            'MD' => 3,
            'ME' => 3,
            'MI' => 3,
            'MN' => 2,
            'MO' => 2,
            'MS' => 2,
            'MT' => 1,
            'NC' => 3,
            'ND' => 2,
            'NE' => 2,
            'NH' => 3,
            'NJ' => 3,
            'NM' => 1,
            'NV' => 0,
            'NY' => 3,
            'OH' => 3,
            'OK' => 2,
            'OR' => 0,
            'PA' => 3,
            'PR' => 4,
            'RI' => 3,
            'SC' => 3,
            'SD' => 2,
            'TN' => 2,
            'TX' => 2,
            'UT' => 1,
            'VA' => 3,
            'VT' => 3,
            'WA' => 0,
            'WI' => 2,
            'WV' => 3,
            'WY' => 1,
        ];

        if ($timezone) {
            if (array_key_exists($timezone, $timezones)) {
                return $timezones[$timezone];
            }

            return;
        }
    }
}
