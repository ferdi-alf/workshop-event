@extends('layouts.welcome-layout')

@section('title', 'Workshop Flutter UI – Roadshow Syneps | Master Flutter UI Development')

@section('content')
    <!-- Hero Section with Flowbite Slideshow -->
    <section class="relative">
        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <div class="relative h-96 md:h-[500px] lg:h-[600px] overflow-hidden">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-teal-500 flex items-start justify-center">
                        <div class="text-center text-white px-4 max-w-4xl mx-auto">
                            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                                Workshop Flutter UI
                            </h1>
                            <p class="text-lg md:text-xl mb-8 text-blue-100">
                                Roadshow Syneps – Master the art of beautiful Flutter interfaces
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <div
                        class="absolute inset-0 bg-gradient-to-l from-teal-500 to-blue-600 flex items-center justify-center">
                        <div class="text-center text-white px-4 max-w-4xl mx-auto">
                            <h2 class="text-3xl md:text-5xl font-bold mb-6">
                                Join Our Intensive Workshop
                            </h2>
                            <p class="text-lg md:text-xl mb-8 text-teal-100">
                                Master UI/UX with Flutter and create stunning mobile applications
                            </p>

                        </div>
                    </div>
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500 via-teal-400 to-teal-600 flex items-center justify-center">
                        <div class="text-center text-white px-4 max-w-4xl mx-auto">
                            <h2 class="text-3xl md:text-5xl font-bold mb-6">
                                Expert Instructors
                            </h2>
                            <p class="text-lg md:text-xl mb-8 text-blue-100">
                                Learn from industry professionals with years of Flutter development experience
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                <button type="button"
                    class="w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all"
                    aria-current="true" data-carousel-slide-to="0"></button>
                <button type="button"
                    class="w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all"
                    data-carousel-slide-to="1"></button>
                <button type="button"
                    class="w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all"
                    data-carousel-slide-to="2"></button>
            </div>
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
    <section id="details" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Detail Workshop
                </h2>
                <div class="w-24 h-1 gradient-bg mx-auto mb-8"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Segala yang perlu Anda ketahui tentang Workshop Flutter UI kami yang komprehensif.
                </p>
            </div>

            <div class="grid grid-cols- md:grid-cols-2 gap-8">
                <x-detail-card icon="fas fa-palette" title="Workshop Theme"
                    description="Master Flutter UI/UX Design - From basic widgets to advanced animations and custom components. Learn Material Design principles and create stunning mobile interfaces." />

                <x-detail-card icon="fas fa-clock" title="Schedule & Duration"
                    description="Full-day intensive workshop from 09:00 to 17:00 WIB on November 25, 2024. Includes breaks, networking lunch, and hands-on coding sessions." />

                <x-detail-card icon="fas fa-map-marker-alt" title="Location & Venue"
                    description="Jakarta Convention Center, Hall A - Premium workshop venue with modern facilities, high-speed internet, and comfortable learning environment."
                    highlight="true" />

                <x-detail-card icon="fas fa-trophy" title="Main Benefits"
                    description="Gain practical Flutter UI skills, receive official certificate, access to exclusive resources, lifetime community access, and networking with fellow developers."
                    highlight="true" />
            </div>

            <!-- Registration CTA -->
            <div class="text-center mt-12">
                <div class="bg-white rounded-2xl shadow-lg p-8 inline-block">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Ready to Join?</h3>
                    <p class="text-gray-600 mb-6">Don't miss this opportunity to advance your Flutter development skills!
                    </p>
                    <x-gradient-button href="#register" size="large" type="link" id="register">
                        <i class="fas fa-user-plus mr-2"></i>
                        Register Now
                    </x-gradient-button>
                    <p class="text-sm text-gray-500 mt-4">Limited seats available • Early bird pricing until November 15
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
