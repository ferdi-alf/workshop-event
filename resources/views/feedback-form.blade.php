@extends('layouts.welcome-layout')

@section('title', 'Feedback - ' . ($workshop->title ?? 'Workshop'))

@section('content')
    <div class="min-h-screen bg-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="inline-block gradient-bg text-white px-4 py-2 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-comment-alt mr-2"></i>
                    Workshop Feedback
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Berikan Feedback Anda
                </h1>
                <h2 class="text-xl md:text-2xl text-gray-700 mb-6">
                    {{ $workshop->title ?? 'Workshop Feedback' }}
                </h2>
                <div class="w-24 h-1 gradient-bg mx-auto mb-8"></div>
            </div>

            @if ($workshop)
                <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-3">
                            <div class="gradient-icon p-2 rounded-lg">
                                <i class="fas fa-calendar text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm mb-1">Tanggal Workshop</h3>
                                <p class="text-gray-600 text-sm">
                                    {{ date('d F Y', strtotime($workshop->date)) }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="gradient-icon p-2 rounded-lg">
                                <i class="fas fa-map-marker-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm mb-1">Lokasi</h3>
                                <p class="text-gray-600 text-sm">{{ $workshop->location }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="gradient-icon p-2 rounded-lg">
                                <i class="fas fa-check-circle text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm mb-1">Status</h3>
                                <p class="text-green-600 text-sm font-semibold">
                                    <i class="fas fa-check mr-1"></i>
                                    Workshop Selesai
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="gradient-icon p-2 rounded-lg">
                                <i class="fas fa-star text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm mb-1">Feedback</h3>
                                <p class="text-gray-600 text-sm">Bantuan Anda sangat berharga</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                <div class="flex items-center mb-6">
                    <div class="gradient-icon p-3 rounded-lg mr-4">
                        <i class="fas fa-clipboard-list text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Form Feedback</h3>
                        <p class="text-gray-600 text-sm">Bantuan Anda sangat berarti untuk meningkatkan kualitas workshop
                            selanjutnya</p>
                    </div>
                </div>

                <form action="{{ route('feedback.storeByUser', \Illuminate\Support\Str::slug($workshop->title ?? '')) }}"
                    method="POST" class="space-y-8">
                    @csrf

                    <!-- Data Peserta -->
                    <div class="border-b border-gray-200 pb-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Data Peserta</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-fragments.text-field label="Nama Lengkap" name="name" type="text"
                                    placeholder="Masukkan nama lengkap Anda" required="true" />
                            </div>
                            <div>
                                <x-fragments.text-field label="Email" name="email" type="email"
                                    placeholder="contoh@email.com" required="true" />
                            </div>
                            <div>
                                <x-fragments.text-field label="Nomor WhatsApp" name="whatsapp" type="tel"
                                    placeholder="08xxxxxxxxxx" required="true" />
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-question-circle gradient-text mr-2"></i>
                            Pertanyaan Feedback
                        </h4>

                        @foreach ($feedbackQuestions as $index => $question)
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <label class="block text-sm font-semibold text-gray-900 mb-3">
                                    <span
                                        class="inline-flex items-center justify-center w-6 h-6 bg-gradient-to-br from-blue-500 via-teal-300 to-teal-500 text-white text-xs font-bold rounded-full mr-2">{{ $index + 1 }}</span>
                                    {{ $question->question }}
                                    <span class="text-red-500">*</span>
                                </label>

                                @if ($question->type === 'free_text')
                                    <textarea name="answers[{{ $question->id }}]"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                                        rows="4" placeholder="Tuliskan jawaban Anda di sini..." required>{{ old('answers.' . $question->id) }}</textarea>
                                @elseif ($question->type === 'multiple_choice')
                                    <div class="space-y-2">
                                        @foreach ($question->options as $option)
                                            <label
                                                class="flex items-center p-3 rounded-md border border-gray-200 hover:bg-white transition-colors cursor-pointer">
                                                <input type="radio" name="answers[{{ $question->id }}]"
                                                    value="{{ $option->id }}"
                                                    class="mr-3 h-4 w-4 text-blue-500 focus:ring-blue-500 border-gray-300"
                                                    {{ old('answers.' . $question->id) == $option->id ? 'checked' : '' }}
                                                    required>
                                                <span class="text-gray-700">{{ $option->option_text }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif ($question->type === 'rating')
                                    <div class="rating-container" data-question="{{ $question->id }}">
                                        <div class="flex items-center space-x-1 mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <input type="radio" name="answers[{{ $question->id }}]"
                                                    value="{{ $i }}"
                                                    id="star_{{ $question->id }}_{{ $i }}"
                                                    class="sr-only star-input" data-value="{{ $i }}"
                                                    {{ old('answers.' . $question->id) == $i ? 'checked' : '' }} required>
                                                <label for="star_{{ $question->id }}_{{ $i }}"
                                                    class="star-label cursor-pointer text-2xl text-gray-300 hover:text-yellow-400 transition-colors duration-200"
                                                    data-rating="{{ $i }}">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            @endfor
                                        </div>
                                        <div class="text-sm text-gray-600 rating-text"
                                            id="rating_text_{{ $question->id }}">
                                            Klik bintang untuk memberikan rating
                                        </div>
                                    </div>
                                @endif

                                @error('answers.' . $question->id)
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('welcome') }}"
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Beranda
                        </a>

                        <button type="submit"
                            class="flex-1 bg-gradient-to-br from-blue-500 via-teal-300 to-teal-500 gradient-button text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-200">
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-500 p-2 rounded-lg">
                        <i class="fas fa-info-circle text-white text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-blue-900 mb-2">Terima kasih atas partisipasi Anda!</h3>
                        <p class="text-blue-800 text-sm leading-relaxed">
                            Feedback yang Anda berikan sangat berharga untuk membantu kami meningkatkan kualitas workshop
                            dan memberikan pengalaman terbaik untuk peserta di masa mendatang. Semua feedback akan
                            dianalisis secara saksama untuk perbaikan berkelanjutan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Format nomor WhatsApp
        document.querySelector('input[name="whatsapp"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = '62' + value.substring(1);
            }
            if (!value.startsWith('62')) {
                value = '62' + value;
            }
            e.target.value = value;
        });

        // Rating option styling
        document.addEventListener('DOMContentLoaded', function() {
            // Handle star ratings
            const ratingContainers = document.querySelectorAll('.rating-container');

            ratingContainers.forEach(container => {
                const questionId = container.dataset.question;
                const stars = container.querySelectorAll('.star-label');
                const ratingText = container.querySelector('.rating-text');
                const inputs = container.querySelectorAll('.star-input');

                // Check if there's a pre-selected rating
                const selectedInput = container.querySelector('.star-input:checked');
                if (selectedInput) {
                    const selectedValue = parseInt(selectedInput.dataset.value);
                    updateStars(stars, selectedValue, ratingText);
                }

                stars.forEach((star, index) => {
                    const rating = parseInt(star.dataset.rating);

                    // Hover effect
                    star.addEventListener('mouseenter', function() {
                        updateStars(stars, rating, ratingText, true);
                    });

                    // Click effect
                    star.addEventListener('click', function() {
                        const input = container.querySelector(
                            `#star_${questionId}_${rating}`);
                        input.checked = true;
                        updateStars(stars, rating, ratingText);
                    });
                });

                container.addEventListener('mouseleave', function() {
                    const checkedInput = container.querySelector('.star-input:checked');
                    if (checkedInput) {
                        const checkedRating = parseInt(checkedInput.dataset.value);
                        updateStars(stars, checkedRating, ratingText);
                    } else {
                        resetStars(stars, ratingText);
                    }
                });
            });

            function updateStars(stars, rating, textElement, isHover = false) {
                stars.forEach((star, index) => {
                    const starRating = parseInt(star.dataset.rating);
                    if (starRating <= rating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400');
                        if (!isHover) {
                            star.classList.add('text-yellow-500');
                        }
                    } else {
                        star.classList.remove('text-yellow-400', 'text-yellow-500');
                        star.classList.add('text-gray-300');
                    }
                });

                // Update text description
                const ratingDescriptions = {
                    1: '⭐ Sangat Tidak Puas',
                    2: '⭐⭐ Tidak Puas',
                    3: '⭐⭐⭐ Cukup Puas',
                    4: '⭐⭐⭐⭐ Puas',
                    5: '⭐⭐⭐⭐⭐ Sangat Puas'
                };

                textElement.textContent = ratingDescriptions[rating] || 'Klik bintang untuk memberikan rating';
                if (!isHover && rating) {
                    textElement.classList.remove('text-gray-600');
                    textElement.classList.add('text-yellow-600', 'font-medium');
                }
            }

            function resetStars(stars, textElement) {
                stars.forEach(star => {
                    star.classList.remove('text-yellow-400', 'text-yellow-500');
                    star.classList.add('text-gray-300');
                });
                textElement.textContent = 'Klik bintang untuk memberikan rating';
                textElement.classList.remove('text-yellow-600', 'font-medium');
                textElement.classList.add('text-gray-600');
            }

            const ratingOptions = document.querySelectorAll('.rating-option');

            ratingOptions.forEach(option => {
                const input = option.querySelector('input[type="radio"]');

                if (input && input.checked) {
                    option.classList.add('border-blue-500', 'bg-blue-50');
                }

                option.addEventListener('click', function() {
                    const name = input.name;
                    document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
                        const parentOption = radio.closest('.rating-option');
                        if (parentOption) {
                            parentOption.classList.remove('border-blue-500', 'bg-blue-50');
                        }
                    });

                    this.classList.add('border-blue-500', 'bg-blue-50');
                });
            });
        });

        console.log('Feedback form for workshop:', @json($workshop->title ?? 'Unknown'));
    </script>
@endsection
