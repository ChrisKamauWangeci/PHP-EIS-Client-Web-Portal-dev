<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\SeqsterorderEmail;
use App\Models\Ehrstatustrigger;
use App\Models\Ehrworkorder;
use App\Models\Hospitalraw;
use App\Models\Seqsterorder;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class Seqsterorderreminderprudential extends Command
{
    protected $signature = 'app:seqsterorderreminderprudential';

    protected $description = 'Seqster Order - Reminder for Prudential';

    public function handle()
    {
        echo 'start';
        $this->getusers();
        echo 'end';
    }

    public function getusers()
    {
        $seqsterorders = Seqsterorder::query()
            ->where('company', 'PRUDENTIAL INSURANCE COMPANY OF AMERICA')
            ->where('created', '>', now()->subHours(48))
            ->where('created', '<', now()->subHours(24))
            ->whereNull('visited_at')
            ->orderBy('created', 'asc')
            ->get();

        foreach ($seqsterorders as $seqsterorder) {
            $this->email($seqsterorder);
        }

        $seqsterorders = Seqsterorder::query()
            ->where('company', 'PRUDENTIAL INSURANCE COMPANY OF AMERICA')
            ->where('created', '>', now()->subHours(72))
            ->where('created', '<', now()->subHours(48))
            ->whereNull('visited_at')
            ->orderBy('created', 'asc')
            ->get();

        foreach ($seqsterorders as $seqsterorder) {
            $this->email($seqsterorder);
        }
    }

    public function email($seqsterorder)
    {
        dump($seqsterorder);

        $ehrworkorder = Ehrworkorder::query()
            ->select([
                'Workorder.W_WorkOrder',
                'Workorder.W_InsCompany',
                'Requestor.R_Company',
                'Requestor.R_Email',
            ])
            ->leftJoin('Requestor', 'Workorder.W_Requestor', '=', 'Requestor.R_Name')
            ->where('W_WorkOrder', $seqsterorder->workorder_id)
            ->first();

        if ($ehrworkorder) {
            $hospitalraw = Hospitalraw::on('ehr')
                ->where('R_WorkOrder', $ehrworkorder->W_WorkOrder)
                ->first();
        } else {
            $hospitalraw = null;
        }

        if (filter_var($seqsterorder->email, FILTER_VALIDATE_EMAIL)) {

            $data['from'] = 'prudentialsupport@expressimagingservices.com';
            $data['subject'] = 'Action Required - Next Steps for Your Life Insurance Application';
            $data['seqsterorder'] = $seqsterorder;
            $data['ehrworkorder'] = $ehrworkorder;
            $data['hospitalraw'] = $hospitalraw;
            $data['view'] = 'emails.seqsterorderreminder_prudential';

            try {
                Mail::mailer('smtprelaygmail')
                    ->to($seqsterorder->email)
                    ->send(new SeqsterorderEmail($data));
                Mail::mailer('smtprelaygmail')
                    ->to('andras@expressimagingservices.com')
                    ->send(new SeqsterorderEmail($data));

                Mail::to('andras@expressimagingservices.com')
                    ->send(new SeqsterorderEmail($data));

                // $seqsterorder->status = 'emailed';
                $seqsterorder->reminded_at = now();
            } catch (\Exception $e) {
                $seqsterorder->api_error = $seqsterorder->api_error . "\r\n\r\n" . $e->getMessage();

                Mail::raw($seqsterorder->api_error, function (Message $message) {
                    $message
                        ->from('info@expressimagingservices.com')
                        ->to('andras@expressimagingservices.com')
                        ->subject('seqster error');
                });
            }

            $seqsterorder->timestamps = false;
            $seqsterorder->save();

            // $ehrworkorder = Ehrworkorder::query()
            //     ->where('W_WorkOrder', $seqsterorder->workorder_id)
            //     ->first();

            // if ($ehrworkorder) {
            //     $ehrworkorder->W_Note = $ehrworkorder->W_Note . "\r\n" . now()->format('m-d-Y') . ': 1003800773: Sent email invitation reminder to member. ' . $url . ' (' . now()->format('h:i:s A') . ')';
            //     $ehrworkorder->save();
            // }

            // $statustrigger = new Ehrstatustrigger();
            // $statustrigger->WorkOrderNo = $seqsterorder->workorder_id;
            // $statustrigger->laststatus = $url;
            // // $statustrigger->laststatus = now()->format('m-d-Y') . ': 1003800773: Sent email invitation to member. ' . $url . ' (' . now()->format('h:i:s A') . ')';
            // $statustrigger->Created = now();
            // $statustrigger->statuscode = '1003800773';
            // $statustrigger->CreatedBy = 'EHL Processing';
            // $statustrigger->ChangeType = 'S';
            // $statustrigger->save();
        }

        sleep(1);
    }
}
