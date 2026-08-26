@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autocomplete' => null,
])

@php
    $inputId = $attributes->get('id') ?? $name;
@endphp

@if ($label)
    <x-form.label :for="$inputId"
                  :label="$label"
                  :required="$required" />
@endif

<input
       {{ $attributes->merge([
           'type' => $type,
           'name' => $name,
           'id' => $inputId,
           'value' => in_array($type, ['password', 'file']) ? null : old($name, $value),
           'placeholder' => $placeholder,
           'autocomplete' => $autocomplete,
           'class' => 'form-control form-control-sm',
           'required' => $required ?: null,
           'disabled' => $disabled ?: null,
           'readonly' => $readonly ?: null,
       ]) }} />

<x-form.error :name="$name" />
