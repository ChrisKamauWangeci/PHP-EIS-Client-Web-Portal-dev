<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Workorder;
use App\Services\FollowUpStatusReviewService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FollowUpStatusReviewController extends Controller
{
    /**
     * Evaluates workorder status history using AI and renders the review partial.
     */
    public function review(Request $request, Workorder $workorder, FollowUpStatusReviewService $reviewService): View
    {
        $followUpStatus = $this->getStructuredStatusNotes($workorder);

        $ageDays = (int) ($workorder->W_ReceiveDate ? $workorder->W_ReceiveDate->diffInDays(now()) : 0);

        $result = $reviewService->reviewNote($followUpStatus, $ageDays);

        return view('user.workorders.partials._followupstatus_review_result', compact('result'));
    }

    /**
     * Parses multiline follow-up status text into structured note objects.
     *
     * @return array<int, array{id: int, created_date: string, note: string}>
     */
    private function getStructuredStatusNotes(Workorder $workorder): array
    {
        $rawStatus = (string) $workorder->W_FollowUpStatus;

        $lines = preg_split('/\r\n|\r|\n/', $rawStatus) ?: [];

        $cleanLines = array_values(array_filter(array_map('trim', $lines)));

        $notes = [];
        $totalLines = count($cleanLines);
        $now = now();

        foreach ($cleanLines as $index => $noteText) {
            $daysAgo = $totalLines - $index;

            $notes[] = [
                'id' => $index + 1,
                'created_date' => $now->copy()->subDays($daysAgo)->toIso8601String(),
                'note' => $noteText,
            ];
        }

        return $notes;
    }
}