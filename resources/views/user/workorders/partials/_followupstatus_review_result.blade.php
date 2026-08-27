@if (!empty($result['error']))
    <div class="alert alert-danger shadow-sm p-3 mb-2">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $result['message'] }}
    </div>
@else
    <div class="card card-body bg-light border p-2 mb-2 shadow-sm">

        {{-- @dump($result) --}}

        <div class="d-flex align-items-center gap-2 mb-2 mt-2 border-top pt-2">
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

        <div class="mt-2 border-top pt-2" style="color: #374151;">
            <strong>Reason:</strong>
            <p class="mb-1 mb-0 text-black" style="color: #374151;">
                {{ $result['reason'] }}</p>
        </div>

        @if (!empty($result['alerts']))
            <div class="text-danger mt-2 border-top pt-2">
                <strong>Alerts:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($result['alerts'] as $alert)
                        <li>{{ $alert }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if (!empty($result['missing_information']))
            <div class="text-danger mb-1 mt-2 border-top pt-2">
                <strong>Missing Verifications:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($result['missing_information'] as $missing)
                        <li>{{ $missing }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (!empty($result['suggested_questions']))
            <div class="mt-2 border-top pt-2" style="color: #374151;">
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
                <ul class="mb-2 ps-3 ">
                    <li><strong>New Info Obtained:</strong>
                        {{ $result['progression_analysis']['new_info_obtained'] ?? 'None identified' }}</li>
                    <li><strong>Still Missing:</strong>
                        {{ $result['progression_analysis']['missing_info_summary'] ?? 'None' }}</li>
                    <li><strong>Next Action:</strong>
                        {{ $result['progression_analysis']['next_action_recommended'] ?? 'Awaiting further review' }}
                    </li>
                </ul>
                <span
                    class="badge {{ !empty($result['progression_analysis']['can_advance_to_retrieval']) && $result['progression_analysis']['can_advance_to_retrieval'] ? 'bg-success' : 'bg-danger' }}">
                    Ready for Retrieval:
                    {{ !empty($result['progression_analysis']['can_advance_to_retrieval']) && $result['progression_analysis']['can_advance_to_retrieval'] ? 'YES' : 'No' }}
                </span>
            </div>
        @endif


        <div class="mt-2 border-top pt-2" style="color: #374151;">
            <strong>Suggested Rewrite:</strong>
            <p class="mb-0 text-black" style="color: #000;" id="suggested-rewrite-text">
                {{ $result['revised_status_note'] }}</p>
        </div>


        <div class="mt-2 border-top pt-2 d-flex align-items-center">
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
@endif
