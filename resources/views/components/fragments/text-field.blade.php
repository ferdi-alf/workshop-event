@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'color' => 'dark',
    'fullwidth' => false,
])

@php
    $hasError = $errors->has($name);
    $errorClass = $hasError
        ? 'border-red-500 focus:ring-red-500 focus:border-red-500'
        : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500';
@endphp

<div class="{{ $fullwidth ? 'w-full' : '' }} ">
    @if ($label)
        <label for="{{ $name }}"
            class="block mb-2 text-sm font-medium {{ $color === 'dark' ? 'text-gray-900' : 'text-white' }}">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
            value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}"
            class="bg-transparent backdrop-blur-xl border {{ $errorClass }} {{ $color === 'dark' ? 'text-gray-900' : 'text-white' }} text-sm rounded-lg block w-full p-2.5 pr-10 transition-colors duration-200"
            {{ $required ? 'required' : '' }} {{ $attributes }} />

        @if ($type === 'password')
            <button type="button" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500"
                onclick="togglePassword('{{ $name }}', this)">
                <i class="fa-solid fa-eye"></i>
            </button>
        @endif
    </div>

    @error($name)
        <p class="mt-1 text-sm text-red-600 flex items-center">
            <i class="fa-solid fa-circle-exclamation mr-1"></i>
            {{ $message }}
        </p>
    @enderror
</div>

<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
