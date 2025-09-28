@props([
    'name',
    'id' => null,
    'label' => null,
    'options' => [],
    'value' => '',
    'placeholder' => '-- Select an option --',
    'required' => false,
    'disabled' => false,
    'multiple' => false,
    'size' => null,
    'ariaLabel' => null,
    'ariaDescribedby' => null,
    'ariaInvalid' => false,
    'helpText' => null,
    'error' => null,
    'class' => '',
    'selectClass' => '',
    'labelClass' => '',
    'wrapperClass' => '',
    'optgroups' => false
])

@php
    $inputId = $id ?? 'select-' . $name . '-' . uniqid();
    $errorId = $error ? $inputId . '-error' : null;
    $helpId = $helpText ? $inputId . '-help' : null;
    $ariaDescribedbyValue = collect([$ariaDescribedby, $errorId, $helpId])->filter()->implode(' ');
    $selectedValue = old($name, $value);
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

    <select
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        id="{{ $inputId }}"
        class="form-control {{ $selectClass }} {{ $error ? 'is-invalid' : '' }} {{ $class }}"
        @if($required) required aria-required="true" @endif
        @if($disabled) disabled @endif
        @if($multiple) multiple @endif
        @if($size) size="{{ $size }}" @endif
        @if($ariaLabel || !$label) aria-label="{{ $ariaLabel ?: $label ?: 'Select option' }}" @endif
        @if($ariaDescribedbyValue) aria-describedby="{{ $ariaDescribedbyValue }}" @endif
        @if($error) aria-invalid="true" @endif
        {{ $attributes }}
    >
        @if($placeholder && !$multiple)
            <option value="" @if(empty($selectedValue)) selected @endif disabled>
                {{ $placeholder }}
            </option>
        @endif

        @if($optgroups)
            @foreach($options as $group => $groupOptions)
                <optgroup label="{{ $group }}">
                    @foreach($groupOptions as $optionValue => $optionLabel)
                        <option
                            value="{{ $optionValue }}"
                            @if($multiple && is_array($selectedValue) && in_array($optionValue, $selectedValue)) selected
                            @elseif(!$multiple && $selectedValue == $optionValue) selected
                            @endif
                        >
                            {{ $optionLabel }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        @else
            @foreach($options as $optionValue => $optionLabel)
                <option
                    value="{{ $optionValue }}"
                    @if($multiple && is_array($selectedValue) && in_array($optionValue, $selectedValue)) selected
                    @elseif(!$multiple && $selectedValue == $optionValue) selected
                    @endif
                >
                    {{ $optionLabel }}
                </option>
            @endforeach
        @endif
    </select>

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