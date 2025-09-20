@extends('layouts.app')

@section('content')
    <style>
        .expand-icon {
            transition: transform 0.2s ease;
        }

        .expand-icon.rotated {
            transform: rotate(90deg);
        }

        .col-expand {
            width: 40px;
        }

        .col-title {
            width: 25%;
        }

        .col-status {
            width: 15%;
        }

        .col-date {
            width: 15%;
        }

        .col-time {
            width: 15%;
        }

        .col-quota {
            width: 10%;
        }

        .col-actions {
            width: 20%;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>

    <div class="flex justify-end">
        <x-fragments.modal-button label="Add Workshop" target="modal-control-workshop" variant="transparent" act="create">
            <i class="fa-solid fa-plus mr-2"></i>
            Tambah Workshop Event
        </x-fragments.modal-button>

        @push('modals')
            <x-fragments.form-modal id="modal-control-workshop" title="Tambah Workshop" createTitle="Tambah Workshop"
                editTitle="Edit Workshop" action="{{ route('workshop.store') }}"
                fetchEndpoint="{{ route('workshop.show', ':id') }}">
                <x-fragments.text-field color="light" label="Judul" name="title" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-fragments.text-field color="light" type="number" label="Quota" name="quota" required />
                    <x-fragments.select-field color="light" name="status" label="Status Workshop" :options="[
                        'inactive' => 'Inactive',
                        'registered' => 'Registered',
                        'finished' => 'Finished',
                    ]"
                        required />
                </div>
                <x-fragments.text-field color="light" type="date" label="Tanggal" name="date" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-fragments.text-field color="light" type="time" label="Jam Mulai" name="time_start" required />
                    <x-fragments.text-field color="light" type="time" label="Jam Selesai" name="time_end" required />
                </div>
                <x-fragments.text-field color="light" label="Lokasi" name="location" required />
                <div class="text-white">
                    <label for="description">Description <span class="text-red-500">*</span></label>
                    <textarea
                        class="border-gray-300 text-white bg-white/20 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        name="description" id="description" cols="30" rows="2" required></textarea>
                </div>
                <div class="text-white">
                    <label for="benefit">Benefit <span class="text-red-500">*</span></label>
                    <textarea
                        class="border-gray-300 text-white bg-white/20 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        name="benefit" id="benefit" cols="30" rows="2" required></textarea>
                </div>
            </x-fragments.form-modal>
        @endpush
    </div>

    @push('modals')
        <x-drawer-layout id="analytics-drawer" title="Workshop Analytics" description="Data analisis feedback workshop">
            <div id="analytics-content">
                <div class="flex justify-center items-center h-32">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <span class="ml-2">Loading analytics...</span>
                </div>
            </div>
        </x-drawer-layout>
    @endpush

    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-8">Manajemen Event Workshop</h1>

        <div class="backdrop-blur-2xl rounded-lg shadow-lg overflow-auto" x-data="tableData()">
            <table class="min-w-full table-fixed">
                <thead class="backdrop-blur-2xl shadow-md">
                    <tr>
                        <th class="col-expand px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        </th>
                        <th class="col-title px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Judul</th>
                        <th class="col-status px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Status</th>
                        <th class="col-date px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Tanggal</th>
                        <th class="col-time px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jam
                            mulai - selesai</th>
                        <th class="col-quota px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Quota</th>
                        <th class="col-actions px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="backdrop-blur-2xl shadow-sm">
                    <template x-for="(workshop, index) in paginatedWorkshops" :key="workshop.id">
                        <tr>
                            <td colspan="7" class="p-0">
                                <div class="border-b w-full border-gray-200">
                                    <div class="flex items-center w-full hover:bg-gray-50/10 hover:backdrop-blur-3xl cursor-pointer"
                                        @click="toggleRow(workshop.id)">
                                        <div class="col-expand px-6 py-4 flex justify-center">
                                            <svg class="w-4 h-4 text-white expand-icon"
                                                :class="{ 'rotated': isExpanded(workshop.id) }" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                        <div class="col-title px-6 py-4">
                                            <div class="text-sm font-medium text-white truncate" x-text="workshop.title"
                                                :title="workshop.title"></div>
                                        </div>
                                        <div class="col-status px-6 py-4">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                                :class="{
                                                    'bg-green-100 text-green-800': workshop.status === 'registered',
                                                    'bg-yellow-100 text-yellow-800': workshop.status === 'inactive',
                                                    'bg-blue-100 text-blue-800': workshop.status === 'finished'
                                                }"
                                                x-text="workshop.status"></span>
                                        </div>
                                        <div class="col-date px-6 py-4">
                                            <div class="text-sm text-white" x-text="workshop.formatted_date"></div>
                                        </div>
                                        <div class="col-time px-6 py-4">
                                            <div class="text-sm text-white" x-text="workshop.formatted_time"></div>
                                        </div>
                                        <div class="col-quota px-6 py-4">
                                            <div class="text-sm text-white">
                                                <span x-text="workshop.participant_count"></span> / <span
                                                    x-text="workshop.quota"></span>
                                            </div>
                                        </div>
                                        <div class="col-actions px-6 py-4" @click.stop>
                                            <div class="flex space-x-2">
                                                <button
                                                    :onclick="`window.handleModalAction('modal-control-workshop', 'update', {id: ${workshop.id}, fetchEndpoint: '/workshop/${workshop.id}', updateEndpoint: '/workshop/${workshop.id}'})`"
                                                    class="inline-flex items-center p-2 text-xs font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-colors duration-200"
                                                    title="Edit Workshop">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <button @click="deleteWorkshop(workshop.id)"
                                                    class="inline-flex items-center p-2 text-xs font-medium text-red-600 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition-colors duration-200"
                                                    title="Delete Workshop">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <button @click="openAnalytics(workshop.id)"
                                                    class="inline-flex items-center p-2 text-xs font-medium text-purple-600 bg-purple-100 rounded-md hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-1 transition-colors duration-200"
                                                    title="View Analytics">
                                                    <i class="fa-solid fa-chart-bar"></i>
                                                </button>
                                                <button @click="downloadPDF(workshop.id)"
                                                    class="inline-flex items-center p-2 text-xs font-medium text-green-600 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-colors duration-200"
                                                    title="Download PDF">
                                                    <i class="fa-solid fa-download"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div x-show="isExpanded(workshop.id)"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                                        x-transition:enter-end="opacity-100 transform translate-y-0"
                                        class="px-6 py-4 bg-white/15 overflow-auto scrollbar backdrop-blur-xl">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                            <div>
                                                <h3 class="text-lg font-semibold text-white mb-2">Detail Workshop Event
                                                </h3>
                                                <p class="text-md text-white"><strong>Judul:</strong> <span
                                                        x-text="workshop.title"></span></p>
                                                <p class="text-md text-white"><strong>Status:</strong> <span
                                                        x-text="workshop.status"></span></p>
                                                <p class="text-md text-white"><strong>Tanggal:</strong> <span
                                                        x-text="workshop.formatted_date"></span></p>
                                                <p class="text-md text-white"><strong>Jam Mulai - Selesai:</strong> <span
                                                        x-text="workshop.formatted_time"></span></p>
                                                <p class="text-md text-white"><strong>Quota:</strong> <span
                                                        x-text="workshop.participant_count + ' / ' + workshop.quota"></span>
                                                </p>
                                                <p class="text-md text-white"><strong>Sisa Quota:</strong> <span
                                                        x-text="workshop.remaining_quota"></span></p>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-white mb-2">Informasi Tambahan</h3>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="shadow-md bg-white/25 rounded-lg p-3 text-white">
                                                        <h1 class="text-xl font-bold"><i
                                                                class="fa-solid fa-location-dot gradient-icon"></i> Lokasi
                                                        </h1>
                                                        <p class="text-sm font-semibold" x-text="workshop.location"></p>
                                                    </div>
                                                    <div class="shadow-md bg-white/25 rounded-lg p-3 text-white">
                                                        <h1 class="text-xl font-bold"><i
                                                                class="fas fa-trophy gradient-icon"></i> Benefit</h1>
                                                        <p class="text-sm font-semibold" x-text="workshop.benefit"></p>
                                                    </div>
                                                </div>
                                                <div class="shadow-md mt-2 bg-white/25 rounded-lg p-3 text-white">
                                                    <h1 class="text-xl font-bold"><i
                                                            class="fas fa-palette gradient-icon"></i> Description</h1>
                                                    <p class="text-sm font-semibold" x-text="workshop.description"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dropdown (tab) tidak disentuh -->
                                        <div class="w-full mt-5 rounded-lg shadow-lg overflow-hidden"
                                            x-data="tabComponent(workshop.id)" x-init="init()">
                                            <div class="flex backdrop-blur-2xl border-b relative overflow-x-auto scrollbar-hide"
                                                x-ref="tabHeader">
                                                <div class="grid grid-cols-2 shadow-md backdrop-blur-2xl w-full">
                                                    <template x-for="(tab, tabIndex) in tabs" :key="tabIndex">
                                                        <button
                                                            class="flex-shrink-0 px-4 py-3 lg:px-6 lg:py-4 text-sm lg:text-base font-medium text-gray-800 hover:text-sky-400 hover:bg-blue-50/25 transition-all duration-300 whitespace-nowrap relative"
                                                            :class="{ ' bg-white/25 text-gray-800 ': activeTab === tabIndex }"
                                                            @click="switchTab(tabIndex)" x-text="tab.title">
                                                        </button>
                                                    </template>
                                                </div>
                                                <div class="absolute bottom-0 h-0.5 bg-blue-400 transition-all duration-300 ease-out rounded-full"
                                                    :style="`width: ${indicatorWidth}px; transform: translateX(${indicatorOffset}px); opacity: ${indicatorWidth > 0 ? 1 : 0}`">
                                                </div>
                                            </div>

                                            <div class="p-6 lg:p-8 bg-transparent min-h-[400px]">
                                                <div x-show="activeTab === 0" x-transition:enter="animate-fade-in"
                                                    class="space-y-6">
                                                    <div x-show="participants.length === 0" class="text-center py-8">
                                                        <p class="text-white/70">Belum ada participant yang terdaftar</p>
                                                    </div>
                                                    <div x-show="participants.length > 0"
                                                        class=" backdrop-blur-sm rounded-lg overflow-hidden">
                                                        <div class="overflow-x-auto">
                                                            <table class="min-w-full">
                                                                <thead class=" backdrop-blur-md">
                                                                    <tr>
                                                                        <th
                                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                                            No</th>
                                                                        <th
                                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                                            Nama</th>
                                                                        <th
                                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                                            Email</th>
                                                                        <th
                                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                                            WhatsApp</th>
                                                                        <th
                                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                                            Campus</th>
                                                                        <th
                                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                                                            Jurusan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody
                                                                    class="bg-white/10 backdrop-blur-sm divide-y divide-white/20">
                                                                    <template x-for="(participant, index) in participants"
                                                                        :key="participant.id">
                                                                        <tr
                                                                            class="hover:bg-white/20 transition-colors duration-200">
                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"
                                                                                x-text="index + 1"></td>
                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700"
                                                                                x-text="participant.name"></td>
                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700/80"
                                                                                x-text="participant.email"></td>
                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700/80"
                                                                                x-text="participant.whatsapp"></td>
                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700/80"
                                                                                x-text="participant.campus"></td>
                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700/60"
                                                                                x-text="participant.major"></td>
                                                                        </tr>
                                                                    </template>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div x-show="activeTab === 1" x-transition:enter="animate-fade-in"
                                                    class="space-y-6">
                                                    <div x-show="feedbackQuestions.length === 0" class="text-center py-8">
                                                        <p class="text-white/70">Belum ada feedback questions yang dibuat
                                                        </p>
                                                    </div>
                                                    <div x-show="feedbackQuestions.length > 0" class="space-y-4">
                                                        <template x-for="(question, qIndex) in feedbackQuestions"
                                                            :key="question.id">
                                                            <div class=" backdrop-blur-sm rounded-lg p-4">
                                                                <div class="flex items-start justify-between">
                                                                    <div class="flex-1">
                                                                        <h4 class="font-semibold text-gray-800 mb-2"
                                                                            x-text="`${qIndex + 1}. ${question.question}`">
                                                                        </h4>
                                                                    </div>
                                                                    <span
                                                                        class="inline-flex px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full"
                                                                        x-text="question.type"></span>
                                                                </div>
                                                                <div x-show="question.options && question.options.length > 0"
                                                                    class="mt-3">
                                                                    <p class="text-sm text-gray-700 mb-2">Pilihan:</p>
                                                                    <ul class="space-y-1">
                                                                        <template
                                                                            x-for="(option, optIndex) in question.options"
                                                                            :key="option.id">
                                                                            <li class="text-sm text-gray-600"
                                                                                x-text="`${optIndex + 1}. ${option.option_text}`">
                                                                            </li>
                                                                        </template>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <div x-show="workshops.length > 0"
                class="flex justify-between w-full items-center mt-4 px-6 py-3 bg-white/10 rounded-lg backdrop-blur-xl">
                <div class="text-sm text-white">
                    Menampilkan <span x-text="startItem"></span> - <span x-text="endItem"></span> dari <span
                        x-text="workshops.length"></span> data workshop
                </div>
                <div class="flex space-x-2">
                    <button @click="prevPage()" :disabled="currentPage === 1"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-md hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        :class="{ 'cursor-not-allowed': currentPage === 1 }">
                        Previous
                    </button>
                    <span class="text-sm text-white px-4 py-2">Halaman <span x-text="currentPage"></span> dari <span
                            x-text="totalPages"></span></span>
                    <button @click="nextPage()" :disabled="currentPage === totalPages"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-md hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        :class="{ 'cursor-not-allowed': currentPage === totalPages }">
                        Next
                    </button>
                </div>
            </div>

            <div class="p-4 bg-blue-50/20 backdrop-blur-2xl text-sm text-blue-600" x-show="workshops.length === 0">
                Tidak ada data workshop untuk ditampilkan
            </div>

        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const title = document.querySelector('input[name="title"]');
            const quota = document.querySelector('input[name="quota"]');
            const status = document.querySelector('select[name="status"]');
            const date = document.querySelector('input[name="date"]');
            const time_start = document.querySelector('input[name="time_start"]');
            const time_end = document.querySelector('input[name="time_end"]');
            const location = document.querySelector('input[name="location"]');
            const description = document.querySelector('textarea[name="description"]');
            const benefit = document.querySelector('textarea[name="benefit"]');

            document.addEventListener('modalCreate', function(e) {
                if (e.detail.modalId === 'modal-control-workshop') {
                    title.value = '';
                    quota.value = '';
                    status.value = '';
                    date.value = '';
                    time_start.value = '';
                    time_end.value = '';
                    location.value = '';
                    description.value = '';
                    benefit.value = '';
                }
            });

            document.addEventListener('modalUpdate', function(e) {
                if (e.detail.modalId === 'modal-control-workshop') {
                    const workshopData = e.detail.data;
                    console.log('Workshop Data:', workshopData);

                    title.value = workshopData.title || '';
                    quota.value = workshopData.quota || '';
                    status.value = workshopData.status || '';
                    date.value = workshopData.date || '';
                    time_start.value = workshopData.time_start || '';
                    time_end.value = workshopData.time_end || '';
                    location.value = workshopData.location || '';
                    description.value = workshopData.description || '';
                    benefit.value = workshopData.benefit || '';
                }
            });
        });

        function tableData() {
            return {
                expandedWorkshops: [],
                workshops: @json($workshops),
                currentPage: 1,
                itemsPerPage: 10,

                get paginatedWorkshops() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.workshops.slice(start, start + this.itemsPerPage);
                },

                get totalPages() {
                    return Math.ceil(this.workshops.length / this.itemsPerPage);
                },

                get startItem() {
                    return (this.currentPage - 1) * this.itemsPerPage + 1;
                },

                get endItem() {
                    const end = this.currentPage * this.itemsPerPage;
                    return Math.min(end, this.workshops.length);
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },

                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },

                toggleRow(workshopId) {
                    if (this.expandedWorkshops.includes(workshopId)) {
                        this.expandedWorkshops = this.expandedWorkshops.filter(id => id !== workshopId);
                    } else {
                        this.expandedWorkshops.push(workshopId);
                    }
                },

                isExpanded(workshopId) {
                    return this.expandedWorkshops.includes(workshopId);
                },

                openAnalytics(workshopId) {
                    fetch(`/workshop/${workshopId}/analytics`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.displayAnalytics(data.data);
                                openDrawer('analytics-drawer', {
                                    title: 'Workshop Analytics - ' + data.data.workshop.title,
                                    description: 'Data analisis feedback workshop'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal memuat data analytics',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat memuat analytics',
                                confirmButtonText: 'OK'
                            });
                        });
                },

                editWorkshop(workshop) {
                    window.handleModalAction('modal-control-workshop', 'update', {
                        id: workshop.id,
                        fetchEndpoint: `/workshop/${workshop.id}`,
                        updateEndpoint: `/workshop/${workshop.id}`
                    });
                },

                deleteWorkshop(workshopId) {
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Data workshop dan terkait akan dihapus permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/workshop/${workshopId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content'),
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        this.workshops = this.workshops.filter(w => w.id !== workshopId);
                                        this.expandedWorkshops = this.expandedWorkshops.filter(id => id !==
                                            workshopId);
                                        if (this.paginatedWorkshops.length === 0 && this.currentPage > this
                                            .totalPages) {
                                            this.currentPage = this.totalPages || 1;
                                        }
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: 'Workshop berhasil dihapus!',
                                            confirmButtonText: 'OK'
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: 'Gagal menghapus workshop: ' + data.message,
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Terjadi kesalahan saat menghapus workshop',
                                        confirmButtonText: 'OK'
                                    });
                                });
                        }
                    });
                },

                downloadPDF(workshopId) {
                    window.open(`/workshop/${workshopId}/download-pdf`, '_blank');
                },

                displayAnalytics(data) {
                    const content = document.getElementById('analytics-content');

                    if (data.analytics.length === 0) {
                        content.innerHTML = `
                            <div class="text-center py-8">
                                <p class="text-gray-600">Belum ada data feedback untuk dianalisis</p>
                            </div>
                        `;
                        return;
                    }

                    const pieCharts = data.analytics.filter(item => item.chart_type === 'pie');
                    const barCharts = data.analytics.filter(item => item.chart_type === 'horizontal_bar');

                    let html = '<div class="space-y-6">';

                    if (pieCharts.length === 1) {
                        html += `
                            <div class="bg-white/25 backdrop-blur-xl rounded-lg p-6 shadow-lg">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800">${pieCharts[0].question}</h3>
                                <div class="mb-2">
                                    <span class="text-sm text-gray-600">Total Responses: ${pieCharts[0].total_responses}</span>
                                </div>
                                <div class="h-64">
                                    <canvas id="pieChart_0"></canvas>
                                </div>
                            </div>
                        `;
                    } else if (pieCharts.length > 1) {
                        html += '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">';
                        pieCharts.forEach((item, index) => {
                            html += `
                                <div class="bg-white/25 backdrop-blur-xl rounded-lg p-6 shadow-lg">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">${item.question}</h3>
                                    <div class="mb-2">
                                        <span class="text-sm text-gray-600">Total Responses: ${item.total_responses}</span>
                                    </div>
                                    <div class="h-64">
                                        <canvas id="pieChart_${index}"></canvas>
                                    </div>
                                </div>
                            `;
                        });
                        html += '</div>';
                    }

                    barCharts.forEach((item, index) => {
                        html += `
                            <div class="bg-white/25 backdrop-blur-xl rounded-lg p-6 shadow-lg">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800">${item.question}</h3>
                                <div class="mb-2">
                                    <span class="text-sm text-gray-600">Total Responses: ${item.total_responses}</span>
                                    ${item.average_rating ? `<span class="ml-4 text-sm text-gray-600">Average: ${item.average_rating}/5</span>` : ''}
                                </div>
                                <div class="h-64">
                                    <canvas id="barChart_${index}"></canvas>
                                </div>
                            </div>
                        `;
                    });

                    html += '</div>';
                    content.innerHTML = html;

                    setTimeout(() => {
                        // Render pie charts first
                        pieCharts.forEach((item, index) => {
                            const ctx = document.getElementById(`pieChart_${index}`);
                            if (ctx) {
                                new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: item.data.map(d => d.label),
                                        datasets: [{
                                            data: item.data.map(d => d.value),
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.6)',
                                                'rgba(54, 162, 235, 0.6)',
                                                'rgba(255, 205, 86, 0.6)',
                                                'rgba(75, 192, 192, 0.6)',
                                                'rgba(153, 102, 255, 0.6)',
                                                'rgba(255, 159, 64, 0.6)',
                                                'rgba(199, 199, 199, 0.6)',
                                                'rgba(83, 102, 255, 0.6)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 0.8)',
                                                'rgba(54, 162, 235, 0.8)',
                                                'rgba(255, 205, 86, 0.8)',
                                                'rgba(75, 192, 192, 0.8)',
                                                'rgba(153, 102, 255, 0.8)',
                                                'rgba(255, 159, 64, 0.8)',
                                                'rgba(199, 199, 199, 0.8)',
                                                'rgba(83, 102, 255, 0.8)'
                                            ],
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                position: 'bottom',
                                                labels: {
                                                    color: 'rgba(0, 0, 0, 0.8)',
                                                    font: {
                                                        size: 12
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                                titleColor: 'rgba(0, 0, 0, 0.8)',
                                                bodyColor: 'rgba(0, 0, 0, 0.8)',
                                                borderColor: 'rgba(0, 0, 0, 0.1)',
                                                borderWidth: 1,
                                                callbacks: {
                                                    label: function(context) {
                                                        const percentage = item.data[context
                                                            .dataIndex].percentage;
                                                        return `${context.label}: ${context.parsed} (${percentage}%)`;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        });

                        // Render bar charts
                        barCharts.forEach((item, index) => {
                            const ctx = document.getElementById(`barChart_${index}`);
                            if (ctx) {
                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: item.data.map(d => d.label),
                                        datasets: [{
                                            label: 'Responses',
                                            data: item.data.map(d => d.value),
                                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                            borderColor: 'rgba(54, 162, 235, 0.8)',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        indexAxis: 'y',
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            tooltip: {
                                                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                                titleColor: 'rgba(0, 0, 0, 0.8)',
                                                bodyColor: 'rgba(0, 0, 0, 0.8)',
                                                borderColor: 'rgba(0, 0, 0, 0.1)',
                                                borderWidth: 1,
                                                callbacks: {
                                                    afterLabel: function(context) {
                                                        const percentage = item.data[context
                                                            .dataIndex].percentage;
                                                        return `(${percentage}%)`;
                                                    }
                                                }
                                            }
                                        },
                                        scales: {
                                            x: {
                                                beginAtZero: true,
                                                ticks: {
                                                    stepSize: 1,
                                                    color: 'rgba(0, 0, 0, 0.7)'
                                                },
                                                grid: {
                                                    color: 'rgba(0, 0, 0, 0.1)'
                                                }
                                            },
                                            y: {
                                                ticks: {
                                                    color: 'rgba(0, 0, 0, 0.7)'
                                                },
                                                grid: {
                                                    color: 'rgba(0, 0, 0, 0.1)'
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }, 100);
                }
            }

            function tabComponent(workshopId) {
                return {
                    activeTab: 0,
                    indicatorWidth: 0,
                    indicatorOffset: 0,
                    participants: [],
                    feedbackQuestions: [],
                    workshopId: workshopId,

                    tabs: [{
                            title: 'Participants'
                        },
                        {
                            title: 'Feedback Questions'
                        }
                    ],

                    init() {
                        this.loadParticipants();
                        this.loadFeedbackQuestions();

                        this.$nextTick(() => {
                            this.updateIndicator();
                        });

                        setTimeout(() => {
                            this.updateIndicator();
                        }, 50);

                        window.addEventListener('resize', () => {
                            this.updateIndicator();
                        });
                    },

                    async loadParticipants() {
                        try {
                            const response = await fetch(`/workshop/${this.workshopId}/participants`);
                            const data = await response.json();
                            if (data.success) {
                                this.participants = data.data;
                            }
                        } catch (error) {
                            console.error('Error loading participants:', error);
                        }
                    },

                    async loadFeedbackQuestions() {
                        try {
                            const response = await fetch(`/workshop/${this.workshopId}/feedback-questions`);
                            const data = await response.json();
                            if (data.success) {
                                this.feedbackQuestions = data.data;
                            }
                        } catch (error) {
                            console.error('Error loading feedback questions:', error);
                        }
                    },

                    switchTab(index) {
                        this.activeTab = index;
                        this.$nextTick(() => {
                            this.updateIndicator();
                            this.scrollTabIntoView(index);
                        });
                    },

                    updateIndicator() {
                        const buttons = this.$refs.tabHeader?.querySelectorAll('button');
                        if (buttons && buttons[this.activeTab]) {
                            const activeButton = buttons[this.activeTab];
                            this.indicatorWidth = activeButton.offsetWidth;
                            this.indicatorOffset = activeButton.offsetLeft;

                            if (this.indicatorWidth === 0) {
                                setTimeout(() => {
                                    this.indicatorWidth = activeButton.offsetWidth;
                                    this.indicatorOffset = activeButton.offsetLeft;
                                }, 10);
                            }
                        }
                    },

                    scrollTabIntoView(index) {
                        const buttons = this.$refs.tabHeader.querySelectorAll('button');
                        if (buttons[index]) {
                            const button = buttons[index];
                            const header = this.$refs.tabHeader;

                            const buttonLeft = button.offsetLeft;
                            const buttonRight = buttonLeft + button.offsetWidth;
                            const headerScrollLeft = header.scrollLeft;
                            const headerWidth = header.offsetWidth;

                            if (buttonLeft < headerScrollLeft) {
                                header.scrollTo({
                                    left: buttonLeft - 20,
                                    behavior: 'smooth'
                                });
                            } else if (buttonRight > headerScrollLeft + headerWidth) {
                                header.scrollTo({
                                    left: buttonRight - headerWidth + 20,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    }
                }
            }
        }
    </script>
@endsection
