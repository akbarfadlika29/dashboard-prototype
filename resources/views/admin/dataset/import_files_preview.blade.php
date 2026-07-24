@extends('layouts.admin')

@section('title','Preview Files')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Preview Dataset
</h1>

<div class="grid lg:grid-cols-2 gap-6">

    {{-- PREVIEW --}}
    <div class="bg-white rounded-xl shadow p-5">

        <h2 class="font-semibold text-lg mb-4">
            Preview File
        </h2>

        @if($extension == 'PDF')

            <iframe
                src="{{ public_asset($file_path) }}"
                class="w-full h-[650px] border rounded-lg">
            </iframe>

        @elseif(in_array($extension, ['JPG','JPEG','PNG']))

            <img src="{{ public_asset($file_path) }}"
                class="max-w-full rounded-lg border mx-auto">

        @elseif(in_array($extension, ['XLS','XLSX']))

            <div class="flex flex-col items-center justify-center h-[400px] text-center">

                <i class="fa-solid fa-file-excel text-green-600 text-7xl mb-4"></i>

                <div class="font-semibold">
                    {{ $original_name }}
                </div>

                <div class="text-slate-500 mt-2">
                    File Excel tidak dapat dipreview langsung.
                </div>

                <div class="text-sm text-slate-400">
                    File akan tetap tersimpan apa adanya.
                </div>

            </div>

        @else

            <div class="text-center py-20">

                Preview tidak tersedia.

            </div>

        @endif

    </div>

    {{-- INFORMASI --}}
    <div class="bg-white rounded-xl shadow p-5">

        <h2 class="font-semibold text-lg mb-4">
            Informasi File
        </h2>

        <table class="table-auto w-full">

            <tr class="border-b">
                <td class="py-3 font-medium">Nama File</td>
                <td>{{ $original_name }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-3 font-medium">Jenis</td>
                <td>{{ strtoupper($extension) }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-3 font-medium">MIME</td>
                <td>{{ $mime }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-3 font-medium">Ukuran</td>
                <td>{{ $size_human }}</td>
            </tr>

        </table>

        <form
            method="POST"
            action="{{ route('dataset.importFilesStore') }}"
            class="mt-8">

            @csrf

            <input type="hidden" name="nama" value="{{ $request['nama'] }}">
            <input type="hidden" name="kategori_id" value="{{ $request['kategori_id'] }}">
            <input type="hidden" name="seksi_id" value="{{ $request['seksi_id'] }}">

            <input type="hidden" name="file_path" value="{{ $file_path }}">
            <input type="hidden" name="original_name" value="{{ $original_name }}">
            <input type="hidden" name="mime" value="{{ $mime }}">
            <input type="hidden" name="size" value="{{ $size }}">

            <button
                class="w-full bg-green-700 hover:bg-green-800 text-white py-3 rounded-xl transition">

                <i class="fa-solid fa-floppy-disk"></i>

                Simpan Dataset

            </button>

        </form>

    </div>

</div>

@endsection