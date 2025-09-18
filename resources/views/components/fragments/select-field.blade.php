@props([
    'label' => '',
    'name' => '',
    'placeholder' => 'Pilih option...',
    'options' => [],
    'value' => '',
    'required' => false,
    'isDisabled' => false,
    'color' => 'dark',
])


@php
    $hasError = $errors->has($name);
    $errorClass = $hasError
        ? 'border-red-500 focus:ring-red-500 focus:border-red-500'
        : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500';

    $isDisabled = isset($attributes['disabled']) ? 'opacity-50 cursor-not-allowed' : '';
@endphp

<div>
    @if ($label)
        <label for="{{ $name }}"
            class="block mb-2 text-sm font-medium {{ $color === 'dark' ? 'text-gray-900' : 'text-white' }}"">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select name="{{ $name }}" id="{{ $name }}"
        class="bg-white/20 backdrop-blur-xl border {{ $errorClass }} {{ $isDisabled }} {{ $color === 'dark' ? 'text-gray-900' : 'text-white' }} text-sm rounded-lg text-start block w-full py-2.5 pr-10 transition-colors duration-200"
        {{ $required ? 'required' : '' }} {{ $attributes }}>

        @if ($placeholder)
            <option class="text-black" value="">{{ $placeholder }}</option>
        @endif

        @if (is_array($options) || $options instanceof \Illuminate\Support\Collection)
            @foreach ($options as $key => $option)
                @if (is_array($option))
                    <option class="text-black" value="{{ $option['value'] }}"
                        {{ old($name, $value) == $option['value'] ? 'selected' : '' }}>
                        {{ $option['label'] }}
                    </option>
                @else
                    <option class="text-black" value="{{ $key }}"
                        {{ old($name, $value) == $key ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endif
            @endforeach
        @endif

        {{ $slot }}
    </select>

    @error($name)
        <p class="mt-1 text-sm text-red-600 flex items-center">
            <i class="fa-solid fa-circle-exclamation mr-1"></i>
            {{ $message }}
        </p>
    @enderror
</div>
