<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\SmartaccessEmail;
use App\Models\Ehrorder;
use App\Models\Smartaccesstheme;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Smartaccesscreate extends Command
{
    protected $signature = 'app:smartaccesscreate {database?}';

    protected $description = 'Smartaccess Order - Create';

    public function handle()
    {
        $database = $this->argument('database') ?? 'eisuat';
        config()->set('database.default', $database);

        $this->email();
    }

    private function theme(Ehrorder $ehrorder): array
    {
        return Smartaccesstheme::query()
            ->where('company_name', $ehrorder->company_name)
            ->first()?->toArray()

            ?? Smartaccesstheme::query()
                ->where('company_name', 'EIS')
                ->firstOrFail()
                ->toArray();
    }

    public function email()
    {
        $ehrorder = Ehrorder::query()
            ->where('service_provider', 'fasten_health')
            ->where('submission_type', 'auto')
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', '');
            })
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $ehrorder) {
            $this->warn('No EHR order found.');

            return;
        }

        // dd($ehrorder);

        $data['ehrorder'] = $ehrorder;

        $data['from'] = 'info@expressimagingservices.com';
        $data['subject'] = 'Connect to Your Health Records';

        $data['view'] = 'emails.smartaccess.smartaccess';

        if ($ehrorder->company_name == 'ABACUS' || $ehrorder->company_name == 'ABACUS CLIENT DIRECT' || $ehrorder->company_name == 'ABACUS AGENT') {
            $data['view'] = 'emails.smartaccess.smartaccess-abacus';
        }

        $data['theme'] = $this->theme($ehrorder);

        try {
            Mail::mailer('smtprelaygmail')
                ->to($ehrorder->email_address)
                // ->cc([
                //     'anhle@expressimagingservices.com',
                //     'andras@expressimagingservices.com'
                // ])
                ->send(new SmartaccessEmail($data));

            Mail::mailer('smtprelaygmail')
                ->to('anhle@expressimagingservices.com')
                ->send(new SmartaccessEmail($data));

            Mail::mailer('smtprelaygmail')
                ->to('andras@expressimagingservices.com')
                ->send(new SmartaccessEmail($data));

            $ehrorder->status = 'submitted';
            $ehrorder->submitted_at = now();
            $ehrorder->save();

            $this->info('Email sent to: ' . $ehrorder->email_address);
        } catch (\Throwable $e) {
            $this->warn('Error sending email: ' . $e->getMessage());
        }
    }
}
