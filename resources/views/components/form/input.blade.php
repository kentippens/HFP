@props([
    'type' => 'text',
    'name',
    'id' => null,
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autocomplete' => null,
    'ariaLabel' => null,
    'ariaDescribedby' => null,
    'ariaInvalid' => false,
    'helpText' => null,
    'error' => null,
    'class' => '',
    'inputClass' => '',
    'labelClass' => '',
    'wrapperClass' => ''
])

@php
    $inputId = $id ?? 'input-' . $name . '-' . uniqid();
    $errorId = $error ? $inputId . '-error' : null;
    $helpId = $helpText ? $inputId . '-help' : null;
    $ariaDescribedbyValue = collect([$ariaDescribedby, $errorId, $helpId])->filter()->implode(' ');
@endphp

<div class="form-group {{ $wrapperClass }} {{ $error ? 'has-error' : '' }}">
    @if($label)
        <label
            for="{{ $inputId }}"
            class="form-label {{ $labelClass }} {{ $required ? 'required' : '' }}"
        >
            {{ $label }}
            @if($required)
                <span class="sr-only">(required)</span>
                <span aria-hidden="true" class="required-indicator">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        value="{{ old($name, $value) }}"
        class="form-control {{ $inputClass }} {{ $error ? 'is-invalid' : '' }} {{ $class }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required aria-required="true" @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($ariaLabel || !$label) aria-label="{{ $ariaLabel ?: $label ?: $placeholder }}" @endif
        @if($ariaDescribedbyValue) aria-describedby="{{ $ariaDescribedbyValue }}" @endif
        @if($error) aria-invalid="true" @endif
        {{ $attributes }}
    />

    @if($helpText)
        <small id="{{ $helpId }}" class="form-text text-muted">
            {{ $helpText }}
        </small>
    @endif

    @error($name)
        <span id="{{ $errorId }}" class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    @if($error && !$errors->has($name))
        <span id="{{ $errorId }}" class="invalid-feedback" role="alert">
            <strong>{{ $error }}</strong>
        </span>
    @endif
</div>