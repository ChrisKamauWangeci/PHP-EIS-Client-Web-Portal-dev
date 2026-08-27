<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FollowUpStatusReviewService
{
    protected string $endpoint;

    protected string $apiKey;

    protected string $deployment;

    protected string $apiVersion;

    public function __construct()
    {
        $this->endpoint = (string) env('AZURE_OPENAI_ENDPOINT', '');
        $this->apiKey = (string) env('AZURE_OPENAI_API_KEY', '');
        $this->deployment = (string) env('AZURE_OPENAI_DEPLOYMENT', 'gpt-4o-mini');
        $this->apiVersion = (string) env('AZURE_OPENAI_API_VERSION', '2024-12-01-preview');
    }

    public function reviewNote(array $followUpStatus, int $ageDays = 0): array
    {
        $payload = [
            'previous_notes' => $followUpStatus,
            'request_age_days' => $ageDays,
        ];

        // Multiline heredoc for cleaner system prompt formatting
        $systemPrompt = <<<'PROMPT'
        You are an EIS Status Note Review agent for a medical Release of Information (ROI) system.
        Analyze the provided notes in `previous_notes` and output a JSON object strictly matching this structure:
        {
            "duplicate_analysis": { "is_duplicate": bool, "duplicate_risk": "Low"|"Medium"|"High", "reason": "string" },
            "provider_verification": { "request_received_confirmed": bool, "authorization_received_confirmed": bool, "patient_located_confirmed": bool, "records_exist_confirmed": bool, "turnaround_time_provided": bool, "missing_requirements_identified": bool, "fees_identified": bool, "pending_location_identified": bool, "missing_items": [] },
            "urgency_review": { "urgent_processing_requested": bool, "reduced_turnaround_requested": bool, "supervisor_requested": bool, "recommend_urgency_followup": bool },
            "escalation_review": { "recommend_escalation": bool, "escalation_target": "string|null", "escalation_reason": "string|null" },
            "progression_analysis": { "new_info_obtained": "string", "missing_info_summary": "string", "next_action_recommended": "string", "can_advance_to_retrieval": bool }
        }
        PROMPT;

        // Stage 1-4: Call Azure OpenAI for structured analysis
        $analysis = $this->callAzureOpenAi($systemPrompt, json_encode($payload));
        $analysis = is_array($analysis) ? $analysis : [];

        // Stage 5: Deterministic scoring math
        $scoring = $this->calculateScore($analysis);

        // Stage 6: Status Note Rewrite
        $rewritePrompt = 'You are a Status Note Rewrite agent. Write a single professional revised status note under 900 characters incorporating missing verifications, duplicates, and escalation actions documented. Return JSON with key "revised_status_note".';

        $rewriteData = $this->callAzureOpenAi(
            $rewritePrompt,
            json_encode([
                'previous_notes' => $followUpStatus,
                'analysis' => $analysis,
            ])
        );

        // Fallback representation if LLM fails to return revised_status_note
        $noteTexts = array_map(
            fn($item) => is_array($item) ? ($item['note'] ?? '') : (string) $item,
            $followUpStatus
        );
        $fallbackNote = implode("\n", array_filter($noteTexts));

        return [
            'quality_score' => $scoring['quality_score'],
            'duplicate_risk' => $scoring['duplicate_risk'],
            'save_recommendation' => $scoring['save_recommendation'],
            'reason' => $scoring['reason'],
            'missing_information' => $analysis['provider_verification']['missing_items'] ?? [],
            'suggested_questions' => $this->buildSuggestedQuestions($analysis),
            'alerts' => $scoring['alerts'],
            'revised_status_note' => $rewriteData['revised_status_note'] ?? $fallbackNote,
            'duplicate_analysis' => $analysis['duplicate_analysis'] ?? [],
            'provider_verification' => $analysis['provider_verification'] ?? [],
            'urgency_review' => $analysis['urgency_review'] ?? [],
            'escalation_review' => $analysis['escalation_review'] ?? [],
            'progression_analysis' => $analysis['progression_analysis'] ?? [],
        ];
    }

    protected function calculateScore(array $analysis): array
    {
        $score = 100;
        $alerts = [];
        $missingCount = 0;

        $dup = $analysis['duplicate_analysis'] ?? [];
        $ver = $analysis['provider_verification'] ?? [];
        $urgency = $analysis['urgency_review'] ?? [];
        $escalation = $analysis['escalation_review'] ?? [];

        // Duplicate logic
        if ($dup['is_duplicate'] ?? false) {
            $score -= 20;
            $alerts[] = 'The current status note substantially duplicates previous updates.';
        }

        if (($dup['duplicate_risk'] ?? '') === 'High') {
            $score -= 10;
        } elseif (($dup['duplicate_risk'] ?? '') === 'Medium') {
            $score -= 5;
        }

        // Verification checks (with alerts)
        $verificationAlertMap = [
            'request_received_confirmed' => 'Provider was not asked whether the request was received.',
            'authorization_received_confirmed' => 'Provider was not asked whether the authorization was received.',
            'patient_located_confirmed' => 'Provider was not asked whether the patient is on file.',
            'turnaround_time_provided' => 'Provider did not provide a turnaround time.',
        ];

        foreach ($verificationAlertMap as $field => $alertText) {
            if (! ($ver[$field] ?? false)) {
                $missingCount++;
                $alerts[] = $alertText;
            }
        }

        // Verification checks (no alerts, just deduct score)
        $extraVerifications = [
            'records_exist_confirmed',
            'missing_requirements_identified',
            'fees_identified',
            'pending_location_identified',
        ];

        foreach ($extraVerifications as $field) {
            if (! ($ver[$field] ?? false)) {
                $missingCount++;
            }
        }

        $score -= ($missingCount * 3);

        // Urgency penalties
        if (! ($urgency['urgent_processing_requested'] ?? false) && ! ($urgency['reduced_turnaround_requested'] ?? false)) {
            $score -= 5;
            $alerts[] = 'No urgent processing request was made on an aged request.';
        }

        // Escalation penalties
        if ($escalation['recommend_escalation'] ?? false) {
            $score -= 5;
            $alerts[] = 'No escalation was requested on an aged/repetitive request.';
        }

        // Progression bonus (retained from your PHP implementation if desired)
        $canAdvance = $analysis['progression_analysis']['can_advance_to_retrieval'] ?? false;
        if ($canAdvance) {
            $score += 15;
        }

        $score = max(0, min(100, $score));

        // Recommendation Hierarchy
        if ($escalation['recommend_escalation'] ?? false) {
            $recommendation = 'ESCALATION RECOMMENDED';
        } elseif (($dup['is_duplicate'] ?? false) || $missingCount > 0) {
            $recommendation = 'REVIEW RECOMMENDED';
        } else {
            $recommendation = 'APPROVED';
        }

        // Dynamic Reason Generation
        $reasonParts = [];
        if (! empty($dup['reason'])) {
            $reasonParts[] = $dup['reason'];
        }
        if (! empty($ver['missing_items'])) {
            $reasonParts[] = 'Missing provider verification: ' . implode(', ', $ver['missing_items']) . '.';
        }
        if ($escalation['recommend_escalation'] ?? false) {
            $reasonParts[] = $escalation['escalation_reason'] ?? 'Escalation recommended.';
        }

        return [
            'quality_score' => $score,
            'save_recommendation' => $recommendation,
            'duplicate_risk' => $dup['duplicate_risk'] ?? 'Low',
            'reason' => ! empty($reasonParts) ? implode(' ', $reasonParts) : 'Note reviewed.',
            'alerts' => $alerts,
        ];
    }

    protected function buildSuggestedQuestions(array $analysis): array
    {
        $questions = [];
        $ver = $analysis['provider_verification'] ?? [];
        $urgency = $analysis['urgency_review'] ?? [];
        $escalation = $analysis['escalation_review'] ?? [];

        $questionMap = [
            'request_received_confirmed' => 'Did you receive our request?',
            'authorization_received_confirmed' => 'Did you receive our authorization?',
            'patient_located_confirmed' => 'Is the patient on file?',
            'records_exist_confirmed' => 'Do records exist for this patient?',
            'turnaround_time_provided' => 'What is your current turnaround time?',
            'missing_requirements_identified' => 'Is anything preventing release of the records?',
            'fees_identified' => 'Are there any fees required?',
            'pending_location_identified' => 'Who is currently assigned to process the request, and where is it currently pending?',
        ];

        foreach ($questionMap as $field => $question) {
            if (! ($ver[$field] ?? false)) {
                $questions[] = $question;
            }
        }

        if (! ($urgency['urgent_processing_requested'] ?? false)) {
            $questions[] = 'Can this request be processed urgently?';
        }
        if (! ($urgency['reduced_turnaround_requested'] ?? false)) {
            $questions[] = 'Can the turnaround time be reduced?';
        }
        if (($escalation['recommend_escalation'] ?? false) && ! ($urgency['supervisor_requested'] ?? false)) {
            $questions[] = 'Can this request be escalated to a supervisor?';
        }

        $questions[] = 'When should we follow up again?';

        return $questions;
    }

    protected function callAzureOpenAi(string $systemPrompt, string $userContent): array
    {
        $url = "{$this->endpoint}/openai/deployments/{$this->deployment}/chat/completions?api-version={$this->apiVersion}";

        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])
            ->timeout(15) // Prevent hanging if the API is unresponsive
            ->post($url, [
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userContent],
                ],
                'response_format' => ['type' => 'json_object'],
                'temperature' => 0,
            ])->throw(); // Throws RequestException on 4xx/5xx errors

        return json_decode($response->json('choices.0.message.content') ?? '{}', true);
    }
}
