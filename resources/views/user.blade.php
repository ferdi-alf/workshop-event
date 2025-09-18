@extends('layouts.app')

@section('content')
    <div>
        <div class="flex justify-end mb-4">
            <x-fragments.modal-button target="modal-control-users" variant="transparent" act="create">
                <i class="fa-solid fa-plus mr-2"></i>
                Tambah User
            </x-fragments.modal-button>
        </div>

        @push('modals')
            <x-fragments.form-modal id="modal-control-users" title="Tambah User" createTitle="Tambah User" editTitle="Edit Materi"
                action="{{ route('user.store') }}">
                <div class="grid grid-cols-2 gap-4">
                    <x-fragments.text-field color="light" label="name" name="name" required />
                    <x-fragments.text-field color="light" label="Email" name="email" type="email" required
                        class="mt-4" />
                </div>
                <x-fragments.text-field color="light" label="Password" name="password" type="password" required />
            </x-fragments.form-modal>
        @endpush


        <div class="mt-6">
            <h2 class="text-lg text-white font-semibold mb-2">Data Admin</h2>
            <x-reusable-table :center="true" position="center" :headers="['No', 'Name', 'Email', 'Created At']" :data="$data" :columns="[
                fn($row, $i) => $i + 1,
                fn($row) => $row->name,
                fn($row) => $row->email,
                fn($row) => $row->created_at->format('d M Y'),
            ]"
                :showActions="true" :actionButtons="fn($row) => view('components.action-buttons', [
                    'modalTarget' => 'modal-control-users',
                    'editData' => [
                        'id' => $row->id,
                        'fetchEndpoint' => '/user/' . $row->id,
                        'updateEndpoint' => '/user/' . $row->id,
                        'act' => 'update',
                    ],
                    'deleteRoute' => route('user.destroy', $row->id),
                ])" />
        </div>


    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const name = document.querySelector('input[name="name"]');
            const email = document.querySelector('input[name="email"]');
            const password = document.querySelector('input[name="password"]');

            document.addEventListener('modalCreate', function(e) {
                if (e.detail.modalId === 'modal-control-users') {
                    password.required = true;
                }
            });

            document.addEventListener('modalUpdate', function(e) {
                if (e.detail.modalId === 'modal-control-users') {
                    currentModa = 'update';
                    const userData = e.detail.data;
                    console.log('User Data:', userData);

                    name.value = userData.name || '';
                    email.value = userData.email || '';
                    password.required = false;
                }
            });


        });
    </script>
@endsection
