<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Docusigndocument;
use App\Models\Statustrigger;
use App\Models\Workorder;
use App\Services\DocusignService;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Model\Envelope;
use Illuminate\Console\Command;

class Docusignvoidcompleted extends Command
{
    protected $signature = 'app:docusignvoidcompleted';

    protected $description = 'Resend Docusign envelopes with authentication failed status';

    public function handle(DocusignService $docusignService)
    {
        $docusigndocuments = Docusigndocument::query()
            ->where('signingtype', 'email')
            ->where('environment', 'production')
            ->whereIn('status', ['envelope-sent', 'envelope-delivered'])
            ->where('created_at', '>=', now()->subDays(45))
            ->whereNotNull('envelopeid')
            ->where('envelopeid', '!=', '')
            ->orderBy('created_at', 'asc')
            ->whereHas(
                'workorder',
                fn ($q2) => $q2->whereIn('W_Status', ['Complete', 'Cancel'])
            )
            ->limit(50)
            ->get();

        foreach ($docusigndocuments as $docusigndocument) {
            $this->voidenvelope($docusigndocument, $docusignService);
            sleep(5);
        }
    }

    public function voidenvelope(Docusigndocument $docusigndocument, DocusignService $docusignService)
    {
        try {
            $reason = 'Form no longer required';

            $basepath = 'account-d.docusign.com';

            if ($docusigndocument->environment == 'production') {
                $basepath = 'account.docusign.com';
            }

            $apiClient = new ApiClient();
            $apiClient->getOAuth()->setOAuthBasePath($basepath);

            $accessToken = $docusignService->getToken($docusigndocument->environment);

            $userInfo = $apiClient->getUserInfo($accessToken);
            $account_id = $userInfo[0]['accounts'][0]['account_id'];
            $accountInfo = $userInfo[0]->getAccounts();

            $apiClient->getConfig()->setHost($accountInfo[0]->getBaseUri() . '/restapi');

            $envelopes_api = new EnvelopesApi($apiClient);
            $env = new Envelope();
            $env->setStatus('voided');
            $env->setVoidedReason($reason);
            $results = $envelopes_api->update($account_id, $docusigndocument->envelopeid, $env);

            $docusigndocument->statuses = $docusigndocument->statuses . date('Y-m-d H:i:s') . ' - envelope-voided, reason: ' . $reason . ' - user: EIS PROCESS' . "\r\n";
            $docusigndocument->save();

            $workorder = Workorder::on($docusigndocument->db)
                ->where('W_WorkOrder', $docusigndocument->workorder_id)
                ->first();

            $workorder->W_FollowUpStatus = 'Docusign Envelope Voided: ' . $docusigndocument->id . ' (' . date('m-d-Y g:i:s A') . ' EIS PROCESS' . ")\r\n\r\n" . $workorder->W_FollowUpStatus;
            $workorder->save();

            $statustrigger = new Statustrigger();
            $statustrigger->setConnection($docusigndocument->db);
            $statustrigger->WorkOrderNo = $docusigndocument->workorder_id;
            $statustrigger->statuscode = 808;
            $statustrigger->laststatus = 808 . ': Docusign Event: envelope-voided (' . date('g:i:s A') . ')';
            $statustrigger->Created = now();
            $statustrigger->CreatedBy = 'EIS PROCESS';
            $statustrigger->ChangeType = 'S';
            $statustrigger->save();

            $this->info(now()->format('Y-m-d H:i:s') . ' - Docusign Envelope Voided: ' . $docusigndocument->envelopeid . ' for Workorder: ' . $docusigndocument->workorder_id);
        } catch (\Throwable $e) {
            $this->info(now()->format('Y-m-d H:i:s') . ' - Docusign Error: ' . $e->getMessage());

            return;
        }
    }
}
