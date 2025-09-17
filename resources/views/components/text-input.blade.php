@props(['disabled' => false, 'type' => 'text'])

<div class="relative">
    <input type="{{ $type }}" @disabled($disabled)
        {{ $attributes->merge([
            'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full pr-10 pl-10',
        ]) }}>

    @if ($type === 'password')
        <button type="button" onclick="togglePassword(this)"
            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
            <i class="fas fa-eye"></i>
        </button>
    @endif

    {{-- Icon lock di kiri input --}}
    @if ($type === 'password')
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-lock text-gray-400"></i>
        </div>
    @endif
</div>


<script>
    function togglePassword(button) {
        const input = button.closest('div').querySelector('input');
        const icon = button.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
