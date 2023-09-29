@php

$name = $name ?? '';
$label = $label ?? $name;
$placeholder = $placeholder ?? $label;
$value = $value ?? '';
$required = $required ?? false;
$selectOptions = $selectOptions ?? [];
$key = $key ?? 'id';
$disp = $disp;
$displayer = $displayer ?? '--Select--';

$selected = old($name, $value);
@endphp


<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select class="form-control" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}>
        <option value="">{{ $displayer }}</option>
        @foreach ($selectOptions as $option)
            <option value="{{ $option->$key }}" {{ $option->$key == $selected ? 'selected' : '' }}>{{ $option->$disp }}</option>
        @endforeach
    </select>

    @error($name)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

</div>
