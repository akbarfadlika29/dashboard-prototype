@extends('layouts.admin')

@section('title','Import Files')

@section('content')

<h1 class="text-xl font-bold mb-6">
    Import PDF / Excel / JPG / PNG
</h1>

<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('dataset.importFiles.preview') }}">

@csrf

<div class="bg-white rounded-xl shadow p-6 space-y-4">

    <input
        type="text"
        name="nama"
        class="border p-2 w-full"
        placeholder="Nama Dataset"
        required>

    <select name="kategori_id"
            class="border p-2 w-full"
            required>

        <option value="">Kategori</option>

        @foreach($kategori as $k)

            <option value="{{ $k->id }}">
                {{ $k->nama }}
            </option>

        @endforeach

    </select>

    <select
        name="seksi_id"
        class="border p-2 w-full"
        required>

        <option value="">Seksi</option>

        @foreach($seksi as $s)

            <option value="{{ $s->id }}">
                {{ $s->nama }}
            </option>

        @endforeach

    </select>

    <input
        type="file"
        name="file"
        accept=".pdf,.xlsx,.xls,.jpg,.jpeg,.png"
        class="border p-2 w-full"
        required>

    <button
        class="bg-green-600 text-white px-5 py-2 rounded">

        Preview

    </button>

</div>

</form>

@endsection