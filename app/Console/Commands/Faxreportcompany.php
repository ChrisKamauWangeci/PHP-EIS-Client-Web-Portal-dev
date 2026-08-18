<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\FaxEmail;
use App\Models\Fax;
use App\Models\Workorder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Faxreportcompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:faxreportcompany';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a report of faxes to a company created in the last 24 hours';

    /**
     * Execute the console command.
     */
    protected array $range;

    public function handle()
    {
        $this->range = [
            now()->subDays(1)->startOfDay(),
            now()->subDays(1)->endOfDay(),
        ];

        $recipients = [
            [
                'field' => 'company',
                'name' => 'PINNEY INSURANCE CENTER, INC',
                'subject' => 'Corebridge',
                'email' => 'apsteam@Corebridgefinancial.com',
            ],
            [
                'field' => 'client',
                'name' => '18009159934-americangeneralcorebridge',
                'subject' => 'Corebridge',
                'email' => 'apsteam@Corebridgefinancial.com',
            ],
            [
                'field' => 'client',
                'name' => '18338960409-americangeneralcorebridge',
                'subject' => 'Corebridge',
                'email' => 'apsteam@Corebridgefinancial.com',
            ],
            [
                'field' => 'company',
                'name' => 'PINNEY INSURANCE CENTER, INC',
                'subject' => 'Corebridge',
                'email' => 'beth.prevost@corebridgefinancial.com',
            ],
            [
                'field' => 'client',
                'name' => '18009159934-americangeneralcorebridge',
                'subject' => 'Corebridge',
                'email' => 'beth.prevost@corebridgefinancial.com',
            ],
            [
                'field' => 'client',
                'name' => '18338960409-americangeneralcorebridge',
                'subject' => 'Corebridge',
                'email' => 'beth.prevost@corebridgefinancial.com',
            ],
        ];

        // $this->sendFaxReport($recipients);
        $this->sendFaxReportGroupedByEmail($recipients);
    }

    private function sendFaxReport(array $recipients): void
    {
        foreach ($recipients as $recipient) {

            $field = $recipient['field'];
            $name = $recipient['name'];
            $subject = $recipient['subject'];
            $email = $recipient['email'];

            $faxes = Fax::query()
                ->where($field, $name)
                ->whereBetween('created_at', $this->range)
                ->orderBy('created_at', 'ASC')
                ->limit(5000)
                ->get();

            if ($faxes->isEmpty()) {
                $this->info("No faxes found for {$name} - {$field}");

                continue;
            }

            $workorders = Workorder::on('eis')
                ->select(
                    'W_WorkOrder',
                    'W_FirstName',
                    'W_MiddleInit',
                    'W_LastName',
                )
                ->whereIn('W_WorkOrder', $faxes->pluck('workorder'))
                ->get()
                ->keyBy('W_WorkOrder');

            foreach ($faxes as $fax) {
                $wo = $workorders->get($fax->workorder);
                $fax->applicant_name = $wo ? $wo->W_FirstName . ' ' . $wo->W_MiddleInit . ' ' . $wo->W_LastName : '';
            }

            $data = [
                'view' => 'emails.faxreportcompany',
                'subject' => $subject,
                'faxes' => $faxes,
            ];

            try {
                sleep(2);
                // Mail::mailer('smtprelaygmail')->to($email)->send(new FaxEmail($data));
                sleep(2);
                Mail::to('andras@expressimagingservices.com')->send(new FaxEmail($data));
                $this->info("Fax report sent to: {$name} - {$field} - {$email}");
            } catch (\Throwable $e) {
                Log::error("Error sending fax report to: {$name} - {$field} - {$email}", [
                    'error' => $e->getMessage(),
                ]);
                $this->error("Error sending fax report to: {$name} - {$field} - {$email} - {$e->getMessage()}");
            }
        }
    }

    private function sendFaxReportGroupedByEmail(array $recipients): void
    {
        $grouped = collect($recipients)->groupBy('email');

        foreach ($grouped as $email => $emailRecipients) {

            $allFaxes = collect();
            $subjects = collect();

            foreach ($emailRecipients as $recipient) {
                $field = $recipient['field'];
                $name = $recipient['name'];
                $subject = $recipient['subject'];

                $faxes = Fax::query()
                    ->where($field, $name)
                    ->whereBetween('created_at', $this->range)
                    ->orderBy('created_at', 'ASC')
                    ->limit(1000)
                    ->get();

                if ($faxes->isEmpty()) {
                    $this->info("No faxes found for {$name} - {$field}");

                    continue;
                }

                $allFaxes = $allFaxes->merge($faxes);
                $subjects->push($subject);
            }

            if ($allFaxes->isEmpty()) {
                $this->info("No faxes found for {$email}");

                continue;
            }

            $workorderIds = $allFaxes->pluck('workorder')->filter(fn ($value) => is_numeric($value));

            $workorders = Workorder::on('eis')
                ->select(
                    'W_WorkOrder',
                    'W_FirstName',
                    'W_MiddleInit',
                    'W_LastName',
                )
                ->whereIn('W_WorkOrder', $workorderIds)
                ->get()
                ->keyBy('W_WorkOrder');

            foreach ($allFaxes as $fax) {
                $wo = $workorders->get($fax->workorder);
                $fax->applicant_name = $wo ? $wo->W_FirstName . ' ' . $wo->W_MiddleInit . ' ' . $wo->W_LastName : '';
            }

            $subjectLine = $subjects->unique()->implode(', ');

            $data = [
                'view' => 'emails.faxreportcompany',
                'subject' => 'FAX Grouped ' . $subjectLine,
                'faxes' => $allFaxes,
            ];

            try {
                Mail::mailer('smtprelaygmail')->to($email)->send(new FaxEmail($data));
                sleep(2);
                Mail::mailer('smtprelaygmail')->to('andras@expressimagingservices.com')->send(new FaxEmail($data));
                sleep(2);
                Mail::mailer('smtprelaygmail')->to('rpimentel@expressimagingservices.com')->send(new FaxEmail($data));
                sleep(2);
                $this->info("Fax report sent to: {$email} ({$emailRecipients->count()} recipient entries combined)");
            } catch (\Throwable $e) {
                Log::error("Error sending fax report to: {$email}", [
                    'error' => $e->getMessage(),
                ]);
                $this->error("Error sending fax report to: {$email} - {$e->getMessage()}");
            }
        }
    }
}
