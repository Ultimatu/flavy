@php

$name = $name ?? '';
$label = $label ?? $name;
$placeholder = $placeholder ?? $label;
$value = $value ?? '';
$required = $required ?? false;

@endphp

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{old($name, $value)}}" {{ $required ? 'required' : '' }}>

    @error($name)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

