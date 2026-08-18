<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Docusigndocument;
use App\Models\Docusignevent;
use App\Models\Statustrigger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DocusigneventController extends Controller
{
    public function webhook(Request $request)
    {
        $logDirectory = storage_path('persistent_logs/docusign/' . date('Y-m') . '/' . date('d'));

        if (! is_dir($logDirectory)) {
            mkdir($logDirectory, 0777, true);
        }

        $rawPayload = $request->getContent();

        $payload = json_decode($rawPayload, true);

        if (! is_array($payload)) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $envelopeId = data_get($payload, 'data.envelopeId');
        $event = data_get($payload, 'event');
        $generatedAtRaw = data_get($payload, 'generatedDateTime');

        if (! $envelopeId || ! $event || ! $generatedAtRaw) {
            return response()->json(['error' => 'Missing required fields'], 400);
        }

        $generatedAt = Carbon::parse($generatedAtRaw);

        $logFilePath = $logDirectory . '/' . 'docusign-' . now()->format('Ymd-His-u') . '.txt';
        file_put_contents(
            $logFilePath,
            $rawPayload . PHP_EOL . PHP_EOL . print_r($payload, true),
            LOCK_EX
        );

        $docusignevent = new Docusignevent();
        $docusignevent->envelopeid = $envelopeId;
        $docusignevent->event = $event;
        $docusignevent->data = $rawPayload;
        $docusignevent->generated_at = $generatedAt;
        $docusignevent->processed_at = now();
        $docusignevent->save();

        $docusigndocument = Docusigndocument::query()
            ->where('envelopeid', $envelopeId)
            ->first();

        if ($docusigndocument) {
            $docusigndocument->status = $event;
            $docusigndocument->statuses = ($docusigndocument->statuses ?? '') . $generatedAt->format('Y-m-d H:i:s') . ' - ' . $docusignevent->event . "\r\n";

            if ($event === 'envelope-completed') {
                $docusigndocument->signed_at = now();
            }

            $docusigndocument->save();

            if ($docusigndocument->signingtype === 'email') {

                $database = $docusigndocument->db ?? 'eisuat';

                $eventStatusMap = [
                    'envelope-sent' => '801',
                    'envelope-delivered' => '802',
                    'envelope-completed' => '803',
                    'envelope-declined' => '804',
                    'envelope-resent' => '805',
                    'recipient-authenticationfailed' => '806',
                ];

                if (isset($eventStatusMap[$event])) {

                    Statustrigger::on($database)->create([
                        'WorkOrderNo' => $docusigndocument->workorder_id,
                        'statuscode' => $eventStatusMap[$event],
                        'laststatus' => $eventStatusMap[$event] . ': Docusign Event: ' . $event . ' (' . now()->format('g:i:s A') . ')',
                        'Created' => now(),
                        'CreatedBy' => $docusigndocument->requestor,
                        'ChangeType' => 'S',
                    ]);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
