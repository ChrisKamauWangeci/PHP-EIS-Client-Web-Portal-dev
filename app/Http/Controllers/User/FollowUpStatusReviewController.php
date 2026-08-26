<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Workorder;
use App\Services\FollowUpStatusReviewService;
use Illuminate\Http\Request;

class FollowUpStatusReviewController extends Controller
{
    public function review(Request $request, Workorder $workorder, FollowUpStatusReviewService $reviewService)
    {
        // 1. Sanitize draft note input from request
        $noteText = trim((string) $request->input('note'));

        // 2. Guard against empty submissions to prevent validation redirects
        if (empty($noteText)) {
            return response('<div class="alert alert-warning p-2 mb-0 small">Please select or type a note before running the review.</div>');
        }

        // 3. Extract historical structured notes from workorder
        $previousNotes = $this->getStructuredStatusNotes($workorder);

        // 4. Calculate total age of request in days
        $ageDays = (int) ($workorder->W_ReceiveDate ? $workorder->W_ReceiveDate->diffInDays(now()) : 0);

        // 5. Send structured payload to Azure OpenAI service
        $result = $reviewService->reviewNote($noteText, $previousNotes, $ageDays);

        // 6. Return HTML partial to populate HTMX container
        return view('user.workorders.partials._review_result', compact('result'));
    }

    private function getStructuredStatusNotes(Workorder $workorder): array
    {
        // Step 1: Fetch raw multiline text blob from W_FollowUpStatus column
        $rawStatus = (string) $workorder->W_FollowUpStatus;

        // Step 2: Split text into lines across all line-break formats (\r\n, \n, \r)
        $lines = preg_split('/\r\n|\r|\n/', $rawStatus);

        // Step 3: Strip whitespace and filter out blank lines
        $cleanLines = [];
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed !== '') {
                $cleanLines[] = $trimmed;
            }
        }

        $notes = [];
        $totalLines = count($cleanLines);
        $now = now();

        // Step 4: Synthesize incremental IDs and relative created dates for each line
        foreach ($cleanLines as $index => $noteText) {
            // Calculate relative days ago (older notes appear first, newest last)
            $daysAgo = $totalLines - $index;

            $notes[] = [
                'id' => $index + 1,
                'created_date' => $now->copy()->subDays($daysAgo)->toIso8601String(),
                'note' => $noteText,
            ];
        }

        // Step 5: Return array of structured note objects
        return $notes;
    }
}
