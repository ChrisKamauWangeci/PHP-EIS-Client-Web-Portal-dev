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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Seqsterordercreate extends Command
{
    protected $signature = 'app:seqsterordercreate';

    protected $description = 'Seqster Order - Create';

    public function handle()
    {
        $this->info('start');
        $this->uuid();
        $this->create();
        $this->email();
        $this->info('end');
    }

    public function uuid()
    {
        $seqsterorders = Seqsterorder::query()
            ->whereNull('uuid')
            ->orderBy('created', 'desc')
            ->limit(100)
            ->get();

        foreach ($seqsterorders as $seqsterorder) {
            print_r($seqsterorder);
            $seqsterorder->uuid = Str::uuid();
            $seqsterorder->timestamps = false;
            $seqsterorder->save();
        }
    }

    public function create()
    {
        $seqsterorders = Seqsterorder::query()
            ->where('uuid', '>', '')
            ->whereNull('status')
            ->where('created', '>=', now()->subHours(24))
            ->orderBy('created', 'asc')
            ->limit(100)
            ->get();

        foreach ($seqsterorders as $seqsterorder) {

            $url = null;
            $client_id = null;
            $client_secret = null;
            $fields = [];

            // dd($seqsterorder);

            // UAT
            // $url = 'https://eis-usaa.uat.seqster.com/api/partner/register/basic';
            // 'client_id' => '991268eb-d7cc-4c85-b398-064131cd82fe',
            // 'client_secret' => 'YGnWzPEU5WmFCIZ45GQyfykH3P12lr5mhZ2SroFG',

            // PRODUCTION USAA
            // $url = 'https://eis-usaa.seqster.com/api/partner/register/basic';
            // 'client_id' => '994e7b71-1113-4e63-b665-ae584aa455b5',
            // 'client_secret' => 'iHjEc1HJU0HMjuS2q7MfWcAKLKBtOLYhlT3isuWz',

            // PRODUCTION NEW EIS
            // $url = 'https://eis.seqster.com/api/partner/register/basic';
            // 'client_id' => '9c2ac9be-c37b-423f-96ee-fc7d447be0d0',
            // 'client_secret' => '4LxWdPWPibNIZuaJU1p00WRzhsg457nFT2HPUFn0',
            // 'participant_identifier' => $seqsterorder->workorder_id,
            // 'project_title' => 'EIS',
            // 'site_name' => 'EIS',

            if ($seqsterorder->project_title == 'EIS') {
                $url = config('site_config.seqster_url_eis');
                $client_id = config('site_config.seqster_client_id_eis');
                $client_secret = config('site_config.seqster_client_secret_eis');

                $fields = [
                    'project_title' => 'EIS',
                    'site_name' => 'EIS',
                    // 'participant_identifier' => $seqsterorder->workorder_id,
                ];
            }

            if ($seqsterorder->company == 'USAA') {
                $url = config('site_config.seqster_url_usaa');
                $client_id = config('site_config.seqster_client_id_usaa');
                $client_secret = config('site_config.seqster_client_secret_usaa');
                $fields = [];
            }

            if ($seqsterorder->company == 'NORTHWESTERN MUTUAL' || $seqsterorder->company == 'NORTHWESTERN MUTUAL LTC') {
                $url = config('site_config.seqster_url_nwm');
                $client_id = config('site_config.seqster_client_id_nwm');
                $client_secret = config('site_config.seqster_client_secret_nwm');

                $fields = [
                    'project_title' => 'Northwestern Mutual VA Record Retrieval',
                    'site_name' => 'Default',
                    // 'participant_identifier' => $seqsterorder->workorder_id,
                ];
            }

            if ($seqsterorder->project_title == 'Prudential Insurance Company of America') {
                $url = config('site_config.seqster_url_prudential');
                $client_id = config('site_config.seqster_client_id_prudential');
                $client_secret = config('site_config.seqster_client_secret_prudential');

                $fields = [
                    'project_title' => 'Prudential Insurance Company of America',
                    'site_name' => 'Default',
                    // 'participant_identifier' => $seqsterorder->workorder_id,
                ];
            }

            if (empty($url)) {
                continue;
            }

            $gender = strtoupper($seqsterorder->gender ?? '');

            $normalizedGender = match ($gender) {
                'M', 'MALE' => 'male',
                'F', 'FEMALE' => 'female',
                default => '',
            };

            $postfields = [
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'site_id' => '',
                'patient_id' => $seqsterorder->workorder_id,
                'first_name' => $seqsterorder->first_name,
                'last_name' => $seqsterorder->last_name,
                'gender' => $normalizedGender,
                'birthday' => $seqsterorder->birthday->format('Y-m-d'),
                'address_1' => $seqsterorder->address_1,
                'address_2' => $seqsterorder->address_2,
                'city' => $seqsterorder->city,
                'state' => $seqsterorder->state,
                'postal_code' => $seqsterorder->postal_code,
            ] + $fields;

            $response = Http::withoutVerifying()
                ->asForm()
                ->post($url, $postfields);

            $apiResponse = $response->json();

            $directory = storage_path('persistent_logs/seqsterorders/' . now()->format('Y-m-d'));
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            $file = $directory . '/seqsterorder-' . now()->format('Ymd-His') . '-' . $seqsterorder->id . '-' . $seqsterorder->workorder_id . '.txt';
            $filedata = now()->format('Y-m-d H:i:s') . "\r\n\r\n"
                . $url . "\r\n\r\n"
                . print_r($postfields, true) . "\r\n\r\n"
                . print_r($apiResponse, true) . "\r\n\r\n"
                . print_r($seqsterorder->toArray(), true);

            @file_put_contents($file, $filedata);

            if (isset($apiResponse['data']['access_token'])) {
                $seqsterorder->status = 'seqstercreated';
                $seqsterorder->seqster_at = now();
                $seqsterorder->access_token = $apiResponse['data']['access_token'];
                $seqsterorder->refresh_token = $apiResponse['data']['refresh_token'];
            } else {
                $seqsterorder->api_error = print_r($apiResponse, true);
                $body = print_r($seqsterorder->toArray(), true) . "\r\n\r\n" . print_r($apiResponse, true);

                Mail::raw($body, function (Message $message) {
                    $message
                        ->from('info@expressimagingservices.com')
                        ->to('andras@expressimagingservices.com')
                        ->subject('seqster error');
                });
            }

            $seqsterorder->timestamps = false;
            $seqsterorder->save();

            sleep(5);
        }
    }

    public function email()
    {
        $seqsterorders = Seqsterorder::query()
            ->where('status', 'seqstercreated')
            ->where('uuid', '>', '')
            ->where('created', '>=', now()->subHours(24))
            ->orderBy('created', 'asc')
            ->limit(100)
            ->get();

        foreach ($seqsterorders as $seqsterorder) {

            print_r($seqsterorder->toArray());

            $ehrworkorder = Ehrworkorder::query()
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

            // dump($ehrworkorder);

            if ($ehrworkorder) {
                $hospitalraw = Hospitalraw::on('ehr')
                    ->where('R_WorkOrder', $ehrworkorder->W_WorkOrder)
                    ->first();
            } else {
                $hospitalraw = null;
            }
            // dump($hospitalraw);

            if (filter_var($seqsterorder->email, FILTER_VALIDATE_EMAIL)) {

                $data['seqsterorder'] = $seqsterorder;
                $data['ehrworkorder'] = $ehrworkorder;
                $data['hospitalraw'] = $hospitalraw;

                if ($seqsterorder->project_title == 'EIS') {
                    $data['from'] = 'ehealth@expressimagingservices.com';
                    $data['subject'] = 'Next Steps for Your Life Insurance Application';
                    $data['view'] = 'emails.seqsterorder.eis';
                    $url = 'https://www.expressimagingservices.com/seqsterorders/step1/' . $seqsterorder->uuid;
                }

                if ($seqsterorder->company == 'USAA') {
                    $data['from'] = 'usaasupport@expressimagingservices.com';
                    $data['subject'] = 'USAA Life Application: Connect your medical records';
                    $data['view'] = 'emails.seqsterorder.usaa';
                    $url = 'https://usaa.expressimagingservices.com/seqsterorders/step1/' . $seqsterorder->uuid;
                }

                if ($seqsterorder->company == 'NORTHWESTERN MUTUAL' || $seqsterorder->company == 'NORTHWESTERN MUTUAL LTC') {
                    $data['from'] = 'ehealth@expressimagingservices.com';
                    $data['subject'] = 'Next Steps for Your Life Insurance Application';
                    $data['view'] = 'emails.seqsterorder.northwestern';
                    $url = 'https://www.expressimagingservices.com/seqsterorders/step1/' . $seqsterorder->uuid;
                }

                if ($seqsterorder->project_title == 'Prudential Insurance Company of America') {
                    $data['from'] = 'ehealth@expressimagingservices.com';
                    $data['subject'] = 'Next Steps for Your Life Insurance Application';
                    $data['view'] = 'emails.seqsterorder.prudential';
                    $url = 'https://www.expressimagingservices.com/seqsterorders/step1/' . $seqsterorder->uuid;
                }

                if (empty($url)) {
                    continue;
                }

                try {
                    Mail::mailer('smtprelaygmail')
                        ->to($seqsterorder->email)
                        ->send(new SeqsterorderEmail($data));

                    // Mail::mailer('smtprelaygmail')
                    //     ->to('andras@expressimagingservices.com')
                    //     ->send(new SeqsterorderEmail($data));

                    $seqsterorder->status = 'emailed';
                    $seqsterorder->emailed_at = now();
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

                $ehrworkorder = Ehrworkorder::query()
                    ->where('W_WorkOrder', $seqsterorder->workorder_id)
                    ->first();

                if ($ehrworkorder) {
                    $ehrworkorder->W_Note = $ehrworkorder->W_Note . "\r\n" . now()->format('m-d-Y') . ': 1003800773: Sent email invitation to member. ' . $url . ' (' . now()->format('h:i:s A') . ')';
                    $ehrworkorder->save();
                }

                $statustrigger = new Ehrstatustrigger();
                $statustrigger->WorkOrderNo = $seqsterorder->workorder_id;
                $statustrigger->laststatus = $url;
                // $statustrigger->laststatus = now()->format('m-d-Y') . ': 1003800773: Sent email invitation to member. ' . $url . ' (' . now()->format('h:i:s A') . ')';
                $statustrigger->Created = now();
                $statustrigger->statuscode = '1003800773';
                $statustrigger->CreatedBy = 'EHL Processing';
                $statustrigger->ChangeType = 'S';
                $statustrigger->save();
            }

            sleep(5);
        }
    }
}
