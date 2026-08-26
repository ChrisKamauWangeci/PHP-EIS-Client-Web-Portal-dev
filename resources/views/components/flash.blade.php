<style>
    #flash-wrapper {
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        width: 50vw;
        max-width: 600px;
        z-index: 1080;
        pointer-events: none;
    }

    .flash {
        pointer-events: auto;
        animation: slideUp .25s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(1rem);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    (function() {
        function initFlash(root = document) {
            root.querySelectorAll('.flash').forEach(el => {
                if (el.dataset.init) return;
                el.dataset.init = true;

                // Auto-hide after 6 seconds
                setTimeout(() => {
                    const alert = bootstrap.Alert.getOrCreateInstance(el);
                    alert.close();
                }, 8000);
            });
        }

        document.addEventListener('DOMContentLoaded', () => initFlash());
        document.addEventListener('htmx:afterSwap', (e) => initFlash(e.target));
    })();
</script>

@foreach (['success', 'danger', 'warning', 'info'] as $type)
    @if ($messages = Session::get($type))
        @php
            $messages = is_array($messages) ? $messages : [$messages];
        @endphp

        @foreach ($messages as $message)
            <div class="flash alert alert-{{ $type }} alert-dismissible fade show shadow"
                 role="alert">
                {!! $message !!}
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endforeach
    @endif
@endforeach
