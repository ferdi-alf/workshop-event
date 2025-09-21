@extends('layouts.app')
@section('content')
    <x-reusable-table :searchBar="true" :center="true" position="center" :headers="['No', 'Name', 'Whatsapp', 'Email', 'Kampus', 'Jurusan']" :data="$data"
        :columns="[
            fn($row, $i) => $i + 1,
            fn($row) => $row->name,
            fn($row) => $row->clickToWhatsapp(),
            fn($row) => $row->email,
            fn($row) => $row->campus,
            fn($row) => $row->major,
        ]" />
@endsection
