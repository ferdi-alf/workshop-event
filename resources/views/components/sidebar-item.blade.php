@props([
    'href' => '#',
    'active' => false,
    'icon' => null,
    'label' => '',
])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            'flex flex-col sm:flex-row items-center px-2 sm:px-4 py-1 sm:py-2 rounded-lg text-xs sm:text-sm ' .
            ($active
                ? 'text-transparent bg-clip-text bg-gradient-to-br from-blue-400 via-teal-500 to-teal-700 sm:text-white sm:font-medium sm:shadow-md sm:backdrop-blur-2xl'
                : 'text-white hover:shadow-sm hover:backdrop-blur-2xl'),
    ]) }}>
    @if ($icon)
        <i class="fa-solid fa-{{ $icon }} mr-0 sm:mr-2.5 mb-1 sm:mb-0 text-sm sm:text-base"></i>
    @endif
    <span>{{ $label }}</span>
</a>
