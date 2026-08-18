<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\SeqsterorderEmail;
use App\Models\Ehrstatustrigger;
use App\Models\Ehrworkorder;
use App\Models\Hospitalraw;
use App\Models\Seqsterorder;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class SeqsterEmailService
{
    public function sendById(int $id): bool
    {
        $seqsterorder = Seqsterorder::query()
            ->where('id', $id)
            ->first();

        if (! $seqsterorder) {
            return false;
        }

        if (! filter_var($seqsterorder->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $ehrworkorder = Ehrworkorder::on('ehr')
            ->select([
                'Workorder.W_WorkOrder',
                'Workorder.W_InsCompany',
                'Workorder.W_Agent',
                'Requestor.R_Company',
                'Requestor.R_Email',
            ])
            ->leftJoin('Requestor', 'Workorder.W_Requestor', '=', 'Requestor.R_Name')
            ->where('W_WorkOrder', $seqsterorder->workorder_id)
            ->first();

        $hospitalraw = null;

        if ($ehrworkorder) {
            $hospitalraw = Hospitalraw::on('ehr')
                ->where('R_WorkOrder', $ehrworkorder->W_WorkOrder)
                ->first();
        }

        $data = [
            'seqsterorder' => $seqsterorder,
            'ehrworkorder' => $ehrworkorder,
            'hospitalraw' => $hospitalraw,
        ];

        $config = $this->resolveEmailConfig($seqsterorder);

        if (! $config) {
            return false;
        }

        $data = array_merge($data, $config);

        try {
            Mail::mailer('smtprelaygmail')
                ->to($seqsterorder->email)
                ->send(new SeqsterorderEmail($data));

            $seqsterorder->emailed_at = now();
            $seqsterorder->timestamps = false;
            $seqsterorder->save();

            // $this->logWorkorder($seqsterorder, $config['url'] ?? null);

            return true;
        } catch (\Exception $e) {

            Mail::raw($e->getMessage(), function (Message $message) {
                $message
                    ->from('info@expressimagingservices.com')
                    ->to('andras@expressimagingservices.com')
                    ->subject('seqster email error');
            });

            return false;
        }
    }

    private function resolveEmailConfig(Seqsterorder $seqsterorder): ?array
    {
        $url = null;
        $data = [];

        if ($seqsterorder->project_title === 'EIS') {
            $url = 'https://www.expressimagingservices.com/seqsterorders/step1/' . $seqsterorder->uuid;

            $data = [
                'from' => 'ehealth@expressimagingservices.com',
                'subject' => 'Next Steps for Your Life Insurance Application',
                'view' => 'emails.seqsterorder.eis',
                'url' => $url,
            ];
        }

        if ($seqsterorder->company === 'USAA') {
            $url = 'https://usaa.expressimagingservices.com/seqsterorders/step1/' . $seqsterorder->uuid;

            $data = [
                'from' => 'usaasupport@expressimagingservices.com',
                'subject' => 'USAA Life Application: Connect your medical records',
                'view' => 'emails.seqsterorder.usaa',
                'url' => $url,
            ];
        }

        if (
            $seqsterorder->company === 'NORTHWESTERN MUTUAL' ||
            $seqsterorder->company === 'NORTHWESTERN MUTUAL LTC'
        ) {
            $url = 'https://www.expressimagingservices.com/seqsterorders/step1/' . $seqsterorder->uuid;

            $data = [
                'from' => 'ehealth@expressimagingservices.com',
                'subject' => 'Next Steps for Your Life Insurance Application',
                'view' => 'emails.seqsterorder.northwestern',
                'url' => $url,
            ];
        }

        if ($seqsterorder->project_title === 'Prudential Insurance Company of America') {
            $url = 'https://www.expressimagingservices.com/seqsterorders/step1/' . $seqsterorder->uuid;

            $data = [
                'from' => 'ehealth@expressimagingservices.com',
                'subject' => 'Next Steps for Your Life Insurance Application',
                'view' => 'emails.seqsterorder.prudential',
                'url' => $url,
            ];
        }

        if (! $url) {
            return null;
        }

        return $data;
    }

    private function logWorkorder(Seqsterorder $seqsterorder, ?string $url): void
    {
        $ehrworkorder = Ehrworkorder::query()
            ->where('W_WorkOrder', $seqsterorder->workorder_id)
            ->first();

        if ($ehrworkorder) {
            $ehrworkorder->W_Note .= "\r\n" . now()->format('m-d-Y')
                . ': Sent email invitation. '
                . $url;

            $ehrworkorder->save();
        }

        $statustrigger = new Ehrstatustrigger();
        $statustrigger->WorkOrderNo = $seqsterorder->workorder_id;
        $statustrigger->laststatus = $url;
        $statustrigger->Created = now();
        $statustrigger->statuscode = '1003800773';
        $statustrigger->CreatedBy = 'EHL Processing';
        $statustrigger->ChangeType = 'S';
        $statustrigger->save();
    }
}
