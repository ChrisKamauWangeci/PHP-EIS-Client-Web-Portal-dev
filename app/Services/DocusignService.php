<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Docusigndocument;
use DocuSign\eSign\Api\AccountsApi;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Model\AccountSettingsInformation;

class DocusignService
{
    public function __construct()
    {
        //
    }

    public function getToken($environment): string
    {

        try {

            if ($environment == 'production') {
                $basepath = 'account.docusign.com';
                $integratorKey = 'fe9c4982-3d4f-4aa6-bfb4-6f89f20dc942'; // prod docusign@
                $userId = '6a0141b2-05a6-460f-9583-d2c1f31e8bb4'; // prod docusign@express
                $privateKey = file_get_contents(base_path('private-prod-docusign.key')); // production
            } else {
                $basepath = 'account-d.docusign.com';
                $integratorKey = 'fe9c4982-3d4f-4aa6-bfb4-6f89f20dc942'; // test docusign@
                $userId = '43807d23-7ae7-4526-8861-a6ea6aea05c2'; // test docusign@express...
                $privateKey = file_get_contents(base_path('private-test-docusign.key')); // test
            }

            $apiClient = new ApiClient();

            $apiClient->getOAuth()->setOAuthBasePath($basepath);

            $response = $apiClient->requestJWTUserToken($integratorKey, $userId, $privateKey, 'signature impersonation');

            $token = $response[0];

            $accessToken = $token->getAccessToken();
        } catch (\Throwable $th) {
            print_r($th);
            exit;
        }

        return $accessToken;
    }

    public function download(Docusigndocument $docusigndocument)
    {

        $docusigndocument = Docusigndocument::find($docusigndocument->id);

        if (! $docusigndocument) {
            return;
        }

        if ($docusigndocument->environment == 'production') {
            $basepath = 'account.docusign.com';
            $host = 'https://na4.docusign.net/restapi';
        } else {
            $basepath = 'account-d.docusign.com';
            $host = 'https://demo.docusign.net/restapi';
        }

        try {

            $accessToken = $this->getToken($docusigndocument->environment);

            $config = new Configuration();
            $config->setHost($host);
            $config->addDefaultHeader('Authorization', 'Bearer ' . $accessToken);

            $apiClient = new ApiClient($config);
            $apiClient->getOAuth()->setOAuthBasePath($basepath);

            $userInfo = $apiClient->getUserInfo($accessToken);
            $account_id = $userInfo[0]['accounts'][0]['account_id'];

            $accountsApi = new AccountsApi($apiClient);

            if ($docusigndocument['status'] == 'envelope-completed' && $docusigndocument['signingtype'] == 'email') {
                $attach_certificate = true;
            } else {
                $attach_certificate = false;
            }

            $settings_info = new AccountSettingsInformation([
                'signer_attach_certificate_to_envelope_pdf' => $attach_certificate,
            ]);

            $response = $accountsApi->updateSettings($account_id, $settings_info);

            $envelope_api = new EnvelopesApi($apiClient);

            $docStream = $envelope_api->getDocument($account_id, 'combined', $docusigndocument->envelopeid);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            exit();
        }

        $file = '//ftpserver/documents/websiterecords/' . $docusigndocument->workorder_id . '-unsigned.pdf';

        if ($docusigndocument['status'] == 'envelope-completed' && $docusigndocument['signingtype'] == 'email') {
            $file = '//ftpserver/documents/websiterecords/' . $docusigndocument['workorder_id'] . '-signed.pdf';
        }

        file_put_contents($file, file_get_contents($docStream->getPathname()));

        if (is_file($file)) {
            $docusigndocument->downloaded_at = now();
            $docusigndocument->save();

            if ($docusigndocument['environment'] == 'production') {
                if ($docusigndocument['status'] == 'envelope-completed' && $docusigndocument['signingtype'] == 'email') {
                    $folder = '//ftpserver/ftpserver/NoteFile/WebUploadAuth/docusign/';
                    @copy($file, $folder . $docusigndocument['workorder_id'] . '.pdf');
                }
            }
        }

        if ($docusigndocument['status'] == 'envelope-completed' && $docusigndocument['signingtype'] == 'email') {
            sleep(1);
            $docStream = $envelope_api->getDocument($account_id, 'certificate', $docusigndocument->envelopeid);
            $file = '//ftpserver/documents/websiterecords/' . $docusigndocument['workorder_id'] . '-certificate.pdf';
            file_put_contents($file, file_get_contents($docStream->getPathname()));
        }

        return $docusigndocument;
    }
}
