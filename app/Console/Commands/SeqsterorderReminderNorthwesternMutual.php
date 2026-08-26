<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helper\Helper;
use App\Mail\SeqsterorderEmail;
use App\Models\Apsorder;
use App\Models\Ehrworkorder;
use App\Models\Northwesternmutual;
use App\Models\Seqsterorder;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class SeqsterorderReminderNorthwesternMutual extends Command
{
    protected $signature = 'app:seqsterorderremindernorthwesternmutual';

    protected $description = 'Seqster Order - Reminder for Northwestern Mutual';

    public function handle()
    {
        $seqsterorders = $this->seqsterOrders();

        foreach ($seqsterorders as $seqsterorder) {
            $this->info(now()->toDateTimeString() . ' Processing SEQSTERORDER: id: ' . $seqsterorder->id . ' - ehr workorder: ' . $seqsterorder->workorder_id . ' - created: ' . $seqsterorder->created . ' - seqster_at: ' . $seqsterorder->seqster_at . ' - company: ' . $seqsterorder->company . ' - ' . $seqsterorder->first_name . ' ' . $seqsterorder->last_name . ' - ' . $seqsterorder->email);
            $this->processReminder($seqsterorder);
        }
    }

    public function seqsterOrders()
    {
        $seqsterorders = Seqsterorder::query()
            ->whereIn('company', ['NORTHWESTERN MUTUAL', 'NORTHWESTERN MUTUAL LTC'])
            ->where('status', 'emailed')
            ->whereNull('visited_at')
            ->whereNull('reminded_at')
            ->whereNotNull('email')
            ->whereBetween('seqster_at', [
                now()->subDays(5)->startOfDay(),
                now()->subDays(5)->endOfDay(),
            ])
            ->orderBy('created', 'desc')
            ->limit(100)
            ->get();

        return $seqsterorders;
    }

    public function processReminder($seqsterorder)
    {
        if (! filter_var($seqsterorder->email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        try {
            $financialAdvisor = '';
            $agentsEmails = [];

            $ehrworkorder = Ehrworkorder::query()
                ->where('W_WorkOrder', $seqsterorder->workorder_id)
                ->firstOrFail();

            $this->line('SEQSTERORDER: id: ' . $seqsterorder->id . ' - ehr workorder: ' . $seqsterorder->workorder_id . ' - aps workorder: ' . $ehrworkorder->W_TransNo . ' - created: ' . $seqsterorder->created . ' - seqster_at: ' . $seqsterorder->seqster_at . ' - company: ' . $seqsterorder->company . ' - ' . $seqsterorder->first_name . ' ' . $seqsterorder->last_name . ' - ' . $seqsterorder->email);

            if ($seqsterorder->company == 'NORTHWESTERN MUTUAL') {

                $apsorder = Apsorder::query()
                    ->where('EISWorkOrderID', $ehrworkorder->W_TransNo)
                    ->first();

                if ($apsorder) {
                    // $this->info('vwAPSOrders: RequestID: ' . $apsorder->RequestID . ' - EISWorkOrderID: ' . $apsorder->EISWorkOrderID . ' - WritingAgentLastName: ' . $apsorder->WritingAgentLastName . ' - WritingAgentEmail: ' . $apsorder->WritingAgentEmail);
                    $financialAdvisor = $apsorder->WritingAgentFirstName . ' ' . $apsorder->WritingAgentLastName;
                    $agentsEmails = Helper::extractEmails($apsorder->WritingAgentEmail);
                    $this->info('Send to agent emails: ' . implode('; ', $agentsEmails));
                    $this->info('financialAdvisor: ' . $financialAdvisor);
                }
            }

            if ($seqsterorder->company == 'NORTHWESTERN MUTUAL LTC') {

                $northwesternmutual = Northwesternmutual::query()
                    ->where('EISWorkOrderID', $ehrworkorder->W_TransNo)
                    ->first();

                if ($northwesternmutual) {
                    // $this->info('vwNorthWesternMutual: RequestID: ' . $northwesternmutual->RequestID . ' - RequestorEmail1: ' . $northwesternmutual->RequestorEmail1 . ' - RequestorFirstName: ' . $northwesternmutual->RequestorFirstName . ' - RequestorLastName: ' . $northwesternmutual->RequestorLastName);
                    $financialAdvisor = $northwesternmutual->RequestorFirstName . ' ' . $northwesternmutual->RequestorLastName;
                    $agentsEmails = Helper::extractEmails($northwesternmutual->RequestorEmail1);
                    $this->info('Send to agent emails: ' . implode('; ', $agentsEmails));
                    $this->info('financialAdvisor: ' . $financialAdvisor);
                }
            }

            $data = [
                'from' => 'ehealth@expressimagingservices.com',
                'subject' => 'Action Required - Next Steps for Your Life Insurance Application',
                'seqsterorder' => $seqsterorder,
                'hospitalraw' => null,
                'ehrworkorder' => $ehrworkorder,
                'financialAdvisor' => $financialAdvisor,
                'view' => 'emails.seqsterorderreminder_northwesternmutual',
            ];

            $recipients = array_merge([$seqsterorder->email], $agentsEmails, ['andras@expressimagingservices.com']);
            $this->warn('Send to all emails: ' . implode('; ', $recipients));
            foreach ($recipients as $recipient) {
                Mail::mailer('smtprelaygmail')
                    ->to($recipient)
                    ->send(new SeqsterorderEmail($data));
                sleep(1);
            }
            $seqsterorder->reminded_at = now();
        } catch (\Exception $e) {
            $seqsterorder->api_error = 'Error sending email: seqsterorder: ' . $seqsterorder->id . ' - ' . $e->getMessage();
            $this->error($seqsterorder->api_error);
            Mail::raw($seqsterorder->api_error, function (Message $mail) {
                $mail->from('info@expressimagingservices.com')
                    ->to('andras@expressimagingservices.com')
                    ->subject('seqster error');
            });
        } finally {
            $seqsterorder->timestamps = false;
            $seqsterorder->save();
        }

        $this->newline(2);
    }
}
