@extends('layouts.app')

@section('content')
    <div class="">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="bg-white/20 backdrop-blur-2xl shadow-md rounded-xl p-3">
                <div class="flex gap-2 items-center">
                    <div class="rounded-full w-16 h-16 bg-white/70 flex justify-center items-center ">
                        <i class="fa-solid fa-calendar gradient-icon text-2xl"></i>
                    </div>
                    <div class="">
                        <h1 class="font-bold text-lg text-gray-800">Total workshops</h1>
                        <h2 class="gradient-text  font-extrabold text-3xl">{{ $totalWorkshops }}</h2>
                        <p class="text-gray-600 font-light text-sm">Menampilkan Total Data Workshops Event</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/20 backdrop-blur-2xl shadow-md rounded-xl p-3">
                <div class="flex gap-2 items-center">
                    <div class="rounded-full w-16 h-16 bg-white/70 flex justify-center items-center">
                        <i class="fa-solid fa-users gradient-icon text-2xl"></i>
                    </div>

                    <div>
                        <h1 class="font-bold text-lg text-gray-800">Total Participants</h1>

                        <div class="flex items-center justify-between gap-2">
                            <h2 class="gradient-text font-extrabold text-3xl">
                                {{ $totalParticipants['total'] }}
                            </h2>

                            @if ($totalParticipants['status'] === 'naik')
                                <span class="text-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M4 14l4-4 4 6 6-12" />
                                    </svg>
                                </span>
                            @elseif($totalParticipants['status'] === 'turun')
                                <span class="text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M20 10l-4 4-4-6-6 12" />
                                    </svg>
                                </span>
                            @else
                                <span class="text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M4 12h16" />
                                        <circle cx="12" cy="12" r="1" fill="currentColor" />
                                    </svg>
                                </span>
                            @endif
                        </div>

                        <p class="text-gray-600 font-light text-sm">Total semua participant dan status</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/20 backdrop-blur-2xl shadow-md rounded-xl p-3">
                <div class="flex gap-2 items-center">
                    <div class="rounded-full w-16 h-16 bg-white/70  flex justify-center items-center ">
                        <i class="fa-solid fa-user gradient-icon text-2xl"></i>
                    </div>
                    <div class="">
                        <h1 class="font-bold text-lg text-gray-800">Total Workshops</h1>
                        <h2 class="gradient-text  font-extrabold text-3xl">{{ $totalUsers }}</h2>
                        <p class="text-gray-600 font-light text-sm">Total data users</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 grid-cols-1 gap-4 mt-5">
            <div class="flex justify-center shadow-lg bg-white/20 backdrop-blur-xl rounded-xl">
                <canvas id="ratingChart" class="md:w-[70%] w-full h-72"></canvas>
            </div>

            <div class="flex justify-center shadow-lg backdrop-blur-xl bg-white/20 rounded-xl">
                <canvas id="workshopChart" class="w-full h-72"></canvas>
            </div>
        </div>
    </div>

    <div class="backdrop-blur-2xl mt-5 bg-white/15 rounded-xl   shadow-lg">
        <div class="bg-white/25 p-3">
            <h1 class="text-gray-800/80 font-semibold">Menamilkan Data Workshop dalam status register:
                {{ $workshop ? $workshop['title'] : '-' }}
            </h1>
        </div>

        <div class="h-80 overflow-auto">

            <div class="relative overflow-x-auto">
                @if ($workshop && $workshop->participants->count())
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium">Nama</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">Whatsapp</th>
                                <th scope="col" class="px-6 py-4">Kampus</th>
                                <th scope="col" class="px-6 py-4">Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workshop->participants as $row)
                                <tr class="bg-white/35 text-gray-800/65 border-b border-gray-200">
                                    <td class="px-6 py-4 font-medium">{{ $row->name }}</td>
                                    <td class="px-6 py-4">{{ $row->email }}</td>
                                    <td class="px-6 py-4">{{ $row->whatsapp }}</td>
                                    <td class="px-6 py-4">{{ $row->campus }}</td>
                                    <td class="px-6 py-4">{{ $row->major }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center text-gray-700 font-semibold">Belum Ada Data Participant</p>
                @endif

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const ratings = @json($ratingData['rating']);
            const rataRata = @json($ratingData['rataRata']);
            const ratingCounts = [1, 2, 3, 4, 5].map(val => ratings.filter(r => r == val).length);

            const ctxRating = document.getElementById('ratingChart').getContext('2d');
            new Chart(ctxRating, {
                type: 'bar',
                data: {
                    labels: ['1', '2', '3', '4', '5'],
                    datasets: [{
                        label: 'Total Responden',
                        data: ratingCounts,
                        backgroundColor: 'rgba(13, 148, 136, 0.7)',
                        borderColor: 'rgb(13, 148, 136)',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    indexAxis: 'y', // horizontal bar
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: `Distribusi Rating (Rata-rata: ${rataRata})`,
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });

            const workshops = @json($latestWorkshops);
            const labels = workshops.map(w => w.title);
            const participants = workshops.map(w => w.total_participant);

            const ctxWorkshop = document.getElementById('workshopChart').getContext('2d');
            new Chart(ctxWorkshop, {
                type: 'polarArea',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Participant',
                        data: participants,
                        backgroundColor: [
                            'rgba(13, 148, 136, 0.6)',
                            'rgba(59, 130, 246, 0.6)',
                            'rgba(244, 63, 94, 0.6)',
                            'rgba(234, 179, 8, 0.6)'
                        ],
                        borderColor: [
                            'rgb(13, 148, 136)',
                            'rgb(59, 130, 246)',
                            'rgb(244, 63, 94)',
                            'rgb(234, 179, 8)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: '4 Workshop Terbaru dan Jumlah Pendaftar',
                            font: {
                                color: '#374151',
                                size: 16
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    let total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    let val = ctx.raw;
                                    let percent = ((val / total) * 100).toFixed(1);
                                    return `${ctx.label}: ${val} peserta (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
