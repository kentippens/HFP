@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'rows' => 4,
    'cols' => null,
    'maxlength' => null,
    'ariaLabel' => null,
    'ariaDescribedby' => null,
    'ariaInvalid' => false,
    'helpText' => null,
    'error' => null,
    'class' => '',
    'textareaClass' => '',
    'labelClass' => '',
    'wrapperClass' => '',
    'showCharCount' => false
])

@php
    $inputId = $id ?? 'textarea-' . $name . '-' . uniqid();
    $errorId = $error ? $inputId . '-error' : null;
    $helpId = $helpText ? $inputId . '-help' : null;
    $counterId = $showCharCount ? $inputId . '-counter' : null;
    $ariaDescribedbyValue = collect([$ariaDescribedby, $errorId, $helpId, $counterId])->filter()->implode(' ');
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

    <textarea
        name="{{ $name }}"
        id="{{ $inputId }}"
        rows="{{ $rows }}"
        @if($cols) cols="{{ $cols }}" @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        class="form-control {{ $textareaClass }} {{ $error ? 'is-invalid' : '' }} {{ $class }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required aria-required="true" @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        @if($ariaLabel || !$label) aria-label="{{ $ariaLabel ?: $label ?: $placeholder }}" @endif
        @if($ariaDescribedbyValue) aria-describedby="{{ $ariaDescribedbyValue }}" @endif
        @if($error) aria-invalid="true" @endif
        @if($showCharCount && $maxlength) data-character-count data-max-length="{{ $maxlength }}" @endif
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>

    @if($showCharCount && $maxlength)
        <div id="{{ $counterId }}" class="character-counter" aria-live="polite" aria-atomic="true">
            <span class="current-count">0</span> / <span class="max-count">{{ $maxlength }}</span> characters
        </div>
    @endif

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