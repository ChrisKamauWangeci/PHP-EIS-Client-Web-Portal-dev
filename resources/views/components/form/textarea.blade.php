@props([
    'name',
    'label' => null,
    'value' => '',
    'rows' => 4,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'spellcheck' => true,
    'error' => null,
])

@php
    $textareaId = $attributes->get('id') ?? $name;
    $errorMessage = $error ?? $errors->first($name);
    $hasError = !empty($errorMessage);
@endphp

@if ($label)
    <x-form.label :for="$textareaId"
                  :label="$label"
                  :required="$required" />
@endif

<textarea {{ $attributes->merge([
    'id' => $textareaId,
    'name' => $name,
    'rows' => $rows,
    'placeholder' => $placeholder,
    'required' => $required ? 'true' : null,
    'disabled' => $disabled ?: null,
    'readonly' => $readonly ?: null,
    'spellcheck' => $spellcheck ? 'true' : 'false',
    'class' => 'form-control form-control-sm' . ($errorMessage ? ' is-invalid' : ''),
]) }}
          @if ($hasError) oninput="if(this.classList.contains('is-invalid')) { this.classList.remove('is-invalid'); let msg = this.nextElementSibling; if(msg && msg.classList.contains('text-danger')) { msg.remove(); } }" @endif>{{ old($name, $value) }}</textarea>

@if ($hasError)
    <div class="text-sm text-danger">{{ $errorMessage }}</div>
@endif
