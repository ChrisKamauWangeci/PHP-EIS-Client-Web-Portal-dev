@props([
    'for' => '',
    'label' => '',
    'required' => false,
])

<label for="{{ $for }}">
    {{ $label }}@if ($required)
        <span class="text-danger">*</span>
    @endif
</label>
