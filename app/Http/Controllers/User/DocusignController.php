<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDocusignRequest;
use App\Mail\DocusignaccesscodeEmail;
use App\Models\Docusigndocument;
use App\Models\Facilityform;
use App\Models\Statustrigger;
use App\Models\Workorder;
use App\Services\DocusignService;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Model\CarbonCopy;
use DocuSign\eSign\Model\CompositeTemplate;
use DocuSign\eSign\Model\EnvelopeDefinition;
use DocuSign\eSign\Model\InlineTemplate;
use DocuSign\eSign\Model\Notification;
use DocuSign\eSign\Model\Recipients;
use DocuSign\eSign\Model\RecipientViewRequest;
use DocuSign\eSign\Model\ServerTemplate;
use DocuSign\eSign\Model\Signer;
use DocuSign\eSign\Model\Tabs;
use DocuSign\eSign\Model\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DocusignController extends Controller
{
    public function setup(Request $request)
    {
        foreach ($request->input() as $key => $value) {
            $data[$key] = $value;
        }

        $data['special_instructions'] = '';

        $sara['data'] = $data;
        $sara['slug'] = $request->input('slug');
        $sara['facility_dr'] = $request->input('facility_dr');

        $facilityform = Facilityform::query()
            ->where('slug', $sara['slug'])
            ->first();

        if (! $facilityform->docusign_templateid_production && ! $facilityform->docusign_templateid_test) {
            return back()->with('danger', 'Docusign Template ID not found for: ' . $facilityform->name);
        }

        $sara['production']['template_id'] = $facilityform->docusign_templateid_production;
        $sara['test']['template_id'] = $facilityform->docusign_templateid_test;

        $sara['emailsubject'] = 'Medical Authorization - Next Step';
        $sara['emailbody'] = view('emails.docusign.eis', $sara['data'])->render();

        $sara['data']['access_code'] = rand(1000, 9999);

        if ($request->input('company') == 'PLICO-WCL') {
            $sara['data']['signingtype'] = 'email';
            $sara['emailsubject'] = 'Regarding your application with Plico';
            $sara['emailbody'] = view('emails.docusign.plico', $sara['data'])->render();
        }

        if ($request->input('insurance') == 'PROTECTIVE LIFE - PIM HOME OFFICE') {
            $sara['data']['signingtype'] = 'email';
            $sara['emailsubject'] = 'Regarding your application with Protective Life Insurance';
            $sara['emailbody'] = view('emails.docusign.protective', $sara['data'])->render();
        }

        if ($request->input('company') == 'PRUDENTIAL INSURANCE COMPANY OF AMERICA') {
            $sara['data']['signingtype'] = 'email';
            $sara['data']['brand_id'] = '3b96e4b8-094b-416a-b8eb-420d4c8e3785';
            $sara['emailsubject'] = 'Regarding your application with Prudential';
            $sara['emailbody'] = view('emails.docusign.prudential', $sara['data'])->render();
        }

        if ($request->input('company') == 'NATIONWIDE LIFE UNDERWRITING') {
            $sara['data']['signingtype'] = 'email';
            $sara['data']['brand_id'] = '215a3ada-fe3a-4b71-bd70-c23d4b518066';
            $sara['emailsubject'] = 'Regarding your application with Nationwide';
            $sara['emailbody'] = view('emails.docusign.nationwide', $sara['data'])->render();
        }

        if ($request->input('company') == 'BESTOW AGENCY LLC') {
            $sara['data']['signingtype'] = 'email';
            $sara['emailsubject'] = 'Regarding your application with Nationwide';
            $sara['emailbody'] = view('emails.docusign.bestow', $sara['data'])->render();
        }

        if ($request->input('company') == 'NORTHWESTERN MUTUAL' || $request->input('company') == 'NORTHWESTERN MUTUAL LTC') {
            $sara['data']['signingtype'] = 'email';
            $sara['data']['brand_id'] = '3eaa2343-2820-4d97-a15c-d1e642747698';
            $sara['emailsubject'] = 'Regarding your application with Northwestern Mutual - ' . $sara['data']['facility_name'];
            $sara['emailbody'] = view('emails.docusign.northwesternmutual', $sara['data'])->render();
        }

        if ($sara['data']['company'] == 'MASSMUTUAL') {
            $sara['data']['signingtype'] = 'email';
            $sara['data']['brand_id'] = '51de8b7a-7a80-40bf-848c-c12f35a19015';
            $sara['emailsubject'] = 'Regarding your application with MassMutual - ' . $sara['data']['facility_name'];
            $sara['emailbody'] = view('emails.docusign.massmutual', $sara['data'])->render();
        }

        if ($sara['data']['company'] == 'CATHOLIC ORDER OF FORESTERS') {
            $sara['data']['signingtype'] = 'email';
            $sara['emailsubject'] = 'Regarding your application with Catholic Order Of Foresters - ' . $sara['data']['facility_name'];
            $sara['emailbody'] = view('emails.docusign.catholicorderofforesters', $sara['data'])->render();
        }

        $sara['emailsubject'] = Str::limit($sara['emailsubject'], 90);

        session(['sara' => $sara]);

        return redirect()
            ->route('user.docusigns.index');
    }

    public function index(Request $request)
    {
        $sara = session('sara');

        if (! $sara) {
            return redirect()
                ->route('user.workorders.index');
        }

        return view('user.docusigns.index', compact('sara'));
    }

    public function edit()
    {
        $sara = session('sara');

        if (! $sara) {
            return redirect()
                ->route('user.workorders.index');
        }

        return view('user.docusigns.edit', compact('sara'));
    }

    public function update(UpdateDocusignRequest $request)
    {
        $validated = $request->validated();

        session([
            'sara.emailsubject' => $validated['emailsubject'],
            'sara.emailbody' => $validated['emailbody'],
        ]);
        unset($validated['emailsubject']);
        unset($validated['emailbody']);

        session(['sara.data' => $validated + session('sara.data')]);

        return redirect()
            ->route('user.docusigns.index')
            ->with('success', 'Data has been saved');
    }

    public function sign(Request $request, DocusignService $docusignService)
    {
        $sara = session('sara');

        if (! $sara) {
            return redirect()
                ->route('user.workorders.index');
        }

        $environment = $sara['data']['environment'];

        $basepath = 'account-d.docusign.com';

        if ($environment == 'production') {
            $basepath = 'account.docusign.com';
        }

        $apiClient = new ApiClient();
        $apiClient->getOAuth()->setOAuthBasePath($basepath);
        // print_r($apiClient);
        // die;

        $accessToken = $docusignService->getToken($environment);
        // dd($accessToken);

        $userInfo = $apiClient->getUserInfo($accessToken);
        // print_r($userInfo);
        $account_id = $userInfo[0]['accounts'][0]['account_id'];
        $accountInfo = $userInfo[0]->getAccounts();

        $apiClient->getConfig()->setHost($accountInfo[0]->getBaseUri() . '/restapi');

        $envelopeDefinition = $this->buildEnvelope();

        try {
            $envelopeApi = new EnvelopesApi($apiClient);

            $result = $envelopeApi->createEnvelope($accountInfo[0]->getAccountId(), $envelopeDefinition);

            $envelopeid = $result->getEnvelopeId();

            $docusigndocument = new Docusigndocument();
            $docusigndocument->workorder_id = $sara['data']['workorder_id'];
            $docusigndocument->db = $sara['data']['db'];
            $docusigndocument->slug = $sara['data']['slug'];
            $docusigndocument->client = $sara['data']['client'];
            $docusigndocument->environment = $sara['data']['environment'];
            $docusigndocument->signingtype = $sara['data']['signingtype'];
            $docusigndocument->facility = $sara['data']['facility_dr'];
            $docusigndocument->templateid = $sara[$sara['data']['environment']]['template_id'];
            $docusigndocument->company = 'EIS';
            $docusigndocument->requestor = session('user.contractor.C_Name');
            $docusigndocument->first_name = $sara['data']['patient_first_name'];
            $docusigndocument->middle_name = $sara['data']['patient_middle_name'];
            $docusigndocument->last_name = $sara['data']['patient_last_name'];
            $docusigndocument->birth_date = $sara['data']['patient_birth_date'];
            $docusigndocument->social_security = $sara['data']['patient_social_security'];
            $docusigndocument->phone = $sara['data']['patient_phone'];
            $docusigndocument->email = $sara['data']['patient_email'];
            $docusigndocument->address = $sara['data']['patient_address'];
            $docusigndocument->city = $sara['data']['patient_city'];
            $docusigndocument->state = $sara['data']['patient_state'];
            $docusigndocument->zip_code = $sara['data']['patient_zip_code'];
            $docusigndocument->access_code = $sara['data']['access_code'];
            $docusigndocument->dates_of_service_from = $sara['data']['dates_of_service_from'];
            $docusigndocument->raw_data = print_r(session('sara'), true);
            $docusigndocument->ip_address = request()->ip();
            $docusigndocument->remote_host = gethostbyaddr(request()->ip());
            $docusigndocument->envelopeid = $envelopeid;
            $docusigndocument->save();

            $workorder = Workorder::query()
                ->where('W_WorkOrder', $sara['data']['workorder_id'])
                ->first();

            $workorder->W_FollowUpStatus = 'Docusign Prefill Created, ID: ' . $docusigndocument->id . ' (' . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus;
            $workorder->W_Owner = 'DOCUSIGN CALL PATIENT';
            $workorder->save();

            $statustrigger = new Statustrigger();
            $statustrigger->WorkOrderNo = $workorder->W_WorkOrder;
            $statustrigger->statuscode = 619;
            $statustrigger->laststatus = '619: ACTION REQUIRED(SPECIAL AUTHORIZATION): Special Authorization has been sent to the applicant for signature through S.A.R.A. EIS will follow up with the applicant directly. No further action is required from the carrier at this time. Call back set for ' . now()->addWeekdays(4)->format('m/d/Y') . ' (' . date('g:i:s A') . ')';
            $statustrigger->Created = now();
            $statustrigger->CreatedBy = session('user.contractor.C_Name');
            $statustrigger->ChangeType = 'S';
            $statustrigger->save();

            $docusignService->download($docusigndocument);

            if ($sara['data']['signingtype'] != 'email') {
                $recipient_view_request = new RecipientViewRequest([
                    'authentication_method' => 'None',
                    'client_user_id' => 1000,
                    'return_url' => 'https://' . request()->getHost() . '/user/docusigndocuments',
                    'user_name' => $sara['data']['patient_first_name'] . ' ' . $sara['data']['patient_last_name'],
                    'email' => $sara['data']['patient_email'],
                ]);
                $results = $envelopeApi->createRecipientView($account_id, $envelopeid, $recipient_view_request);

                session()->forget('sara');

                $url = filter_var($results['url'], FILTER_SANITIZE_URL);

                return redirect()
                    ->away($url);
                // print_r($results);
                // die;
                // return redirect()
                //     ->to($results['url']);
            }

            $docusigndocument->downloaded_at = null;
            $docusigndocument->save();

            $sara['data']['id'] = $docusigndocument->id;

            $data['from'] = 'sign@expressimagingservices.com';
            $data['subject'] = 'Secure Access Code for Your Authorization Request - ' . $sara['data']['facility_name'];
            $data['data'] = $sara;
            $data['view'] = 'emails.docusignaccesscode';
            Mail::mailer('smtprelaygmail')
                ->to($sara['data']['patient_email'])
                ->send(new DocusignaccesscodeEmail($data));

            session()->forget('sara');

            return redirect()
                ->route('user.docusigndocuments.index')
                ->with('success', 'Docusign Email Started');
        } catch (\Throwable $th) {
            print_r($th);
            exit;
            // return back()->withError($th->getMessage())->withInput();
        }

        // dd($docusign);
    }

    protected function buildEnvelope(): EnvelopeDefinition
    {
        $sara = session('sara');

        if ($sara['data']['signingtype'] == 'email') {
            $notification = new Notification();
            $notification->setUseAccountDefaults('true');
            // $notification->setUseAccountDefaults('false');
            // $reminders = new \DocuSign\eSign\Model\Reminders();
            // $reminders->setReminderEnabled('true');
            // $reminders->setReminderDelay('1');
            // $reminders->setReminderFrequency('1');
            // $expirations = new \DocuSign\eSign\Model\Expirations();
            // $expirations->setExpireEnabled('true');
            // $expirations->setExpireAfter('40');
            // $expirations->setExpireWarn('3');
            // $notification->setExpirations($expirations);
            // $notification->setReminders($reminders);
        } else {
            $notification = new Notification();
        }

        $envelopeDefinitionData = [
            'email_subject' => $sara['emailsubject'],
            'email_blurb' => $sara['emailbody'],
            'status' => 'sent',
            'notification' => $notification,
            'envelope_id_stamping' => 'false',
        ];

        if (! empty($sara['data']['brand_id'])) {
            $envelopeDefinitionData['brand_id'] = $sara['data']['brand_id'];
        }

        $envelope_definition = new EnvelopeDefinition($envelopeDefinitionData);

        $patient_email = new Text([
            'tab_label' => 'patient_email',
            'locked' => true,
            'value' => $sara['data']['patient_email'],
        ]);

        $patient_full_name = new Text([
            'tab_label' => 'patient_full_name',
            'locked' => true,
            'value' => $sara['data']['patient_first_name'] . ' ' . $sara['data']['patient_middle_name'] . ' ' . $sara['data']['patient_last_name'],
        ]);

        $expiration_date = new Text([
            'tab_label' => 'expiration_date',
            'locked' => true,
            'value' => date('m/d/Y', strtotime('+1 year')),
        ]);

        $expiration_date_ymd = new Text([
            'tab_label' => 'expiration_date_ymd',
            'locked' => true,
            'value' => date('Y-m-d', strtotime('+1 year')),
        ]);

        foreach ($sara['data'] as $key => $value) {
            $$key = new Text([
                'tab_label' => $key,
                'locked' => true,
                'value' => trim((string) $value) ?? '',
            ]);
        }

        // $eis_email = new Text([
        //     'tab_label' => 'eis_email',
        //     'locked' => true,
        //     'value' => 'records@expressimagingservices.com',
        // ]);
        // $eis_email,

        $tabs = new Tabs([
            'text_tabs' => [
                $db,
                $workorder_id,
                $patient_first_name,
                $patient_middle_name,
                $patient_last_name,
                $patient_full_name,
                $patient_birth_date,
                $patient_birth_date_mdy,
                $patient_social_security,
                $patient_social_security_full,
                $patient_phone,
                $patient_address,
                $patient_city,
                $patient_state,
                $patient_zip_code,
                $patient_city_state_zip,
                $patient_full_address,
                $dates_of_service_from,
                $dates_of_service_to,
                $dates_of_service_combined,
                $dates_of_service_combined_ymd,
                $special_instructions,
                $eis_insurance,
                $eis_fax,
                $expiration_date,
                $expiration_date_ymd,
                $facility_dr,
                $facility_name,
                $facility_address,
                $facility_city,
                $facility_state,
                $facility_zip_code,
                $facility_city_state_zip,
                $facility_full_address,
                $facility_phone,
            ],
            'email_tabs' => [$patient_email],
        ]);

        // echo "<pre>";
        // print_r($tabs);
        // die;

        $serverTemplate = new ServerTemplate([
            'template_id' => $sara[$sara['data']['environment']]['template_id'],
            'sequence' => '1',
        ]);

        if ($sara['data']['signingtype'] == 'email' && $sara['data']['access_code']) {
            $signer = new Signer([
                'name' => $sara['data']['patient_first_name'] . ' ' . $sara['data']['patient_last_name'],
                'email' => $sara['data']['patient_email'],
                'role_name' => 'signer',
                'recipient_id' => '1',
                'tabs' => $tabs,
                'access_code' => $sara['data']['access_code'],
                'routing_order' => '1',
            ]);

            $recipients = new Recipients([
                'signers' => [$signer],
            ]);

            $company = $sara['data']['company'] ?? null;

            // $companyCcMap = [
            //     'NORTHWESTERN MUTUAL' => 'underwriting@northwesternmutual.com',
            //     'NORTHWESTERN MUTUAL LTC' => 'ltc-underwriting@northwesternmutual.com',
            // ];

            $agentCcCompanies = [
                'NORTHWESTERN MUTUAL',
                'NORTHWESTERN MUTUAL LTC',
                'MASSMUTUAL',
            ];

            $carbonCopies = [];
            $carbonCopiesEmails = [];

            // if (isset($companyCcMap[$company])) {
            //     $carbonCopies[] = new CarbonCopy([
            //         'name' => $company,
            //         'email' => $companyCcMap[$company],
            //         'role_name' => 'cc',
            //         'recipient_id' => '2',
            //         'routing_order' => '1',
            //     ]);
            //     $carbonCopiesEmails[] = $companyCcMap[$company];
            // }

            if ($company === 'MASSMUTUAL') {
                $requestorEmail = $this->getFirstValidEmail($sara['data']['requestor_email'] ?? null);

                if ($requestorEmail) {
                    $carbonCopies[] = new CarbonCopy([
                        'name' => $sara['data']['requestor_name'] ?? $company,
                        'email' => $requestorEmail,
                        'role_name' => 'cc',
                        'recipient_id' => '2',
                        'routing_order' => '1',
                    ]);
                    $carbonCopiesEmails[] = $requestorEmail;
                }
            }

            if (in_array($company, $agentCcCompanies, true)) {

                $agentEmail = $this->getFirstValidEmail($sara['data']['agent_email'] ?? null);

                if ($agentEmail) {
                    $carbonCopies[] = new CarbonCopy([
                        'name' => $sara['data']['agent'] ?? $company,
                        'email' => $agentEmail,
                        'role_name' => 'cc',
                        'recipient_id' => '3',
                        'routing_order' => '1',
                    ]);
                    $carbonCopiesEmails[] = $agentEmail;
                }
            }

            if (! empty($carbonCopies)) {
                $recipients->setCarbonCopies($carbonCopies);
                session(['sara.cc_emails' => implode(', ', $carbonCopiesEmails)]);
            }

        } else {
            $signer = new Signer([
                'name' => $sara['data']['patient_first_name'] . ' ' . $sara['data']['patient_last_name'],
                'email' => $sara['data']['patient_email'],
                'role_name' => 'signer',
                'recipient_id' => '1',
                'tabs' => $tabs,
                'client_user_id' => 1000,
            ]);

            $recipients = new Recipients([
                'signers' => [$signer],
            ]);
        }

        $inlineTemplate = new InlineTemplate([
            'recipients' => $recipients,
            'sequence' => '1',
        ]);

        $compositeTemplate = new CompositeTemplate([
            'server_templates' => [$serverTemplate],
            'inline_templates' => [$inlineTemplate],
            'composite_template_id' => '1',
        ]);

        $envelope_definition->setCompositeTemplates([$compositeTemplate]);

        // print_r($envelope_definition);
        // die;

        return $envelope_definition;
    }

    private function getFirstValidEmail(?string $input = null): ?string
    {
        if (! $input) {
            return null;
        }

        foreach (preg_split('/[,\s;]+/', $input) as $email) {
            $email = trim($email);
            if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
            }
        }

        return null;
    }
}
