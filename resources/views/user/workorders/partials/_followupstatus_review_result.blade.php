@if (!empty($result['error']))
    <div class="alert alert-danger shadow-sm p-3 mb-2">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $result['message'] }}
    </div>
@else
    <div class="card card-body bg-light border p-3 mb-2 shadow-sm">

        {{-- @dump($result) --}}

        <div class="d-flex flex-column gap-2 mb-3">

            @isset($result['progression_analysis']['can_advance_to_retrieval'])
                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                    <strong class="text-secondary small">Ready for Retrieval:</strong>
                    <span
                        class="badge {{ $result['progression_analysis']['can_advance_to_retrieval'] ? 'bg-success' : 'bg-danger' }} ">
                        {{ $result['progression_analysis']['can_advance_to_retrieval'] ? 'YES' : 'NO' }}
                    </span>
                </div>
            @endisset

            @isset($result['quality_score'])
                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                    <strong class="text-secondary small">Quality Score:</strong>
                    <span
                        class="badge {{ $result['quality_score'] >= 90 ? 'bg-success' : ($result['quality_score'] >= 40 ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ $result['quality_score'] }}/100
                    </span>
                </div>
            @endisset

            @if (!empty($result['save_recommendation']))
                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                    <strong class="text-secondary small">Recommendation:</strong>
                    <span
                        class="badge {{ $result['save_recommendation'] === 'APPROVED' ? 'bg-success' : ($result['save_recommendation'] === 'REVIEW RECOMMENDED' ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ $result['save_recommendation'] }}
                    </span>
                </div>
            @endif

            @if (!empty($result['duplicate_risk']))
                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                    <strong class="text-secondary small">Duplicate Risk:</strong>
                    <span
                        class="badge {{ $result['duplicate_risk'] === 'High' ? 'bg-danger' : ($result['duplicate_risk'] === 'Medium' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                        {{ $result['duplicate_risk'] }}
                    </span>
                </div>
            @endif
        </div>

        @if (!empty($result['reason']))
            <div class="mb-3 border-top pt-3">
                <strong class="text-secondary">Reason:</strong>
                <p class="mb-0 text-dark">
                    {{ $result['reason'] }}
                </p>
            </div>
        @endif

        @if (!empty($result['alerts']))
            <div class="text-danger mb-3 border-top pt-2">
                <strong>Alerts:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($result['alerts'] as $alert)
                        <li>{{ $alert }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (!empty($result['missing_information']))
            <div class="text-danger mb-3 border-top pt-2">
                <strong>Missing Verifications:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($result['missing_information'] as $missing)
                        <li>{{ $missing }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (!empty($result['suggested_questions']))
            <div class="mb-3 border-top pt-2">
                <strong class="text-secondary">Suggested Questions:</strong>
                <ul class="mb-0 ps-3 text-dark">
                    @foreach ($result['suggested_questions'] as $question)
                        <li>{{ $question }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (!empty($result['progression_analysis']))
            <div class="mb-3 border-top pt-2">
                <strong class="text-secondary">Request Progression Status:</strong>
                <ul class="mb-2 ps-3 text-dark">
                    <li><strong>New Info Obtained:</strong>
                        {{ $result['progression_analysis']['new_info_obtained'] ?? 'None identified' }}</li>
                    <li><strong>Still Missing:</strong>
                        {{ $result['progression_analysis']['missing_info_summary'] ?? 'None' }}</li>
                    <li><strong>Next Action:</strong>
                        {{ $result['progression_analysis']['next_action_recommended'] ?? 'Awaiting further review' }}
                    </li>
                </ul>
            </div>
        @endif

        @if (!empty($result['revised_status_note']))
            <div class="mb-2 border-top pt-3">
                <label for="suggested-rewrite-text" class="form-label text-secondary fw-bold">Suggested Rewrite:</label>
                <textarea class="form-control mb-2 text-dark fw-medium bg-white" id="suggested-rewrite-text" rows="10" readonly>{{ $result['revised_status_note'] }}</textarea>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-sm btn-outline-primary text-nowrap" onclick="applyRewrite()">
                        <i class="bi bi-box-arrow-in-down me-1"></i> Apply
                    </button>
                </div>
            </div>

            <script>
                if (typeof applyRewrite !== 'function') {
                    function applyRewrite() {
                        const inputEl = document.getElementById('suggested-rewrite-text');
                        const text = inputEl?.value || inputEl?.innerText;
                        const textarea = document.getElementById('note');
                        if (text && textarea) {
                            textarea.value = text;
                            textarea.dispatchEvent(new Event('input'));
                        }
                    }
                }
            </script>
        @endif
    </div>
@endif
