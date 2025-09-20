@extends('layouts.app')

@section('content')
    <div class="flex justify-end mb-4">
        <x-fragments.modal-button target="modal-control-banners" variant="transparent" act="create">
            <i class="fa-solid fa-plus mr-2"></i>
            Tambah Banner
        </x-fragments.modal-button>
    </div>

    @push('modals')
        <x-fragments.form-modal id="modal-control-banners" title="Tambah Banner" createTitle="Tambah Banner" editTitle="Edit Banner"
            action="{{ route('banner.store') }}" fetchEndpoint="{{ route('banner.show', ':id') }}">

            <div class="mb-4">
                <label class="block text-white text-sm font-medium mb-2">Upload Gambar Banner</label>
                <div id="dropZone"
                    class="border-2 border-dashed border-white/40 rounded-lg p-6 text-center cursor-pointer hover:border-white/60 transition-colors">
                    <div id="dropContent">
                        <i class="fa-solid fa-cloud-upload-alt text-4xl text-white/70 mb-3"></i>
                        <p class="text-white/80 mb-2">Drag & drop gambar di sini atau klik untuk memilih</p>
                        <p class="text-white/60 text-sm">Gambar landscape lebih direkomendasikan</p>
                        <input type="file" id="bannerImage" name="image" accept="image/*" class="hidden" required>
                    </div>
                    <div id="imagePreview" class="hidden">
                        <img id="previewImg" src="" alt="Preview" class="max-w-full max-h-48 mx-auto rounded-lg">
                        <button type="button" id="removeImage" class="mt-2 text-red-400 hover:text-red-300 text-sm">
                            <i class="fa-solid fa-trash mr-1"></i> Hapus Gambar
                        </button>
                    </div>
                </div>
            </div>

            <x-fragments.text-field color="light" label="Caption" name="caption" required />

            <div class="relative" x-data="{
                open: false,
                search: '',
                workshops: [],
                selectedWorkshop: null,
                workshopId: null,
                loading: false,
            
                searchWorkshops() {
                    if (this.search.length < 2) {
                        this.workshops = [];
                        this.open = false;
                        return;
                    }
            
                    this.loading = true;
                    this.open = true;
            
                    fetch(`{{ route('feedback.search') }}?q=${encodeURIComponent(this.search)}`)
                        .then(response => response.json())
                        .then(data => {
                            this.workshops = data;
                            this.loading = false;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.workshops = [];
                            this.loading = false;
                        });
                },
            
                selectWorkshop(workshop) {
                    this.selectedWorkshop = workshop;
                    this.workshopId = workshop.id;
                    this.search = workshop.title;
                    this.open = false;
                }
            }">
                <label class="block text-white text-sm font-medium mb-2">Workshop</label>
                <div class="relative">
                    <input type="text" x-model="search" @input.debounce.300ms="searchWorkshops()" @click="open = true"
                        placeholder="Harap ketikan judul workshop..."
                        class="w-full px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <div x-show="loading" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
                    </div>
                </div>

                <div x-show="open && (workshops.length > 0 || loading || (search.length >= 2 && workshops.length === 0 && !loading))"
                    x-transition @click.away="open = false"
                    class="absolute z-40 w-full mt-1 bg-white rounded-lg shadow-lg max-h-60 overflow-y-auto">

                    <div x-show="loading" class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <div class="animate-spin rounded-full h-4 w-4 border-2 border-gray-400 border-t-transparent"></div>
                            <span class="text-gray-600 text-sm">Mencari workshop...</span>
                        </div>
                    </div>

                    <div x-show="!loading && search.length >= 2 && workshops.length === 0" class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 20c-4.411 0-8-3.589-8 8-8s3.589-8 8-8 8 3.589 8 8a7.962 7.962 0 01-2 5.291z">
                                </path>
                            </svg>
                            <span class="text-gray-600 text-sm">Tidak ditemukan workshop dengan judul "<span x-text="search"
                                    class="font-medium"></span>"</span>
                        </div>
                    </div>

                    <template x-for="workshop in workshops" :key="workshop.id">
                        <div @click="selectWorkshop(workshop)"
                            class="px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0 transition-colors duration-150">
                            <span x-text="workshop.title" class="text-gray-800"></span>
                        </div>
                    </template>
                </div>

                <div x-show="selectedWorkshop" class="mt-2 p-2 bg-green-100 rounded border-l-4 border-green-500">
                    <p class="text-green-700 text-sm">
                        <span class="font-semibold">Workshop terpilih:</span>
                        <span x-text="selectedWorkshop?.title"></span>
                    </p>
                </div>

                <input type="hidden" name="workshop_id" x-bind:value="workshopId">
            </div>
        </x-fragments.form-modal>
    @endpush

    @push('modals')
        <x-modal-layout id="image-preview-modal" title="Preview Banner" size="xl" :closable="true">
            <div class="text-center">
                <img id="modalPreviewImage" src="" alt="Banner Preview" class="max-w-full max-h-96 mx-auto rounded-lg">
            </div>
        </x-modal-layout>
    @endpush

    <div class="mt-6">
        <h2 class="text-lg text-white font-semibold mb-2">Data Banner</h2>
        <div class="backdrop-blur-3xl bg-white/10 border border-white/20 rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Gambar</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Caption</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Workshop
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Posisi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Created At
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Action
                        </th>
                    </tr>
                </thead>
                <tbody id="sortable-table" class="divide-y divide-white/10">
                    @foreach ($banners as $index => $banner)
                        <tr class="sortable-row hover:bg-white/5 transition-colors cursor-move"
                            data-id="{{ $banner->id }}">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-white">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-grip-vertical text-white/40 mr-2"></i>
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <img src="{{ asset('img/banners/' . $banner->image_url) }}" alt="Banner"
                                    class="h-12 w-20 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                                    onclick="showImagePreview('{{ asset('img/banners/' . $banner->image_url) }}')">
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $banner->caption }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-white">
                                {{ $banner->workshop->title ?? 'N/A' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $banner->position }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-white">
                                {{ $banner->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <x-action-buttons :modalTarget="'modal-control-banners'" :showView="false" :editData="[
                                    'id' => $banner->id,
                                    'fetchEndpoint' => route('banner.show', $banner->id),
                                    'updateEndpoint' => route('banner.update', $banner->id),
                                    'act' => 'update',
                                ]" :deleteRoute="route('banner.destroy', $banner->id)"
                                    deleteMessage="Yakin ingin menghapus banner ini?" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let act = 'create';
            const caption = document.querySelector('input[name="caption"]');
            const bannerImage = document.getElementById('bannerImage');
            const dropZone = document.getElementById('dropZone');
            const dropContent = document.getElementById('dropContent');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const removeImage = document.getElementById('removeImage');

            dropZone.addEventListener('click', () => bannerImage.click());
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-white/80');
            });
            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('border-white/80');
            });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-white/80');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    bannerImage.files = files;
                    displayImage(files[0]);
                }
            });

            bannerImage.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    displayImage(e.target.files[0]);
                }
            });

            removeImage.addEventListener('click', () => {
                bannerImage.value = '';
                dropContent.classList.remove('hidden');
                imagePreview.classList.add('hidden');
                bannerImage.required = act === 'create';
            });

            function displayImage(file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    dropContent.classList.add('hidden');
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }

            document.addEventListener('modalCreate', function(e) {
                if (e.detail.modalId === 'modal-control-banners') {
                    act = 'create';
                    caption.value = '';
                    bannerImage.value = '';
                    bannerImage.required = true;
                    dropContent.classList.remove('hidden');
                    imagePreview.classList.add('hidden');

                    const alpineElement = document.querySelector('[x-data]');
                    if (alpineElement && alpineElement._x_dataStack) {
                        const alpineComponent = alpineElement._x_dataStack[0];
                        alpineComponent.search = '';
                        alpineComponent.selectedWorkshop = null;
                        alpineComponent.workshopId = null;
                        alpineComponent.open = false;
                        alpineComponent.workshops = [];
                    }
                }
            });

            document.addEventListener('modalUpdate', function(e) {
                if (e.detail.modalId === 'modal-control-banners') {
                    act = 'update';
                    const bannerData = e.detail.data;
                    console.log('Banner Data:', bannerData);

                    caption.value = bannerData.caption || '';
                    bannerImage.required = false;

                    if (bannerData.image) {
                        previewImg.src = `/img/banners/${bannerData.image}`;
                        dropContent.classList.add('hidden');
                        imagePreview.classList.remove('hidden');
                    }

                    const alpineElement = document.querySelector('[x-data]');
                    if (alpineElement && alpineElement._x_dataStack && bannerData.workshop) {
                        const alpineComponent = alpineElement._x_dataStack[0];
                        alpineComponent.selectedWorkshop = bannerData.workshop;
                        alpineComponent.workshopId = bannerData.workshop.id;
                        alpineComponent.search = bannerData.workshop.title;
                    }
                }
            });

            document.addEventListener('modalReset', function(e) {
                if (e.detail.modalId === 'modal-control-banners') {
                    dropContent.classList.remove('hidden');
                    imagePreview.classList.add('hidden');
                    bannerImage.value = '';
                    caption.value = '';

                    const alpineElement = document.querySelector('[x-data]');
                    if (alpineElement && alpineElement._x_dataStack) {
                        const alpineComponent = alpineElement._x_dataStack[0];
                        alpineComponent.search = '';
                        alpineComponent.selectedWorkshop = null;
                        alpineComponent.workshopId = null;
                        alpineComponent.open = false;
                        alpineComponent.workshops = [];
                    }
                }
            });

            const sortable = Sortable.create(document.getElementById('sortable-table'), {
                handle: '.sortable-row',
                animation: 150,
                onEnd: function(evt) {
                    const rows = Array.from(document.querySelectorAll('.sortable-row'));
                    const positions = rows.map((row, index) => ({
                        id: row.dataset.id,
                        position: index + 1
                    }));

                    fetch('/banner/update-positions', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                positions
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                rows.forEach((row, index) => {
                                    const positionCell = row.querySelector(
                                        'td:nth-child(5)');
                                    positionCell.textContent = index + 1;
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error updating positions:', error);
                            location.reload();
                        });
                }
            });
        });

        function showImagePreview(imageSrc) {
            document.getElementById('modalPreviewImage').src = imageSrc;
            document.getElementById('image-preview-modal').classList.remove('hidden');
            document.getElementById('image-preview-modal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    </script>
@endsection
