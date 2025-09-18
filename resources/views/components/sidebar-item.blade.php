@props([
    'href' => '#',
    'active' => false,
    'icon' => null,
    'label' => '',
])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            'flex items-center px-4 py-2 rounded-lg ' .
            ($active
                ? 'shadow-md backdrop-blur-2xl text-white font-medium '
                : 'text-white hover:shadow-sm hover:backdrop-blur-2xl'),
    ]) }}>
    @if ($icon)
        <i class="fa-solid fa-{{ $icon }} mr-2.5"></i>
    @endif
    <span>{{ $label }}</span>
</a>
