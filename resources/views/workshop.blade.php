@extends('layouts.app')

@section('content')
    <style>
        .expand-icon {
            transition: transform 0.2s ease;
        }

        .expand-icon.rotated {
            transform: rotate(90deg);
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
        <x-fragments.modal-button label="Add Workshop" target="modal-control-event" variant="transparent" act="create">
            <i class="fa-solid fa-plus mr-2"></i>
            Tambah Workshop Event
        </x-fragments.modal-button>

        @push('modals')
            <x-fragments.form-modal id="modal-control-event" title="Tambah User" createTitle="Tambah User" editTitle="Edit Materi"
                action="{{ route('workshop.store') }}">
                <x-fragments.text-field color="light" label="Judul" name="title" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-fragments.text-field color="light" type="number" label="Quota" name="quota" required />
                    <x-fragments.select-field color="light" name="status" label="Status Workshop" :options="[
                        'coming_soon' => 'Coming Soon',
                        'inactive' => 'Inactive',
                        'registered' => 'Registered',
                        'full' => 'Full',
                    ]"
                        value="{{ old('status', $workshop->status ?? '') }}" required />

                </div>
                <x-fragments.text-field color="light" type="date" label="Tanggal" name="date" required />
                <div class="grid grid-cols-2 gap-4">
                    <x-fragments.text-field color="light" type="time" label="Jam Mulai" name="time_start" required />
                    <x-fragments.text-field color="light" type="time" label="Jam Selesai" name="time_end" required />
                </div>
                <x-fragments.text-field color="light" label="Lokasi" name="location" required />
                <div class="text-white">
                    <label for="description">description <span class="text-red-500">*</span></label>
                    <textarea
                        class="border-gray-300 text-white bg-white/20  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full "
                        name="description" id="description" cols="30" rows="2"></textarea>
                </div>
                <div class="text-white">
                    <label for="benefit">Benefit <span class="text-red-500">*</span></label>
                    <textarea
                        class="border-gray-300 text-white bg-white/20  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full "
                        name="benefit" id="benefit" cols="30" rows="2"></textarea>
                </div>
            </x-fragments.form-modal>
        @endpush
    </div>

    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-8">Manajemen Event Workshop </h1>

        <div class="backdrop-blur-2xl  rounded-lg shadow-lg overflow-hidden" x-data="tableData()">
            <table class="min-w-full">
                <thead class="backdrop-blur-2xl shadow-md">
                    <tr>
                        <th class="w-8 px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider"></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Judul
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jam mulai
                            - selesai </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Quota
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="backdrop-blur-2xl shadow-sm">
                    <template x-for="(user, index) in users" :key="user.id">
                        <tr>
                            <td colspan="7" class="p-0">
                                <div class="border-b w-full border-gray-200">
                                    <div class="flex items-center w-full hover:bg-gray-50/10 hover:backdrop-blur-3xl cursor-pointer"
                                        @click="toggleRow(index)">
                                        <div class="px-6 py-4 w-8">
                                            <svg class="w-4 h-4 text-white expand-icon"
                                                :class="{ 'rotated': expandedRows.includes(index) }" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>

                                    </div>

                                    <div x-show="expandedRows.includes(index)"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                                        x-transition:enter-end="opacity-100 transform translate-y-0"
                                        class="px-6 py-4 h-96 bg-white/15 overflow-auto scrollbar backdrop-blur-xl">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <h3 class="text-lg font-semibold text-white mb-2">Detail Workshop Event</h3>
                                                <p class="text-md text-white"><strong>Judul:</strong> <span
                                                        x-text="user.name"></span></p>
                                                <p class="text-md text-white"><strong>Status:</strong> <span
                                                        x-text="user.email"></span></p>
                                                <p class="text-md text-white"><strong>Tanggal:</strong> <span
                                                        x-text="user.position"></span></p>
                                                <p class="text-md text-white"><strong>Status:</strong> <span
                                                        x-text="user.status"></span></p>
                                                <p class="text-md text-white"><strong>Jam Mulai - Selesai:</strong> <span
                                                        x-text="user.phone"></span></p>
                                                <p class="text-md text-white"><strong>Quota:</strong> <span
                                                        x-text="user.address"></span></p>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-white mb-2">Informasi Tambahan</h3>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="shadow-md bg-white/25 rounded-lg p-3 text-white">
                                                        <h1 class="text-xl font-bold"><i
                                                                class="fa-solid fa-location-dot gradient-icon"></i> Alamat
                                                        </h1>
                                                        <p class="text-sm font-semibold">Lorem ipsum dolor, sit amet
                                                            consectetur adipisicing elit. Expedita
                                                            ipsam inventore ad.</p>
                                                    </div>
                                                    <div class="shadow-md bg-white/25 rounded-lg p-3 text-white">
                                                        <h1 class="text-xl font-bold"><i
                                                                class="fas fa-trophy gradient-icon"></i> Benefit
                                                        </h1>
                                                        <p class="text-sm font-semibold">Lorem ipsum dolor, sit amet
                                                            consectetur adipisicing elit. Expedita
                                                            ipsam inventore ad.</p>
                                                    </div>
                                                </div>
                                                <div class="shadow-md mt-2 bg-white/25 rounded-lg p-3 text-white">
                                                    <h1 class="text-xl font-bold"><i
                                                            class="fas fa-palette  gradient-icon"></i> Description
                                                    </h1>
                                                    <p class="text-sm font-semibold">Lorem ipsum dolor, sit amet
                                                        consectetur adipisicing elit. Expedita
                                                        ipsam inventore ad.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="w-full mt-5  rounded-lg shadow-lg overflow-hidden"
                                            x-data="tabComponent()" x-init="init()">

                                            <div class="flex backdrop-blur-2xl border-b  relative overflow-x-auto scrollbar-hide"
                                                x-ref="tabHeader">
                                                <div
                                                    class="grid grid-cols-2 bg-white/10   shadow-md backdrop-blur-2xl w-full ">

                                                    <template x-for="(tab, index) in tabs" :key="index">
                                                        <button
                                                            class="flex-shrink-0  px-4 py-3 lg:px-6 lg:py-4 text-sm lg:text-base font-medium text-gray-500 hover:text-sky-600 hover:bg-blue-50/25 transition-all duration-300 whitespace-nowrap relative"
                                                            :class="{
                                                                ' bg-white/25 ': activeTab ===
                                                                    index
                                                            }"
                                                            @click="switchTab(index)" x-text="tab.title">
                                                        </button>
                                                    </template>
                                                </div>

                                                <div class="absolute bottom-0 h-0.5 bg-blue-600 transition-all duration-300 ease-out rounded-full"
                                                    :style="`width: ${indicatorWidth}px; transform: translateX(${indicatorOffset}px); opacity: ${indicatorWidth > 0 ? 1 : 0}`">
                                                </div>
                                            </div>

                                            <div class="p-6 lg:p-8 bg-transparent min-h-[400px]">
                                                <div x-show="activeTab === 0" x-transition:enter="animate-fade-in"
                                                    class="space-y-6">


                                                </div>

                                                <div x-show="activeTab === 1" x-transition:enter="animate-fade-in"
                                                    class="space-y-6">



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

            <div class="p-4 bg-blue-50/20 backdrop-blur-2xl  text-sm text-blue-600" x-show="users.length === 0">
                Tidak ada data untuk ditampilkan
            </div>
            <div class="p-4  bg-blue-50/20 backdrop-blur-2xl  text-sm text-green-600" x-show="users.length > 0">
                Menampilkan <span x-text="users.length"></span> data pengguna
            </div>
        </div>
    </div>





    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const title = document.querySelector('input[name="title"]');
            const quota = document.querySelector('input[name="quota"]');
            const status = document.querySelector('input[name="status"]');
            const date = document.querySelector('input[name="date"]');
            const jam_mulai = document.querySelector('input[name="jam_mulai"]');
            const jam_selesai = document.querySelector('input[name="jam_selesai"]');
            const location = document.querySelector('input[name="location"]');
            const description = document.querySelector('input[name="description"]');
            const benefit = document.querySelector('input[name="benefit"]');
            let currentModa = 'create';

            document.addEventListener('modalUpdate', function(e) {
                if (e.detail.modalId === 'modal-control-users') {
                    currentModa = 'update';
                    const event = e.detail.data;
                    console.log('User Data:', event);

                    title.value = event.title || '';
                    quota.value = event.quota || '';
                    status.value = event.status || '';
                    date.value = event.date || '';
                    jam_mulai.value = event.jam_mulai || '';
                    jam_selesai.value = event.jam_selesai || '';
                    location.value = event.location || '';
                    description.value = event.description || '';
                    benefit.value = event.benefit || '';

                }
            });
        });

        function tableData() {
            return {
                expandedRows: [],
                users: [{
                        id: 1,
                        name: 'Ahmad Ferdi',
                        email: 'ahmad.ferdi@example.com',
                        position: 'Full Stack Developer',
                        status: 'active',
                        avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        phone: '+62 812 3456 7890',
                        address: 'Jl. Sudirman No. 123, Jakarta',
                        joined_date: '15 Jan 2023',
                        department: 'Engineering',
                        salary: 15000000,
                        manager: 'Budi Santoso',
                        recent_activities: [{
                                id: 1,
                                description: 'Menyelesaikan fitur authentication',
                                date: '2 hari lalu'
                            },
                            {
                                id: 2,
                                description: 'Code review untuk project dashboard',
                                date: '5 hari lalu'
                            },
                            {
                                id: 3,
                                description: 'Meeting dengan client',
                                date: '1 minggu lalu'
                            }
                        ]
                    },
                    {
                        id: 2,
                        name: 'Siti Nurhaliza',
                        email: 'siti.nurhaliza@example.com',
                        position: 'UI/UX Designer',
                        status: 'active',
                        avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        phone: '+62 813 4567 8901',
                        address: 'Jl. Thamrin No. 456, Jakarta',
                        joined_date: '20 Mar 2023',
                        department: 'Design',
                        salary: 12000000,
                        manager: 'Dewi Sartika',
                        recent_activities: [{
                                id: 1,
                                description: 'Design mockup untuk mobile app',
                                date: '1 hari lalu'
                            },
                            {
                                id: 2,
                                description: 'User testing session',
                                date: '3 hari lalu'
                            },
                            {
                                id: 3,
                                description: 'Presentasi design system',
                                date: '1 minggu lalu'
                            }
                        ]
                    },
                    {
                        id: 3,
                        name: 'Bambang Wijaya',
                        email: 'bambang.wijaya@example.com',
                        position: 'Backend Developer',
                        status: 'inactive',
                        avatar: 'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        phone: '+62 814 5678 9012',
                        address: 'Jl. Gatot Subroto No. 789, Jakarta',
                        joined_date: '10 Feb 2023',
                        department: 'Engineering',
                        salary: 14000000,
                        manager: 'Budi Santoso',
                        recent_activities: [{
                                id: 1,
                                description: 'Maintenance database server',
                                date: '1 minggu lalu'
                            },
                            {
                                id: 2,
                                description: 'Deploy ke production',
                                date: '2 minggu lalu'
                            },
                            {
                                id: 3,
                                description: 'Bug fixing API payment',
                                date: '3 minggu lalu'
                            }
                        ]
                    }
                ],

                toggleRow(index) {
                    if (this.expandedRows.includes(index)) {
                        this.expandedRows = this.expandedRows.filter(i => i !== index);
                    } else {
                        this.expandedRows.push(index);
                    }
                },

                editUser(user) {
                    alert('Edit user: ' + user.name);
                },

                deleteUser(userId) {
                    if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                        this.users = this.users.filter(user => user.id !== userId);
                        this.expandedRows = [];
                    }
                },

                formatCurrency(amount) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(amount);
                }
            }
        }

        function tabComponent() {
            return {
                activeTab: 0,
                indicatorWidth: 0,
                indicatorOffset: 0,

                tabs: [{
                        title: 'Participants'
                    },
                    {
                        title: 'Feedback Questions'
                    }
                ],

                init() {
                    this.$nextTick(() => {
                        this.updateIndicator();
                    });

                    setTimeout(() => {
                        this.updateIndicator();
                    }, 50);

                    setTimeout(() => {
                        this.updateIndicator();
                    }, 200);

                    window.addEventListener('resize', () => {
                        this.updateIndicator();
                    });

                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', () => {
                            this.updateIndicator();
                        });
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
    </script>
@endsection
