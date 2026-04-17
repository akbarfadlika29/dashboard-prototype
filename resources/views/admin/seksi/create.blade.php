@extends('layouts.admin')

@section('title', 'Tambah Seksi')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg border border-gray-100">

<form method="POST" action="{{ route('admin.seksi.store') }}">
@csrf

<div class="grid gap-5">

    <input name="nama"
        placeholder="Nama Seksi"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none">

    <button class="bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold shadow">
        Simpan
    </button>

</div>

</form>

</div>

@endsection