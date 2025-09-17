@props([
    'href' => '#',
    'size' => 'normal',
    'type' => 'button',
])

@if ($type === 'link')
    <a href="{{ $href }}"
        {{ $attributes->merge([
            'class' =>
                $size === 'large'
                    ? 'inline-block px-8 py-4 text-lg font-semibold text-white gradient-bg rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-300'
                    : 'inline-block px-6 py-2 text-sm font-medium text-white gradient-bg rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-300',
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button
        {{ $attributes->merge([
            'class' =>
                $size === 'large'
                    ? 'px-8 py-4 text-lg font-semibold text-white gradient-bg rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-300'
                    : 'px-6 py-2 text-sm font-medium text-white gradient-bg rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-300',
        ]) }}>
        {{ $slot }}
    </button>
@endif
