<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\DocusignaccesscodeEmail;
use App\Models\Docusigndocument;
use App\Models\Statustrigger;
use App\Services\DocusignService;
use DocuSign\eSign\Api\EnvelopesApi;
use Docusign\eSign\Api\EnvelopesApi\UpdateOptions;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Model\Envelope;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Docusignresend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:docusignresend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resend Docusign envelopes with authentication failed status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $status = 'recipient-authenticationfailed';
        $updated_at = now()->subDays(7)->format('Y-m-d H:i:s');

        $docusigndocuments = Docusigndocument::query()
            ->where('signingtype', 'email')
            ->where('status', $status)
            ->where('updated_at', '>', $updated_at)
            ->whereNotNull('envelopeid')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($docusigndocuments as $docusigndocument) {
            dump($docusigndocument->workorder_id);
            $this->resend($docusigndocument);
            sleep(2);
        }
    }

    protected function resend($docusigndocument)
    {

        // return true;

        if ($docusigndocument['environment'] == 'production') {
            $basepath = 'account.docusign.com';
        } else {
            $basepath = 'account-d.docusign.com';
        }

        $apiClient = new ApiClient();
        $apiClient->getOAuth()->setOAuthBasePath($basepath);
        // dd($apiClient->getOAuth()->getOAuthBasePath());

        $docusignService = new DocusignService();
        $accessToken = $docusignService->getToken($docusigndocument['environment']);
        // dd($accessToken);

        $userInfo = $apiClient->getUserInfo($accessToken);
        // dd($userInfo);

        $account_id = $userInfo[0]['accounts'][0]['account_id'];
        $accountInfo = $userInfo[0]->getAccounts();

        $apiClient->getConfig()->setHost($accountInfo[0]->getBaseUri() . '/restapi');

        // resend envelope
        $envelopes_api = new EnvelopesApi($apiClient);
        $options = new UpdateOptions();
        $options->setResendEnvelope('true');
        $envelope = new Envelope();
        $envelope->setEnvelopeId($docusigndocument['envelopeid']);
        $results = $envelopes_api->update($account_id, $docusigndocument['envelopeid'], $envelope, $options);
        $resendaction = 'resent email to: ' . $docusigndocument->email;

        $sara['data'] = [
            'patient_first_name' => $docusigndocument->first_name,
            'patient_last_name' => $docusigndocument->last_name,
            'access_code' => $docusigndocument->access_code,
            'id' => $docusigndocument->id,
        ];

        $data['from'] = 'sign@expressimagingservices.com';
        $data['subject'] = 'Secure Access Code for Your Authorization Request';
        $data['data'] = $sara;
        $data['view'] = 'emails.docusignaccesscode';

        Mail::mailer('smtprelaygmail')
            ->to($docusigndocument->email)
            ->send(new DocusignaccesscodeEmail($data));

        sleep(2);

        Mail::mailer('smtprelaygmail')
            ->to('andras@expressimagingservices.com')
            ->send(new DocusignaccesscodeEmail($data));

        $docusigndocument->statuses = $docusigndocument->statuses . now()->format('Y-m-d H:i:s') . ' - ' . $resendaction . ', reason: authenticationfailed - user: AUTO TASKS' . "\r\n";
        $docusigndocument->save();

        $database = $docusigndocument->db ?? 'eisuat';
        config()->set('database.default', $database);

        $statustrigger = new Statustrigger();
        $statustrigger->WorkOrderNo = $docusigndocument->workorder_id;
        $statustrigger->statuscode = 807;
        $statustrigger->laststatus = 807 . ': Docusign Event: ' . $resendaction . ' (' . now()->format('g:i:s A') . ')';
        $statustrigger->Created = now();
        $statustrigger->CreatedBy = 'AUTO TASKS';
        $statustrigger->ChangeType = 'S';
        $statustrigger->save();

        return $docusigndocument;
    }
}
