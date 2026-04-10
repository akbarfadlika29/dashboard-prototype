@extends('layouts.admin')

@section('title', 'Import Dataset')

@section('content')

<h1 class="text-xl font-bold mb-6">Import Dataset</h1>

<form method="POST" action="{{ route('dataset.import.preview') }}" enctype="multipart/form-data">
@csrf

<div class="bg-white p-6 rounded-xl shadow space-y-4">

    <h2 class="font-semibold">Info Dataset</h2>

    <input type="text" name="nama" placeholder="Nama Dataset"
        class="border p-2 w-full">

    <select name="kategori_id" class="border p-2 w-full">
        <option value="">Pilih Kategori</option>
        @foreach($kategori as $k)
            <option value="{{ $k->id }}">{{ $k->nama }}</option>
        @endforeach
    </select>

    <select name="seksi_id" class="border p-2 w-full">
        <option value="">Pilih Seksi</option>
        @foreach($seksi as $s)
            <option value="{{ $s->id }}">{{ $s->nama }}</option>
        @endforeach
    </select>

    <input type="file" name="file"
        class="border p-2 w-full">

    <button type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded">
        Preview Data
    </button>

</div>

</form>

@endsection