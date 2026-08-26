@props([
    'name' => '',
    'label' => '',
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'required' => false,
])

@php
    $id = $attributes->get('id', $name);
@endphp

<div {{ $attributes->class('form-check') }}>
    <input type="hidden"
           name="{{ $name }}"
           value="0">

    <input type="checkbox"
           name="{{ $name }}"
           id="{{ $id }}-checkbox"
           value="{{ $value }}"
           @checked(old($name, $checked))
           @disabled($disabled)
           @required($required)
           {{ $attributes->except(['class', 'id'])->class('form-check-input') }}>

    @if ($label)
        <label for="{{ $id }}-checkbox"
               class="form-check-label">
            {{ $label }}
        </label>
    @endif
</div>
