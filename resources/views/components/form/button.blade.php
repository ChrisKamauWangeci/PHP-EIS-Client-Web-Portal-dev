@props([
'type' => 'submit',
'disabled' => false,
])

<button
    type="{{ $type }}"
    @if($disabled) disabled @endif
    {{ $attributes->merge(['class' => "btn btn-sm btn-secondary"]) }}>
    {{ $slot }}
</button>