@props(['icon', 'title', 'description'])

<div
    {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-center group hover:transform hover:scale-105']) }}>
    <div class="mb-4">
        <i
            class="{{ $icon }} text-4xl gradient-icon group-hover:scale-110 transition-transform duration-300"></i>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $title }}</h3>
    <p class="text-gray-600 leading-relaxed">{{ $description }}</p>
</div>
