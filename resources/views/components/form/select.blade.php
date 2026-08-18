@props([
'name' => '',
'id' => null,
'label' => null,
'options' => [],
'placeholder' => null,
'empty' => null,
'default' => null,
'required' => false,
])

@if ($label)
<x-form.label :for="$attributes->get('id') ?? $id ?? $name" :label="$label" :required="$required" />
@endif

<select name="{{ $name }}" id="{{ $attributes->get('id') ?? $id ?? $name }}" {{ $attributes->merge(['class' => 'form-select form-select-sm', 'required' => $required ? true : null,]) }}>
    @if ($placeholder && !$empty)
    <option value="" disabled selected>{{ $placeholder }}</option>
    @endif
    @if ($empty && !$placeholder)
    <option value="">{{ $empty }}</option>
    @endif
    @foreach ($options as $key => $option)
    <option value="{{ $key }}" @selected(old($name, $default) === (string) $key)>{{ $option }}</option>
    @endforeach
</select>

<x-form.error :name="$name" />