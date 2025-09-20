@extends('layouts.welcome-layout')

@section('title', 'Workshop Flutter UI – Roadshow Syneps | Master Flutter UI Development')

@section('content')

    <section class="relative">
        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <div class="relative h-96 md:h-[500px] lg:h-[600px] overflow-hidden">
                @forelse ($banners as $index => $banner)
                    <!-- Carousel Item -->
                    <div class="{{ $index === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                        <div class="absolute inset-0 flex items-start justify-center">
                            <img src="/img/banners/{{ $banner->image_url }}" alt="{{ $banner->caption }}"
                                class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-40"></div> <!-- Overlay for text contrast -->
                            <div class="relative text-center text-white px-4 max-w-4xl mt-32 z-10">
                                <h1
                                    class="text-3xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight text-white drop-shadow-md">
                                    {{ $banner->caption ?? 'Workshop Flutter UI' }}
                                </h1>
                                <p class="text-lg md:text-xl mb-8 text-gray-100 drop-shadow-md">
                                    {{ $banner->caption ? 'Roadshow Syneps – ' . $banner->caption : 'Roadshow Syneps – Master the art of beautiful Flutter interfaces' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Fallback Item -->
                    <div class="duration-700 ease-in-out" data-carousel-item>
                        <div class="absolute inset-0 flex items-start justify-center">
                            <div class="relative text-center text-white px-4 max-w-4xl mt-32 z-10">
                                <h1
                                    class="text-3xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight text-white drop-shadow-md">
                                    Workshop Flutter UI
                                </h1>
                                <p class="text-lg md:text-xl mb-8 text-gray-100 drop-shadow-md">
                                    Roadshow Syneps – Master the art of beautiful Flutter interfaces
                                </p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Carousel Dots -->
            <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                @forelse ($banners as $index => $banner)
                    <button type="button" class="w-3 h-3 rounded-full bg-white  transition-all"
                        aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                        data-carousel-slide-to="{{ $index }}"></button>
                @empty
                    <button type="button" class="w-3 h-3 rounded-full bg-white 0 transition-all" aria-current="true"
                        data-carousel-slide-to="0"></button>
                @endforelse
            </div>

            <!-- Carousel Controls -->
            <button type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none transition-all">
                    <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none transition-all">
                    <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </span>
            </button>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    About Our Workshop
                </h2>
                <div class="w-24 h-1 gradient-bg mx-auto mb-8"></div>
            </div>
            <div class="bg-white rounded-2xl  shadow-lg p-8 md:p-12">
                <p class="sm:text-lg text-sm text-start text-gray-700 leading-relaxed mb-6">
                    Workshop ini aken membawa Anda dani dasar hingga mahir dalam membangun antarmuka pengguna yang indäh dan
                    interaktif menggunakan Flutter. Dengan materi yang komprehensif dan praktik langsung, Anda akan siap
                    menciptakan aplikasi yang responsif dan menarik. Kami akan membahas komponen inti Flutter, layouting,
                    navigasi, hingga tips dan trik untuk optimasi performa
                    UI.
                </p>
                <p class="text-gray-600 text-start text-xs sm:text-base leading-relaxed mb-8">
                    Baik Anda seorang pemula yang ingin memulai dengan Flutter atau pengembang berpengalaman yang ingin
                    mengasah keterampilan UI Anda, lokakarya ini menawarkan wawasan berharga, teknik praktis, dan peluang
                    jaringan
                    dengan sesama pengembang di ekosistem Flutter.
                </p>
                <div class="grid md:grid-cols-4 grid-cols-2 gap-4">
                    <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-xs sm:text-sm font-medium">Flutter
                        Framework</span>
                    <span
                        class="px-4 py-2 bg-teal-100 flex justify-center items-center text-teal-700 rounded-full text-xs sm:text-sm font-medium">UI/UX
                        Design</span>
                    <span class="px-4 py-2 bg-blue-100  text-blue-700 rounded-full text-xs sm:text-sm font-medium">Material
                        Design</span>
                    <span class="px-4 py-2 bg-teal-100 text-teal-700 rounded-full text-xs sm:text-sm font-medium">Responsive
                        Design</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Mengapa Harus Bergabung?
                </h2>
                <div class="w-24 h-1 gradient-bg mx-auto mb-8"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Temukan manfaat utama yang menjadikan workshop Flutter UI kami pilihan sempurna untuk perjalanan
                    pengembangan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <x-feature-card icon="fas fa-graduation-cap" title="Expert Learning"
                    description="Belajar dari para pakar industri dengan pengalaman pengembangan Flutter dan wawasan proyek dunia nyata." />

                <x-feature-card icon="fas fa-hands-helping" title="Hands-on Practice"
                    description="Dapatkan pengalaman praktis melalui sesi pengkodean interaktif dan bangun komponen UI Flutter yang sebenarnya selama lokakarya." />

                <x-feature-card icon="fas fa-certificate" title="Official Certificate"
                    description="Dapatkan sertifikat penyelesaian yang diakui untuk memamerkan keterampilan pengembangan Flutter UI yang baru Anda peroleh." />
            </div>
        </div>
    </section>

    <!-- Workshop Details Section -->
    @php use Illuminate\Support\Str; @endphp

    <section id="details" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Detail Workshop
                </h2>
                <div class="w-24 h-1 gradient-bg mx-auto mb-8"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Segala yang perlu Anda ketahui tentang {{ $workshop ? $workshop->title : 'Workshop' }} kami yang
                    komprehensif.
                </p>
            </div>

            @if ($workshop)
                <div class="text-center mb-8">
                    @if ($workshop->status === 'finished')
                        <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i>
                            Workshop Selesai
                        </span>
                    @elseif ($isQuotaFull ?? false)
                        <span class="inline-block bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-medium">
                            <i class="fas fa-users mr-1"></i>
                            Kuota Penuh
                        </span>
                    @else
                        <span class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                            <i class="fas fa-calendar-check mr-1"></i>
                            Pendaftaran Terbuka
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <x-detail-card icon="fas fa-palette" title="Workshop Theme"
                        description="{{ $workshop->title }} - {{ $workshop->description }}" />

                    <x-detail-card icon="fas fa-clock" title="Schedule & Duration"
                        description="Workshop pada {{ date('d F Y', strtotime($workshop->date)) }} dari {{ date('H:i', strtotime($workshop->time_start)) }} sampai {{ date('H:i', strtotime($workshop->time_end)) }} WIB." />

                    <x-detail-card icon="fas fa-map-marker-alt" title="Location & Venue"
                        description="{{ $workshop->location }}" highlight="true" />

                    <x-detail-card icon="fas fa-trophy" title="Main Benefits"
                        description="{{ $workshop->benefit }} | Peserta terdaftar: {{ $participantCount ?? 0 }}/{{ $workshop->quota }}"
                        highlight="true" />
                </div>

                <div class="text-center mt-12">
                    <div class="bg-white rounded-2xl shadow-lg p-8 inline-block">
                        @if ($workshop->status === 'finished')
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Workshop Telah Selesai</h3>
                            <p class="text-gray-600 mb-6">
                                Workshop {{ $workshop->title }} telah selesai dilaksanakan. Berikan feedback Anda untuk
                                membantu kami meningkatkan kualitas workshop selanjutnya.
                            </p>
                            <x-gradient-button href="{{ route('feedback.create', Str::slug($workshop->title)) }}"
                                size="large" type="link" id="feedback">
                                <i class="fas fa-comment-alt mr-2"></i>
                                Berikan Feedback
                            </x-gradient-button>
                            <p class="text-sm text-gray-500 mt-4">
                                Workshop selesai pada {{ date('d F Y', strtotime($workshop->date)) }}
                            </p>
                        @elseif ($isQuotaFull ?? false)
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Kuota Sudah Penuh</h3>
                            <p class="text-gray-600 mb-6">
                                Maaf, kuota untuk {{ $workshop->title }} sudah penuh. Nantikan workshop berikutnya!
                            </p>
                            <button disabled
                                class="bg-gray-400 text-white px-8 py-3 rounded-lg font-semibold text-lg cursor-not-allowed opacity-60">
                                <i class="fas fa-user-times mr-2"></i>
                                Kuota Penuh
                            </button>
                            <p class="text-sm text-gray-500 mt-4">
                                Kuota penuh ({{ $participantCount ?? 0 }}/{{ $workshop->quota }} peserta)
                            </p>
                        @else
                            <h3 class="text-2xl font-bold gradient-text mb-4">{{ $workshop->title }}</h3>
                            <div class="w-24 h-1 gradient-bg mx-auto mb-3"></div>

                            <p class="text-gray-600 mb-6">
                                Jangan lewatkan kesempatan ini untuk meningkatkan keterampilan pengembangan Anda dengan
                                {{ $workshop->title }}!
                            </p>
                            <x-gradient-button href="{{ route('workshop.register', Str::slug($workshop->title)) }}"
                                size="large" type="link" id="register">
                                <i class="fas fa-user-plus mr-2"></i>
                                Register Now
                            </x-gradient-button>
                            <p class="text-sm text-gray-500 mt-4">
                                Sisa kuota: {{ $workshop->quota - ($participantCount ?? 0) }} dari {{ $workshop->quota }}
                                peserta • Ayo Daftar Sekarang!
                            </p>
                        @endif
                    </div>
                </div>
            @else
                <div class="text-center">
                    <div class="bg-white rounded-2xl shadow-lg p-8 inline-block">
                        <i class="fas fa-calendar-times text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Tidak Ada Workshop</h3>
                        <p class="text-gray-600">Belum ada workshop yang tersedia saat ini. Nantikan workshop menarik dari
                            kami!</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
