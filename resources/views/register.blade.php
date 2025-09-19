@extends('layouts.welcome-layout')

@section('title', ($workshop->title ?? 'Workshop') . ' - Registration')

@section('content')
    <div class="min-h-screen bg-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="inline-block gradient-bg text-white px-4 py-2 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Workshop Registration
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Daftar Workshop
                </h1>
                <h2 class="text-xl md:text-2xl text-gray-700 mb-6">
                    {{ $workshop->title ?? 'Workshop Registration' }}
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
                                <h3 class="font-semibold text-gray-900 text-sm mb-1">Tanggal & Waktu</h3>
                                <p class="text-gray-600 text-sm">
                                    {{ date('d F Y', strtotime($workshop->date)) }}<br>
                                    {{ date('H:i', strtotime($workshop->time_start)) }} -
                                    {{ date('H:i', strtotime($workshop->time_end)) }} WIB
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
                                <i class="fas fa-users text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm mb-1">Kuota Peserta</h3>
                                <p class="text-gray-600 text-sm">
                                    {{ $participantCount ?? 0 }}/{{ $workshop->quota }} peserta terdaftar
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="gradient-icon p-2 rounded-lg">
                                <i class="fas fa-trophy text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm mb-1">Benefit</h3>
                                <p class="text-gray-600 text-sm">{{ $workshop->benefit }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                <div class="flex items-center mb-6">
                    <div class="gradient-icon p-3 rounded-lg mr-4">
                        <i class="fas fa-user-plus text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Form Pendaftaran</h3>
                        <p class="text-gray-600 text-sm">Lengkapi data diri Anda untuk mendaftar workshop</p>
                    </div>
                </div>

                <form action="{{ route('workshop.register.store', \Illuminate\Support\Str::slug($workshop->title ?? '')) }}"
                    method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="workshop_id" value="{{ $workshop->id ?? '' }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
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

                        <div>
                            <x-fragments.text-field label="Asal Kampus/Instansi" name="campus" type="text"
                                placeholder="Nama kampus atau instansi" required="true" />
                        </div>

                        <div>
                            <x-fragments.text-field label="Jurusan/Bidang" name="major" type="text"
                                placeholder="Jurusan atau bidang kerja" required="true" />
                        </div>
                    </div>



                    <div class="flex flex-col-reverse sm:flex-row gap-4 pt-6">
                        <a href="{{ route('welcome') }}"
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>

                        <button type="submit"
                            class="flex-1 bg-gradient-to-br from-blue-500 via-teal-300 to-teal-500 gradient-button text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>

            @if ($workshop && $workshop->description)
                <div class="mt-8 bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="gradient-icon p-2 rounded-lg mr-3">
                            <i class="fas fa-info-circle text-white text-sm"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Tentang Workshop</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed">{{ $workshop->description }}</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        console.log('Workshop data:', @json($workshop ?? null));

        document.getElementById('whatsapp').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = '62' + value.substring(1);
            }
            if (!value.startsWith('62')) {
                value = '62' + value;
            }
            e.target.value = value;
        });
    </script>
@endsection
