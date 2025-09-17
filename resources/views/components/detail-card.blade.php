@props(['icon', 'title', 'description', 'highlight' => false])

<div
    {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 group hover:transform hover:scale-105 ' . ($highlight ? 'ring-2 ring-blue-200' : '')]) }}>
    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            <div
                class="w-12 h-12 rounded-lg gradient-bg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="{{ $icon }} text-white text-xl"></i>
            </div>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
            <p class="text-gray-600 leading-relaxed">{{ $description }}</p>
        </div>
    </div>
</div>
