@extends('layouts.admin')

@section('title', $dataset->nama)

@section('content')

{{-- HERO --}}
<section class="mb-8">
    <div class="rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white p-6 sm:p-8 shadow-lg relative overflow-hidden">

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">

            <div class="max-w-3xl">
                <p class="text-sm uppercase tracking-widest text-white/80 mb-2">
                    Detail Dataset
                </p>

                <h1 class="text-2xl sm:text-3xl font-bold leading-tight">
                    {{ $dataset->nama }}
                </h1>

                <p class="text-sm sm:text-base text-white/90 mt-2">
                    {{ $dataset->deskripsi }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a href="{{ route('admin.dashboard.kategori.show', $dataset->kategori_id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/15 hover:bg-white/25 border border-white/30 text-sm font-medium transition">

                    <i class="fa-solid fa-arrow-left"></i>

                    Kembali

                </a>

            </div>

        </div>

        <div class="absolute -right-8 -bottom-8 text-white/10 text-[150px] sm:text-[190px]">
            <i class="fa-solid fa-file-lines"></i>
        </div>

    </div>
</section>

@php

$extension = strtoupper(pathinfo($dataset->file_original_name, PATHINFO_EXTENSION));

@endphp

<div class="grid lg:grid-cols-3 gap-6">

    {{-- PREVIEW --}}
    <div class="lg:col-span-2">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

            <h2 class="text-lg font-semibold mb-5">

                Preview File

            </h2>

            @if($extension == 'PDF')

                <iframe
                    src="{{ public_asset($dataset->file_storage) }}"
                    class="w-full h-[750px] border rounded-xl">
                </iframe>

            @elseif(in_array($extension,['JPG','JPEG','PNG']))

                <img
                    src="{{ public_asset($dataset->file_storage) }}"
                    class="max-w-full rounded-xl border mx-auto">

            @elseif(in_array($extension,['XLS','XLSX']))

                <div class="flex flex-col items-center justify-center h-[500px] text-center">

                    <i class="fa-solid fa-file-excel text-green-600 text-8xl mb-6"></i>

                    <h3 class="font-bold text-lg">

                        {{ $dataset->file_original_name }}

                    </h3>

                    <p class="text-slate-500 mt-3">

                        File Excel tidak dapat dipreview langsung.

                    </p>

                    <a href="{{ public_asset($dataset->file_storage) }}"
                       download
                       class="mt-6 px-5 py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white">

                        <i class="fa-solid fa-download mr-2"></i>

                        Download Excel

                    </a>

                </div>

            @else

                <div class="flex flex-col items-center justify-center h-[500px] text-center">

                    <i class="fa-solid fa-file text-slate-400 text-8xl mb-6"></i>

                    <h3 class="font-semibold text-lg">

                        Preview tidak tersedia

                    </h3>

                    <p class="text-slate-500 mt-2">

                        File ini tidak dapat dipreview melalui browser.

                    </p>

                </div>

            @endif

        </div>

    </div>

    {{-- INFORMASI --}}
    <div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

            <h2 class="text-lg font-semibold mb-5">

                Informasi Dataset

            </h2>

            <table class="table-auto w-full text-sm">

                <tr class="border-b">
                    <td class="py-3 font-medium w-40">
                        Nama Dataset
                    </td>

                    <td>

                        {{ $dataset->nama }}

                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-medium">

                        Nama File

                    </td>

                    <td>

                        {{ $dataset->file_original_name }}

                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-medium">

                        Jenis File

                    </td>

                    <td>

                        {{ $extension }}

                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-medium">

                        MIME

                    </td>

                    <td>

                        {{ $dataset->file_mime }}

                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-medium">

                        Ukuran

                    </td>

                    <td>

                        {{ number_format($dataset->file_size / 1024,2) }} KB

                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-medium">

                        Terakhir Update

                    </td>

                    <td>

                        {{ $dataset->updated_at->format('d M Y H:i') }}

                    </td>
                </tr>

            </table>

            <a href="{{ public_asset($dataset->file_storage) }}"
               download
               class="mt-6 w-full inline-flex justify-center items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white py-3 transition">

                <i class="fa-solid fa-download"></i>

                Download File

            </a>

        </div>

    </div>

</div>

@endsection