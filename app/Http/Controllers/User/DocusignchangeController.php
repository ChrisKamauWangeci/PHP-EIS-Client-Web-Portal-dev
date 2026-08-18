<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\DocusignaccesscodeEmail;
use App\Models\Docusigndocument;
use App\Models\Statustrigger;
use App\Models\Workorder;
use App\Services\DocusignService;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Api\EnvelopesApi\UpdateOptions;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Model\Envelope;
use DocuSign\eSign\Model\Recipients;
use DocuSign\eSign\Model\Signer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DocusignchangeController extends Controller
{
    public function resend(Request $request, DocusignService $docusignService)
    {
        $id = $request->input('id');
        $envelope_id = $request->input('envelopeid');

        $docusigndocument = Docusigndocument::query()
            ->where('id', $id)
            ->where('envelopeid', $envelope_id)
            ->firstOrFail();

        if ($docusigndocument->environment == 'production') {
            $basepath = 'account.docusign.com';
        } else {
            $basepath = 'account-d.docusign.com';
        }

        $apiClient = new ApiClient();
        $apiClient->getOAuth()->setOAuthBasePath($basepath);

        $accessToken = $docusignService->getToken($docusigndocument->environment);
        // dd($accessToken);

        $userInfo = $apiClient->getUserInfo($accessToken);
        // dd($userInfo);

        $account_id = $userInfo[0]['accounts'][0]['account_id'];
        $accountInfo = $userInfo[0]->getAccounts();

        $apiClient->getConfig()->setHost($accountInfo[0]->getBaseUri() . '/restapi');

        if ($request->input('email') == $request->input('email_before')) {
            // resend envelope
            $envelopes_api = new EnvelopesApi($apiClient);
            $options = new UpdateOptions();
            $options->setResendEnvelope('true');
            $envelope = new Envelope();
            $envelope->setEnvelopeId($envelope_id);
            $results = $envelopes_api->update($account_id, $envelope_id, $envelope, $options);
            $resendaction = 'resent email to: ' . $request->input('email');
        } else {
            // change signer email
            $envelopes_api = new EnvelopesApi($apiClient);
            // $listRecipients = $envelopes_api->listRecipients($account_id, $envelope_id);
            // dump($listRecipients['signers'][0]['recipient_id']);
            // dd($listRecipients);
            $recipients = new Recipients();
            $signer = new Signer();
            $signer->setEmail($request->input('email'));
            $signer->setName($docusigndocument->first_name . ' ' . $docusigndocument->last_name);
            $signer->setRecipientId(1);
            $recipients->setSigners([$signer]);
            $results = $envelopes_api->updateRecipients($account_id, $envelope_id, $recipients);
            $resendaction = 'changed email from: ' . $request->input('email_before') . ' to: ' . $request->input('email');
        }

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
            ->to($request->input('email'))
            ->send(new DocusignaccesscodeEmail($data));

        $docusigndocument->email = $request->input('email');
        $docusigndocument->statuses = $docusigndocument->statuses . date('Y-m-d H:i:s') . ' - ' . $resendaction . ', reason: ' . $request->input('reason') . ' - user: ' . session('user.contractor.C_Name') . "\r\n";
        $docusigndocument->save();

        $statustrigger = new Statustrigger();
        $statustrigger->setConnection($docusigndocument->db);
        $statustrigger->WorkOrderNo = $docusigndocument->workorder_id;
        $statustrigger->statuscode = 807;
        $statustrigger->laststatus = 807 . ': Docusign Event: ' . $resendaction . ' (' . date('g:i:s A') . ')';
        $statustrigger->Created = now();
        $statustrigger->CreatedBy = session('user.contractor.C_Name');
        $statustrigger->ChangeType = 'S';
        $statustrigger->save();

        $request->session()->flash('success', 'Resend Completed');

        return back();
    }

    public function voidenvelope(Request $request, DocusignService $docusignService)
    {
        $id = $request->input('id');
        $reason = $request->input('reason');
        $envelope_id = $request->input('envelopeid');

        $docusigndocument = Docusigndocument::query()
            ->where('id', $id)
            ->where('envelopeid', $envelope_id)
            ->firstOrFail();

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
        $results = $envelopes_api->update($account_id, $envelope_id, $env);

        $docusigndocument->statuses = $docusigndocument->statuses . date('Y-m-d H:i:s') . ' - envelope-voided, reason: ' . $request->input('reason') . ' - user: ' . session('user.contractor.C_Name') . "\r\n";
        $docusigndocument->save();

        $workorder = Workorder::query()
            ->where('W_WorkOrder', $docusigndocument->workorder_id)
            ->first();

        $workorder->W_FollowUpStatus = 'Docusign Envelope Voided: ' . $docusigndocument->id . ' (' . date('m-d-Y g:i:s A') . ' ' . session('user.contractor.C_Name') . ")\r\n\r\n" . $workorder->W_FollowUpStatus;
        $workorder->save();

        $statustrigger = new Statustrigger();
        $statustrigger->setConnection($docusigndocument->db);
        $statustrigger->WorkOrderNo = $docusigndocument->workorder_id;
        $statustrigger->statuscode = 808;
        $statustrigger->laststatus = 808 . ': Docusign Event: envelope-voided (' . date('g:i:s A') . ')';
        $statustrigger->Created = now();
        $statustrigger->CreatedBy = session('user.contractor.C_Name');
        $statustrigger->ChangeType = 'S';
        $statustrigger->save();

        $request->session()->flash('success', 'Request Completed');

        return back();
    }
}
