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
        $this->endpoint = rtrim((string) env('AZURE_OPENAI_ENDPOINT', ''), '/');
        $this->apiKey = (string) env('AZURE_OPENAI_API_KEY', '');
        $this->deployment = (string) env('AZURE_OPENAI_DEPLOYMENT', 'gpt-4o-mini');
        $this->apiVersion = (string) env('AZURE_OPENAI_API_VERSION', '2024-12-01-preview');
    }

    public function reviewNote(string $currentNote, array $previousNotes, int $ageDays = 0): array
    {
        $payload = [
            'current_note' => $currentNote,
            'previous_notes' => $previousNotes,
            'request_age_days' => $ageDays,
        ];

        // Combine analysis stages into a structured JSON completion request
        $systemPrompt = "You are an EIS Status Note Review agent for a medical Release of Information (ROI) system.
Analyze current_note against previous_notes and output a JSON object containing:
1. duplicate_analysis: { is_duplicate: bool, duplicate_risk: 'Low'|'Medium'|'High', reason: string }
2. provider_verification: { request_received_confirmed: bool, authorization_received_confirmed: bool, patient_located_confirmed: bool, records_exist_confirmed: bool, turnaround_time_provided: bool, missing_requirements_identified: bool, fees_identified: bool, pending_location_identified: bool, missing_items: array }
3. urgency_review: { urgent_processing_requested: bool, reduced_turnaround_requested: bool, supervisor_requested: bool, recommend_urgency_followup: bool }
4. escalation_review: { recommend_escalation: bool, escalation_target: string|null, escalation_reason: string|null }";

        $analysis = $this->callAzureOpenAi($systemPrompt, json_encode($payload));

        // Stage 5: Deterministic Python scoring math ported to PHP
        $scoring = $this->calculateScore($analysis);

        // Stage 6: Status Note Rewrite
        $rewritePrompt = 'You are a Status Note Rewrite agent. Write a single professional revised status note under 900 characters incorporating missing verifications, duplicates, and escalation actions documented.';
        $rewriteData = $this->callAzureOpenAi($rewritePrompt, json_encode(['current_note' => $currentNote, 'analysis' => $analysis]));

        return array_merge($scoring, [
            'missing_information' => $analysis['provider_verification']['missing_items'] ?? [],
            'suggested_questions' => $this->buildSuggestedQuestions($analysis),
            'revised_status_note' => $rewriteData['revised_status_note'] ?? $currentNote,
            'raw_analysis' => $analysis,
        ]);
    }

    protected function calculateScore(array $analysis): array
    {
        $score = 100;
        $alerts = [];

        $dup = $analysis['duplicate_analysis'] ?? [];
        if ($dup['is_duplicate'] ?? false) {
            $score -= 20;
            $alerts[] = 'The current status note substantially duplicates previous updates.';
        }

        if (($dup['duplicate_risk'] ?? '') === 'High') {
            $score -= 10;
        } elseif (($dup['duplicate_risk'] ?? '') === 'Medium') {
            $score -= 5;
        }

        $ver = $analysis['provider_verification'] ?? [];
        $missingCount = 0;
        $checks = [
            'request_received_confirmed' => 'Provider was not asked whether the request was received.',
            'authorization_received_confirmed' => 'Provider was not asked whether authorization was received.',
            'patient_located_confirmed' => 'Provider was not asked whether the patient is on file.',
            'turnaround_time_provided' => 'Provider did not provide a turnaround time.',
        ];

        foreach ($checks as $field => $alertText) {
            if (! ($ver[$field] ?? false)) {
                $missingCount++;
                $alerts[] = $alertText;
            }
        }

        $score -= ($missingCount * 3);
        $score = max(0, min(100, $score));

        $recommendation = 'APPROVED';
        if ($analysis['escalation_review']['recommend_escalation'] ?? false) {
            $recommendation = 'ESCALATION RECOMMENDED';
        } elseif (($dup['is_duplicate'] ?? false) || $missingCount > 0) {
            $recommendation = 'REVIEW RECOMMENDED';
        }

        return [
            'quality_score' => $score,
            'save_recommendation' => $recommendation,
            'duplicate_risk' => $dup['duplicate_risk'] ?? 'Low',
            'reason' => $dup['reason'] ?? 'Note reviewed.',
            'alerts' => $alerts,
        ];
    }

    protected function buildSuggestedQuestions(array $analysis): array
    {
        $questions = [];
        $ver = $analysis['provider_verification'] ?? [];

        if (! ($ver['request_received_confirmed'] ?? false)) {
            $questions[] = 'Did you receive our request?';
        }
        if (! ($ver['authorization_received_confirmed'] ?? false)) {
            $questions[] = 'Did you receive our authorization?';
        }
        if (! ($ver['patient_located_confirmed'] ?? false)) {
            $questions[] = 'Is the patient on file?';
        }
        if (! ($ver['turnaround_time_provided'] ?? false)) {
            $questions[] = 'What is your current turnaround time?';
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
        ])->post($url, [
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userContent],
            ],
            'response_format' => ['type' => 'json_object'],
            'temperature' => 0,
        ]);

        return json_decode($response->json('choices.0.message.content') ?? '{}', true);
    }
}
