@props([
    'name' => '',
    'id' => null,
    'label' => null,
    'options' => [],
    'placeholder' => null,
    'empty' => null,
    'default' => null,
    'required' => false,
    'type' => 'text',
    'onchange' => '',
])

@if ($label)
    <x-form.label :for="$attributes->get('id') ?? ($id ?? $name)" :label="$label" :required="$required" />
@endif

<input list="{{ $name }}" name="{{ $name }}" type="text" value="{{ $default }}" {{ $attributes->merge(['class' => 'form-select form-select-sm', 'required' => $required ? true : null]) }}>

<datalist id="{{ $name }}">
    @foreach ($options as $key => $option)
        <option value="{{ $key }}">{{ $option }}</option>
    @endforeach
</datalist>

<x-form.error :name="$name" />