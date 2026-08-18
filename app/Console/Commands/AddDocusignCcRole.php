<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\DocusignService;
use DocuSign\eSign\Api\TemplatesApi;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Model\CarbonCopy;
use DocuSign\eSign\Model\Recipients;
use Illuminate\Console\Command;

class AddDocusignCcRole extends Command
{
    protected $signature = 'app:adddocusignccrole {dry?}';

    protected $description = 'Add CC role to all DocuSign templates if missing';

    public function handle(DocusignService $docusignService)
    {
        $dryRun = $this->argument('dry');
        $this->info('Starting DocuSign CC role update...');

        $accessToken = $docusignService->getToken('test');
        // $accessToken = $docusignService->getToken('production');

        $basePath = 'https://demo.docusign.net/restapi'; // test environment
        // $basePath = 'https://na4.docusign.net/restapi'; // prod environment

        // Step 1: Configure API client properly
        $config = new Configuration();
        $config->setHost($basePath);
        $config->addDefaultHeader('Authorization', 'Bearer ' . $accessToken);

        $apiClient = new ApiClient($config);
        $templatesApi = new TemplatesApi($apiClient);

        $accountId = 'd93b7278-95b7-4de3-95cd-1488940615be'; // test account ID
        // $accountId = '3d4d0405-0136-43dd-baf7-3336476f2e93'; // prod account ID
        // dd($accountId);

        // Step 2: List all templates
        $templatesList = $templatesApi->listTemplates($accountId);

        if (empty($templatesList->getEnvelopeTemplates())) {
            $this->info('No templates found.');

            return 0;
        }

        foreach ($templatesList->getEnvelopeTemplates() as $template) {
            $templateId = $template->getTemplateId();
            $templateName = $template->getName();
            $this->line("Processing template: {$templateName} ({$templateId})");

            // Step 3: Get current recipients
            $recipients = $templatesApi->listRecipients($accountId, $templateId);

            // dump($recipients);

            $ccExists = false;
            if ($recipients && $recipients->getCarbonCopies()) {
                foreach ($recipients->getCarbonCopies() as $cc) {
                    if ($cc->getRoleName() === 'cc') {
                        $ccExists = true;
                        break;
                    }
                }
            }

            if (! $ccExists) {
                $this->info(' -> CC role already exists. Skipping.');

                continue;
            }

            $this->info(' -> Adding CC role...');

            // // DELETE CC
            $recipientsToDelete = new Recipients([
                'carbon_copies' => $recipients->getCarbonCopies(),
            ]);
            $templatesApi->deleteRecipients($accountId, $templateId, $recipientsToDelete);

            $this->line(' -> CC role deleted...' . $accountId . ' - ' . $templateId . ' - ' . $recipientsToDelete);

            // Step 4: Assign a unique recipient_id per template
            // $existingRecipientIds = [];
            // if ($recipients) {
            //     foreach (array_merge(
            //         $recipients->getSigners() ?? [],
            //         $recipients->getCarbonCopies() ?? []
            //     ) as $r) {
            //         $existingRecipientIds[] = (int) $r->getRecipientId();
            //     }
            // }

            // // Find next available recipient_id
            // $recipientId = empty($existingRecipientIds) ? 1 : max($existingRecipientIds) + 1;

            // $ccRole = new CarbonCopy([
            //     'role_name' => 'cc',
            //     'recipient_id' => '10',
            //     'routing_order' => '1',
            // ]);

            // $recipientsUpdate = new Recipients([
            //     'carbon_copies' => [$ccRole],
            // ]);

            if ($dryRun) {
                // $this->line(" [Dry Run] Would update template {$templateName}");
            } else {

                try {
                    // $templatesApi->deleteLock($accountId, $templateId);
                    // $templatesApi->updateRecipients($accountId, $templateId, $recipientsUpdate);
                } catch (\Exception $e) {
                    // ignore if no lock exists
                }

                $this->info(" -> Template updated with CC role - {$templateName}");
            }
        }

        $this->info('All templates processed.');

        return 0;
    }
}
