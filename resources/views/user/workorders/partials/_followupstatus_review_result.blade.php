<div class="card card-body bg-light border p-2 mb-2 shadow-sm">

    @dump($result)

    <div class="d-flex align-items-center gap-2 mb-2">
        <span
            class="badge {{ $result['quality_score'] >= 90 ? 'bg-success' : ($result['quality_score'] >= 40 ? 'bg-warning text-dark' : 'bg-danger') }}">
            Score: {{ $result['quality_score'] }}/100
        </span>
        <span
            class="badge {{ $result['save_recommendation'] === 'APPROVED' ? 'bg-success' : ($result['save_recommendation'] === 'REVIEW RECOMMENDED' ? 'bg-warning text-dark' : 'bg-danger') }}">
            {{ $result['save_recommendation'] }}
        </span>
        <span
            class="badge {{ $result['duplicate_risk'] === 'High' ? 'bg-danger' : ($result['duplicate_risk'] === 'Medium' ? 'bg-warning text-dark' : 'bg-secondary') }}">
            Duplicate Risk: {{ $result['duplicate_risk'] }}
        </span>
    </div>

    <p class="mb-1" style="color: #374151;"><strong>Reason:</strong> {{ $result['reason'] }}</p>

    @if (!empty($result['alerts']))
        <div class="text-danger small mb-1">
            <strong>Alerts:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($result['alerts'] as $alert)
                    <li>{{ $alert }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- NEW: Explicitly list missing verifications pulled from the Python logic --}}
    @if (!empty($result['missing_information']))
        <div class="text-danger small mb-1">
            <strong>Missing Verifications:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($result['missing_information'] as $missing)
                    <li>{{ $missing }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!empty($result['suggested_questions']))
        <div class="small mb-1" style="color: #4b5563;">
            <strong>Suggested Questions:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($result['suggested_questions'] as $question)
                    <li>{{ $question }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!empty($result['progression_analysis']))
        <div class="mt-2 border-top pt-2" style="color: #374151;">
            <strong>Request Progression Status:</strong>
            <ul class="mb-2 ps-3 small">
                <li><strong>New Info Obtained:</strong>
                    {{ $result['progression_analysis']['new_info_obtained'] ?? 'None identified' }}</li>
                <li><strong>Still Missing:</strong>
                    {{ $result['progression_analysis']['missing_info_summary'] ?? 'None' }}</li>
                <li><strong>Next Action:</strong>
                    {{ $result['progression_analysis']['next_action_recommended'] ?? 'Awaiting further review' }}</li>
            </ul>
            <span
                class="badge {{ !empty($result['progression_analysis']['can_advance_to_retrieval']) && $result['progression_analysis']['can_advance_to_retrieval'] ? 'bg-success' : 'bg-secondary' }}">
                Ready for Retrieval:
                {{ !empty($result['progression_analysis']['can_advance_to_retrieval']) && $result['progression_analysis']['can_advance_to_retrieval'] ? 'Yes' : 'No' }}
            </span>
        </div>
    @endif

    <div class="mt-2 border-top pt-2 d-flex justify-content-between align-items-start">
        <div>
            <strong>Suggested Rewrite:</strong>
            <p class="fst-italic mb-0 text-dark" id="suggested-rewrite-text">{{ $result['revised_status_note'] }}</p>
        </div>
        <button type="button" class="btn btn-xs btn-outline-primary ms-2" onclick="applyRewrite()">
            Apply
        </button>
    </div>
</div>

<script>
    function applyRewrite() {
        const text = document.getElementById('suggested-rewrite-text')?.innerText;
        const textarea = document.getElementById('note');
        if (text && textarea) {
            textarea.value = text;
            textarea.dispatchEvent(new Event('input')); // Triggers counter update
        }
    }
</script>
