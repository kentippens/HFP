@props([
    'type' => 'checkbox', // 'checkbox' or 'radio'
    'name',
    'id' => null,
    'label',
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'required' => false,
    'ariaDescribedby' => null,
    'helpText' => null,
    'error' => null,
    'class' => '',
    'inputClass' => '',
    'labelClass' => '',
    'wrapperClass' => '',
    'inline' => false
])

@php
    $inputId = $id ?? $type . '-' . $name . '-' . str_replace(' ', '-', $value) . '-' . uniqid();
    $errorId = $error ? $inputId . '-error' : null;
    $helpId = $helpText ? $inputId . '-help' : null;
    $ariaDescribedbyValue = collect([$ariaDescribedby, $errorId, $helpId])->filter()->implode(' ');
    $isChecked = old($name, $checked) == $value;
@endphp

<div class="form-check {{ $inline ? 'form-check-inline' : '' }} {{ $wrapperClass }} {{ $error ? 'has-error' : '' }}">
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        value="{{ $value }}"
        class="form-check-input {{ $inputClass }} {{ $error ? 'is-invalid' : '' }} {{ $class }}"
        @if($isChecked) checked @endif
        @if($disabled) disabled @endif
        @if($required) required aria-required="true" @endif
        @if($ariaDescribedbyValue) aria-describedby="{{ $ariaDescribedbyValue }}" @endif
        @if($error) aria-invalid="true" @endif
        {{ $attributes }}
    />

    <label
        for="{{ $inputId }}"
        class="form-check-label {{ $labelClass }}"
    >
        {{ $label }}
        @if($required)
            <span class="sr-only">(required)</span>
            <span aria-hidden="true" class="required-indicator">*</span>
        @endif
    </label>

    @if($helpText)
        <small id="{{ $helpId }}" class="form-text text-muted d-block">
            {{ $helpText }}
        </small>
    @endif

    @error($name)
        <span id="{{ $errorId }}" class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    @if($error && !$errors->has($name))
        <span id="{{ $errorId }}" class="invalid-feedback d-block" role="alert">
            <strong>{{ $error }}</strong>
        </span>
    @endif
</div>