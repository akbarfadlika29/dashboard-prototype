@extends('layouts.admin')

@section('title', 'Edit Seksi')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg border border-gray-100">

<form method="POST" action="{{ route('admin.seksi.update', $seksi) }}">
@csrf
@method('PUT')

<div class="grid gap-5">

    <input name="nama"
        value="{{ $seksi->nama }}"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none">

    <div class="flex gap-3">
        <a href="{{ route('admin.seksi.index') }}"
           class="w-1/2 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-xl font-semibold">
            Batal
        </a>

        <button class="w-1/2 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold shadow">
            Update
        </button>
    </div>

</div>

</form>

</div>

@endsection