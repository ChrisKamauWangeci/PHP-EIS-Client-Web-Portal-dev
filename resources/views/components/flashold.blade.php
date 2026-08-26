@foreach (['success', 'danger', 'warning', 'info'] as $type)
    @if ($messages = Session::get($type))
        @php
            $messages = is_array($messages) ? $messages : [$messages];
        @endphp

        @foreach ($messages as $message)
            <div class="flash alert alert-{{ $type }}">
                {!! $message !!}
            </div>
        @endforeach
    @endif
@endforeach
