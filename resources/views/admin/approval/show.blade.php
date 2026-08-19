@extends('layouts.admin')

@section('title', 'Detail Approval Dataset')
@section('subtitle', 'Review dataset dan revisi dataset')

@push('styles')

<link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.11/css/jquery.dataTables.min.css">

<style>

/* =========================================================
   DATASET DATA TABLE
   ========================================================= */

#datasetDataTable_wrapper {
    padding: 0 16px 16px;
}

#datasetDataTable {
    width: 100% !important;
}

#datasetDataTable thead th {

    background: #f8fafc !important;

    color: #334155;

    font-size: 11px;

    text-transform: uppercase;

    letter-spacing: .5px;

    font-weight: 700;

    border-bottom: 1px solid #e2e8f0 !important;

    white-space: nowrap;

}

#datasetDataTable tbody td {

    white-space: nowrap;

    vertical-align: middle;

}

#datasetDataTable tbody tr {

    transition: all .15s ease;

}

#datasetDataTable tbody tr:hover {

    background: #f0fdf4 !important;

}

#datasetDataTable tbody tr:nth-child(even) {

    background: #fcfcfd;

}

#datasetDataTable td,
#datasetDataTable th {

    padding: 13px 16px;

}


/* =========================================================
   SCROLL AREA
   ========================================================= */

div.dt-scroll-body {

    max-height: 420px !important;

}

.dt-scroll-body::-webkit-scrollbar {

    width: 9px;

    height: 9px;

}

.dt-scroll-body::-webkit-scrollbar-thumb {

    background: #94a3b8;

    border-radius: 20px;

}

.dt-scroll-body::-webkit-scrollbar-track {

    background: #f1f5f9;

}

div.dt-scroll-head {

    overflow: hidden !important;

}


/* =========================================================
   DATATABLE TOOLBAR
   ========================================================= */

#datasetDataTable_wrapper .dataTables_length,
#datasetDataTable_wrapper .dataTables_filter {

    margin-top: 16px;

    margin-bottom: 18px;

    padding: 14px 18px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    border-radius: 14px;

    font-size: .9rem;

}


/* =========================================================
   SEARCH
   ========================================================= */

#datasetDataTable_wrapper .dataTables_filter input {

    width: 240px;

    height: 42px;

    border: 1px solid #cbd5e1;

    border-radius: 10px;

    padding: 0 14px;

    outline: none;

    transition: all .2s ease;

}

#datasetDataTable_wrapper .dataTables_filter input:focus {

    border-color: #10b981;

    box-shadow:
        0 0 0 4px rgb(16 185 129 / .15);

}


/* =========================================================
   LENGTH
   ========================================================= */

#datasetDataTable_wrapper .dataTables_length select {

    height: 42px;

    border: 1px solid #cbd5e1;

    border-radius: 10px;

    padding: 0 14px;

    outline: none;

}


/* =========================================================
   PAGINATION
   ========================================================= */

#datasetDataTable_wrapper .dataTables_paginate {

    margin-top: 18px;

}

#datasetDataTable_wrapper .paginate_button {

    min-width: 38px;

    height: 38px;

    line-height: 26px;

    padding: 6px 12px !important;

    border-radius: 10px !important;

    transition: all .2s ease;

}

#datasetDataTable_wrapper
.dataTables_paginate
.paginate_button.current,
#datasetDataTable_wrapper
.dataTables_paginate
.paginate_button.current:hover {

    background: #059669 !important;

    border: 1px solid #059669 !important;

    color: #ffffff !important;

    font-weight: 700;

    box-shadow:
        0 4px 12px rgba(5,150,105,.25);

}

#datasetDataTable_wrapper
.dataTables_paginate
.paginate_button:not(.current):hover {

    background: #f1f5f9 !important;

    border: 1px solid #cbd5e1 !important;

    color: #334155 !important;

}

#datasetDataTable_wrapper .dataTables_info {

    color: #64748b;

}


/* =========================================================
   CUSTOM SCROLLBAR
   ========================================================= */

.custom-scrollbar::-webkit-scrollbar {

    width: 7px;

    height: 7px;

}

.custom-scrollbar::-webkit-scrollbar-track {

    background: #f8fafc;

}

.custom-scrollbar::-webkit-scrollbar-thumb {

    background: #cbd5e1;

    border-radius: 999px;

}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {

    background: #94a3b8;

}

.custom-scrollbar {

    scrollbar-width: thin;

    scrollbar-color: #cbd5e1 #f8fafc;

}

</style>

@endpush

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

        <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-5">

            <div>

                <div class="flex items-center gap-2 text-sm text-slate-500 mb-3">

                    <a href="{{ route('admin.approval.index') }}"
                       class="hover:text-blue-600 transition">
                        Approval Dataset
                    </a>

                    <span>/</span>

                    <span class="text-slate-700">
                        Detail Dataset
                    </span>

                </div>

                <h1 class="text-3xl font-bold text-slate-800">
                    {{ $dataset->nama }}
                </h1>

                @if($dataset->deskripsi)
                    <p class="text-slate-500 mt-3 max-w-4xl">
                        {{ $dataset->deskripsi }}
                    </p>
                @endif

            </div>

            <div class="flex flex-wrap gap-2">

                @php
                    $statusColor = match($dataset->status) {
                        'draft' => 'bg-slate-100 text-slate-700',
                        'pending' => 'bg-amber-100 text-amber-700',
                        'approved' => 'bg-green-100 text-green-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-700',
                    };
                @endphp

                <span class="px-4 py-2 rounded-2xl text-sm font-semibold capitalize {{ $statusColor }}">
                    Dataset {{ str_replace('_', ' ', $dataset->status) }}
                </span>

                @if($dataset->activeRevision)

                    @php
                        $revisionColor = match($dataset->activeRevision->status) {
                            'draft' => 'bg-slate-100 text-slate-700',
                            'pending' => 'bg-blue-100 text-blue-700',
                            'approved' => 'bg-green-100 text-green-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            default => 'bg-slate-100 text-slate-700',
                        };
                    @endphp

                    <span class="px-4 py-2 rounded-2xl text-sm font-semibold capitalize {{ $revisionColor }}">
                        Revisi {{ str_replace('_', ' ', $dataset->activeRevision->status) }}
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- INFO --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

            <div class="text-sm text-slate-500">
                Kategori
            </div>

            <div class="mt-2 text-lg font-semibold text-slate-800">
                {{ $dataset->kategori->nama ?? '-' }}
            </div>

        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

            <div class="text-sm text-slate-500">
                Seksi
            </div>

            <div class="mt-2 text-lg font-semibold text-slate-800">
                {{ $dataset->seksi->nama ?? '-' }}
            </div>

        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

            <div class="text-sm text-slate-500">
                Pembuat
            </div>

            <div class="mt-2 text-lg font-semibold text-slate-800">
                {{ $dataset->creator->nama ?? '-' }}
            </div>

        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

            <div class="text-sm text-slate-500">
                Dibuat
            </div>

            <div class="mt-2 text-lg font-semibold text-slate-800">
                {{ $dataset->created_at->format('d M Y H:i') }}
            </div>

        </div>

    </div>

    @if($dataset->first_created == 'files')

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

            <h2 class="text-xl font-bold mb-5">
                Preview File
            </h2>
            @if($dataset->hasDraftRevision())
                @php
                    $extension = strtolower(pathinfo($dataset->activeRevision->latestFileChange->after_file_original_name, PATHINFO_EXTENSION));
                    $previewUrl = public_asset($dataset->activeRevision->latestFileChange->after_file_storage);
                @endphp
            @else
                @php
                    $extension = strtolower(pathinfo($dataset->file_original_name, PATHINFO_EXTENSION));
                    $previewUrl = public_asset($dataset->file_storage);
                @endphp
            @endif

            @if($extension == 'pdf')

                <iframe
                    src="{{ $previewUrl }}"
                    class="w-full h-[700px] border rounded-xl">
                </iframe>

            @elseif(in_array($extension,['jpg','jpeg','png']))

                <img
                    src="{{ $previewUrl }}"
                    class="mx-auto rounded-xl max-h-[700px]">

            @elseif(in_array($extension,['xls','xlsx']))

                <div class="text-center py-20">

                    <i class="fa-solid fa-file-excel text-7xl text-green-600 mb-4"></i>

                    <div class="font-semibold">
                        {{ $dataset->file_original_name }}
                    </div>

                    <div class="text-slate-500 mt-3">
                        Preview Excel tidak tersedia.
                    </div>

                    <a
                        href="{{ $previewUrl }}"
                        target="_blank"
                        class="inline-flex mt-5 px-5 py-3 rounded-xl bg-green-700 text-white">

                        Download File

                    </a>

                </div>

            @endif

        </div>

    @endif
    
    @if($dataset->status === 'pending')

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

            <h2 class="text-lg font-semibold text-slate-800 mb-5">
                Approval Dataset
            </h2>

            <div class="flex flex-col md:flex-row gap-3">

                {{-- APPROVE DATASET --}}
                <div
                    x-data="{
                        loading: false
                    }"
                    class="flex-1"
                >

                    <form
                        method="POST"
                        action="{{ route('admin.approval.approve', $dataset) }}"
                        @submit="loading = true"
                    >

                        @csrf

                        <button
                            type="submit"
                            :disabled="loading"
                            class="w-full h-12 rounded-2xl
                                bg-green-600 hover:bg-green-700
                                disabled:bg-green-400
                                disabled:cursor-not-allowed
                                disabled:opacity-70
                                text-white font-medium transition
                                inline-flex items-center justify-center gap-2"
                        >

                            <i
                                x-show="!loading"
                                class="fa-solid fa-circle-check"
                            ></i>

                            <i
                                x-show="loading"
                                class="fa-solid fa-spinner fa-spin"
                            ></i>

                            <span
                                x-text="loading
                                    ? 'Memproses...'
                                    : 'Approve Dataset'"
                            ></span>

                        </button>

                    </form>

                </div>


                {{-- REJECT DATASET --}}
                <div
                    x-data="{
                        loading: false
                    }"
                    class="flex-1"
                >

                    <form
                        method="POST"
                        action="{{ route('admin.approval.reject', $dataset) }}"
                        @submit="loading = true"
                    >

                        @csrf

                        <button
                            type="submit"
                            :disabled="loading"
                            class="w-full h-12 rounded-2xl
                                bg-red-600 hover:bg-red-700
                                disabled:bg-red-400
                                disabled:cursor-not-allowed
                                disabled:opacity-70
                                text-white font-medium transition
                                inline-flex items-center justify-center gap-2"
                        >

                            <i
                                x-show="!loading"
                                class="fa-solid fa-circle-xmark"
                            ></i>

                            <i
                                x-show="loading"
                                class="fa-solid fa-spinner fa-spin"
                            ></i>

                            <span
                                x-text="loading
                                    ? 'Memproses...'
                                    : 'Reject Dataset'"
                            ></span>

                        </button>

                    </form>

                </div>

            </div>

        </div>

    @endif

        {{-- REVISION ACTION --}}
        @if($dataset->activeRevision && $dataset->activeRevision->status === 'pending')

            <div class="bg-white rounded-3xl border border-blue-200 shadow-sm p-6">

                <div class="flex items-center gap-2 mb-5">

                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>

                    <h2 class="text-lg font-semibold text-slate-800">
                        Approval Revisi Dataset
                    </h2>

                </div>

                <div class="flex flex-col md:flex-row gap-3">

                    {{-- APPROVE REVISI --}}
                    <div
                        x-data="{
                            loading: false
                        }"
                        class="flex-1"
                    >

                        <form
                            method="POST"
                            action="{{ route('admin.approval.approveUpdate', $dataset) }}"
                            @submit="loading = true"
                        >

                            @csrf

                            <button
                                type="submit"
                                :disabled="loading"
                                class="w-full h-12 rounded-2xl
                                    bg-blue-600 hover:bg-blue-700
                                    disabled:bg-blue-400
                                    disabled:cursor-not-allowed
                                    disabled:opacity-70
                                    text-white font-medium transition
                                    inline-flex items-center justify-center gap-2"
                            >

                                <i
                                    x-show="!loading"
                                    class="fa-solid fa-check-double"
                                ></i>

                                <i
                                    x-show="loading"
                                    class="fa-solid fa-spinner fa-spin"
                                ></i>

                                <span
                                    x-text="loading
                                        ? 'Memproses...'
                                        : 'Approve Revisi'"
                                ></span>

                            </button>

                        </form>

                    </div>


                    {{-- REJECT REVISI --}}
                    <div
                        x-data="{
                            loading: false
                        }"
                        class="flex-1"
                    >

                        <form
                            method="POST"
                            action="{{ route('admin.approval.rejectUpdate', $dataset) }}"
                            @submit="loading = true"
                        >

                            @csrf

                            <button
                                type="submit"
                                :disabled="loading"
                                class="w-full h-12 rounded-2xl
                                    bg-orange-600 hover:bg-orange-700
                                    disabled:bg-orange-400
                                    disabled:cursor-not-allowed
                                    disabled:opacity-70
                                    text-white font-medium transition
                                    inline-flex items-center justify-center gap-2"
                            >

                                <i
                                    x-show="!loading"
                                    class="fa-solid fa-ban"
                                ></i>

                                <i
                                    x-show="loading"
                                    class="fa-solid fa-spinner fa-spin"
                                ></i>

                                <span
                                    x-text="loading
                                        ? 'Memproses...'
                                        : 'Reject Revisi'"
                                ></span>

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @endif

    @php
        $changes = $dataset->activeRevision?->changes ?? collect();

        $totalCreate = $changes->where('action', 'create_row')->count();
        $totalUpdate = $changes->where('action', 'update_row')->count();
        $totalDelete = $changes->where('action', 'delete_row')->count();
        $totalDataset = $changes->where('action', 'update_dataset')->count();
    @endphp
    
    @if($dataset->first_created != 'files')

        {{-- REVISION CHANGES --}}
        @if($dataset->activeRevision)

            <div class="bg-white rounded-3xl border border-blue-200 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-blue-200 bg-blue-50">

                    <h2 class="text-xl font-bold text-blue-800">
                        Perubahan Revisi
                    </h2>

                    <p class="text-sm text-blue-600 mt-1">
                        Hanya perubahan yang diajukan pada revisi ini
                    </p>
                    @if(
                        $totalCreate ||
                        $totalUpdate ||
                        $totalDelete ||
                        $totalDataset
                    )

                    <div class="mt-5 grid grid-cols-2 md:grid-cols-4 gap-3">

                        @if($totalCreate)
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                <div class="text-2xl font-bold text-green-700">
                                    {{ $totalCreate }}
                                </div>

                                <div class="text-sm text-green-600">
                                    Data Ditambah
                                </div>
                            </div>
                        @endif

                        @if($totalUpdate)
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                <div class="text-2xl font-bold text-amber-700">
                                    {{ $totalUpdate }}
                                </div>

                                <div class="text-sm text-amber-600">
                                    Data Diubah
                                </div>
                            </div>
                        @endif

                        @if($totalDelete)
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                                <div class="text-2xl font-bold text-red-700">
                                    {{ $totalDelete }}
                                </div>

                                <div class="text-sm text-red-600">
                                    Data Dihapus
                                </div>
                            </div>
                        @endif

                        @if($totalDataset)
                            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4">
                                <div class="text-2xl font-bold text-indigo-700">
                                    {{ $totalDataset }}
                                </div>

                                <div class="text-sm text-indigo-600">
                                    Info Dataset Diubah
                                </div>
                            </div>
                        @endif

                    </div>

                    @endif

                </div>

                <div class="divide-y divide-slate-100">

                    @forelse($dataset->activeRevision->changes as $change)

                        <div class="p-6">

                            {{-- CREATE --}}
                            @if($change->action === 'create_row')

                                <div class="mb-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        Tambah Data
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                                    @foreach($change->after_json['data_json'] ?? [] as $field => $value)

                                        <div>
                                            <div class="text-xs text-slate-500">
                                                {{ $field }}
                                            </div>

                                            <div class="font-medium text-slate-800">
                                                {{ $value ?: '-' }}
                                            </div>
                                        </div>

                                    @endforeach

                                </div>

                            @endif


                            {{-- UPDATE --}}
                            @if($change->action === 'update_row')

                                <div class="mb-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                        Ubah Data
                                    </span>
                                </div>

                                <div class="space-y-3">

                                    @foreach($change->after_json['data_json'] ?? [] as $field => $newValue)

                                        @php
                                            $oldValue = $change->before_json['data_json'][$field] ?? null;
                                        @endphp

                                        @if($oldValue != $newValue)

                                            <div class="border rounded-xl p-3">

                                                <div class="text-xs text-slate-500 mb-2">
                                                    {{ $field }}
                                                </div>

                                                <div class="flex flex-wrap items-center gap-3">

                                                    <span class="text-red-600 line-through">
                                                        {{ $oldValue ?: '-' }}
                                                    </span>

                                                    <span>
                                                        →
                                                    </span>

                                                    <span class="font-semibold text-green-600">
                                                        {{ $newValue ?: '-' }}
                                                    </span>

                                                </div>

                                            </div>

                                        @endif

                                    @endforeach

                                </div>

                            @endif


                            {{-- DELETE --}}
                            @if($change->action === 'delete_row')

                                <div class="mb-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        Hapus Data
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                                    @foreach($change->before_json['data_json'] ?? [] as $field => $value)

                                        <div>

                                            <div class="text-xs text-slate-500">
                                                {{ $field }}
                                            </div>

                                            <div class="font-medium text-red-600 line-through">
                                                {{ $value ?: '-' }}
                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @endif


                            {{-- UPDATE DATASET --}}
                            @if($change->action === 'update_dataset')

                                <div class="mb-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                        Ubah Informasi Dataset
                                    </span>
                                </div>

                                <div class="space-y-3">

                                    @foreach($change->after_json as $field => $newValue)

                                        @php
                                            $oldValue = $change->before_json[$field] ?? null;
                                        @endphp

                                        @if(json_encode($oldValue) != json_encode($newValue))

                                            <div class="border rounded-xl p-3">

                                                <div class="text-xs text-slate-500 mb-2">
                                                    {{ $field }}
                                                </div>

                                                <div class="text-sm">

                                                    <div class="text-red-600">
                                                        Lama:
                                                        {{ is_array($oldValue) ? json_encode($oldValue) : $oldValue }}
                                                    </div>

                                                    <div class="text-green-600 mt-1">
                                                        Baru:
                                                        {{ is_array($newValue) ? json_encode($newValue) : $newValue }}
                                                    </div>

                                                </div>

                                            </div>

                                        @endif

                                    @endforeach

                                </div>

                            @endif

                        </div>

                    @empty

                        <div class="px-6 py-16 text-center text-slate-500">
                            Tidak ada perubahan revisi
                        </div>

                    @endforelse

                </div>

            </div>

        @endif
    @endif

    @if($dataset->first_created != 'files')

        {{-- =========================================================
            STRUKTUR KOLOM
            ========================================================= --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-5 border-b border-slate-200">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div class="flex items-start gap-3">

                        {{-- ICON --}}
                        <div class="flex-shrink-0 w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 6h16M4 12h16M4 18h10"/>

                            </svg>

                        </div>


                        {{-- TITLE --}}
                        <div>

                            <h2 class="text-lg font-bold text-slate-800">
                                Struktur Dataset
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                {{ count($dataset->schema_json ?? []) }} kolom tersedia dalam dataset ini
                            </p>

                        </div>

                    </div>


                    {{-- INFO --}}
                    <div class="text-xs text-slate-400 flex items-center gap-2">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>

                        </svg>

                        <span>
                            Struktur kolom dataset
                        </span>

                    </div>

                </div>

            </div>


            {{-- TABLE --}}
            <div class="overflow-x-auto">

                {{-- 
                    Body table dibatasi agar card tidak terlalu panjang.
                    Header tabel tetap terlihat ketika body di-scroll.
                --}}
                <div class="max-h-[420px] overflow-y-auto custom-scrollbar">

                    <table class="min-w-full">

                        {{-- TABLE HEADER --}}
                        <thead class="sticky top-0 z-10 bg-slate-50 border-b border-slate-200">

                            <tr>

                                <th class="w-16 px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    #
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Nama Kolom
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Tipe Data
                                </th>

                            </tr>

                        </thead>


                        {{-- TABLE BODY --}}
                        <tbody class="divide-y divide-slate-100">

                            @forelse($dataset->schema_json ?? [] as $i => $column)

                                @php

                                    $name = is_array($column)
                                        ? ($column['name'] ?? '-')
                                        : $column;

                                    $type = is_array($column)
                                        ? ($column['type'] ?? 'text')
                                        : 'text';


                                    $typeConfig = match(strtolower($type)) {

                                        'number' => [
                                            'label' => 'Number',
                                            'class' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'icon' => '123'
                                        ],

                                        'date' => [
                                            'label' => 'Date',
                                            'class' => 'bg-violet-50 text-violet-700 border-violet-100',
                                            'icon' => 'DATE'
                                        ],

                                        default => [
                                            'label' => 'Text',
                                            'class' => 'bg-slate-50 text-slate-700 border-slate-200',
                                            'icon' => 'Aa'
                                        ]

                                    };

                                @endphp


                                <tr class="group hover:bg-slate-50/80 transition-colors duration-150">

                                    {{-- INDEX --}}
                                    <td class="px-6 py-4 text-center">

                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-500 text-xs font-semibold">

                                            {{ $i + 1 }}

                                        </span>

                                    </td>


                                    {{-- NAME --}}
                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="min-w-0">

                                                <div class="font-semibold text-slate-800 truncate max-w-md">

                                                    {{ $name }}

                                                </div>

                                                <div class="text-xs text-slate-400 mt-0.5">

                                                    Field #{{ $i + 1 }}

                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- TYPE --}}
                                    <td class="px-6 py-4">

                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border text-xs font-semibold {{ $typeConfig['class'] }}">

                                            <span class="font-mono text-[10px] opacity-70">

                                                {{ $typeConfig['icon'] }}

                                            </span>

                                            {{ $typeConfig['label'] }}

                                        </span>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="3"
                                        class="px-6 py-16 text-center">

                                        <div class="flex flex-col items-center">

                                            <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-4">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-7 h-7"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor">

                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.7"
                                                        d="M4 6h16M4 12h16M4 18h10"/>

                                                </svg>

                                            </div>

                                            <p class="font-semibold text-slate-700">

                                                Belum ada struktur kolom

                                            </p>

                                            <p class="text-sm text-slate-400 mt-1">

                                                Dataset ini belum memiliki kolom.

                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- FOOTER --}}
            @if(count($dataset->schema_json ?? []) > 0)

                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">

                    <div class="flex items-center justify-between gap-4">

                        <p class="text-xs text-slate-500">

                            <span class="font-semibold text-slate-600">
                                {{ count($dataset->schema_json ?? []) }}
                            </span>

                            kolom terdaftar dalam dataset.

                        </p>

                        <p class="hidden sm:block text-xs text-slate-400">

                            Struktur kolom hanya dapat ditinjau pada halaman approval.

                        </p>

                    </div>

                </div>

            @endif

        </div>

    @endif

    @if($dataset->first_created != 'files')

        {{-- =========================================================
            DATA DATASET
            ========================================================= --}}

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- CARD HEADER --}}
            <div class="px-6 py-5 border-b border-slate-200">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <div>

                        <div class="flex items-center gap-3">

                            {{-- ICON --}}
                            <div class="w-10 h-10 rounded-xl
                                bg-emerald-50
                                text-emerald-600
                                flex items-center justify-center">

                                <i class="fa-solid fa-table"></i>

                            </div>

                            {{-- TITLE --}}
                            <div>

                                <h2 class="text-xl font-bold text-slate-800">
                                    Data Dataset
                                </h2>

                                <p class="text-sm text-slate-500 mt-0.5">
                                    Data utama yang tersimpan dalam dataset.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- TOTAL DATA --}}
                    <div class="flex items-center gap-2">

                        <span class="inline-flex items-center gap-2
                            px-3 py-2
                            rounded-xl
                            bg-slate-50
                            border border-slate-200
                            text-sm
                            text-slate-600">

                            <i class="fa-solid fa-database text-slate-400"></i>

                            <span>
                                {{ $datasetData->count() }} data
                            </span>

                        </span>

                    </div>

                </div>

            </div>


            {{-- DATA TABLE --}}
            <div class="p-4">

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2">

                    <div class="bg-white rounded-xl overflow-hidden">

                        <table
                            id="datasetDataTable"
                            class="display nowrap w-full text-sm">

                            <thead>

                                <tr>

                                    @foreach($dataset->schema_json ?? [] as $column)

                                        <th>
                                            {{ $column['name'] ?? '-' }}
                                        </th>

                                    @endforeach

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($datasetData as $row)

                                    <tr>

                                        @foreach($dataset->schema_json ?? [] as $column)

                                            @php

                                                $field = $column['name'] ?? null;

                                                $value = $field
                                                    ? ($row->data_json[$field] ?? null)
                                                    : null;

                                            @endphp

                                            <td>

                                                @if($value === null || $value === '')

                                                    <span class="text-slate-400">
                                                        —
                                                    </span>

                                                @else

                                                    {{ $value }}

                                                @endif

                                            </td>

                                        @endforeach

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="{{ count($dataset->schema_json ?? []) }}"
                                            class="py-16 text-center">

                                            <div class="flex flex-col items-center justify-center">

                                                <div class="w-14 h-14 rounded-2xl
                                                    bg-slate-100
                                                    text-slate-400
                                                    flex items-center justify-center
                                                    mb-4">

                                                    <i class="fa-solid fa-database text-xl"></i>

                                                </div>

                                                <div class="font-semibold text-slate-700">
                                                    Belum ada data
                                                </div>

                                                <div class="text-sm text-slate-500 mt-1">
                                                    Dataset ini belum memiliki data.
                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    @endif

    {{-- =========================================================
        RIWAYAT APPROVAL
        ========================================================= --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- HEADER --}}
        <div class="px-6 py-5 border-b border-slate-200 bg-white">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>

                    <h2 class="text-xl font-bold text-slate-800">
                        Riwayat Approval
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Seluruh aktivitas approval dataset
                    </p>

                </div>

                {{-- JUMLAH LOG --}}
                <div class="inline-flex items-center gap-2
                            px-3 py-2
                            rounded-xl
                            bg-slate-50
                            border border-slate-200
                            text-sm text-slate-600">

                    <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>

                    <span>
                        {{ $dataset->approvalLogs->count() }} aktivitas
                    </span>

                </div>

            </div>

        </div>


        {{-- SCROLL AREA --}}
        <div class="max-h-[420px] overflow-y-auto custom-scrollbar">

            <div class="divide-y divide-slate-100">

                @forelse($dataset->approvalLogs as $log)

                    @php
                        $badge = match($log->action) {
                            'submit' => 'bg-blue-100 text-blue-700',
                            'approve' => 'bg-green-100 text-green-700',
                            'reject' => 'bg-red-100 text-red-700',
                            'submit_update' => 'bg-indigo-100 text-indigo-700',
                            'approve_update' => 'bg-emerald-100 text-emerald-700',
                            'reject_update' => 'bg-orange-100 text-orange-700',
                            default => 'bg-slate-100 text-slate-700',
                        };

                        $icon = match($log->action) {
                            'submit' => 'fa-paper-plane',
                            'approve' => 'fa-circle-check',
                            'reject' => 'fa-circle-xmark',
                            'submit_update' => 'fa-pen-to-square',
                            'approve_update' => 'fa-check-double',
                            'reject_update' => 'fa-ban',
                            default => 'fa-clock',
                        };
                    @endphp


                    {{-- LOG ITEM --}}
                    <div class="px-6 py-5
                                hover:bg-slate-50/70
                                transition-colors duration-150">

                        <div class="flex flex-col lg:flex-row
                                    lg:items-start
                                    lg:justify-between
                                    gap-4">

                            {{-- LEFT --}}
                            <div class="min-w-0">

                                <div class="flex items-center gap-3 flex-wrap">

                                    {{-- ICON --}}
                                    <div class="w-9 h-9
                                                rounded-xl
                                                flex items-center justify-center
                                                {{ $badge }}">

                                        <i class="fa-solid {{ $icon }} text-sm"></i>

                                    </div>


                                    {{-- ACTION --}}
                                    <span class="px-3 py-1
                                                rounded-full
                                                text-xs
                                                font-semibold
                                                capitalize
                                                {{ $badge }}">

                                        {{ str_replace('_', ' ', $log->action) }}

                                    </span>


                                    {{-- DATE --}}
                                    <span class="text-sm text-slate-500">

                                        {{ $log->created_at->format('d M Y H:i') }}

                                    </span>

                                </div>


                                {{-- CATATAN --}}
                                @if($log->catatan)

                                    <div class="mt-3
                                                ml-0 lg:ml-12
                                                text-sm
                                                text-slate-700
                                                bg-slate-50
                                                border border-slate-200
                                                rounded-xl
                                                px-4 py-3">

                                        <div class="text-xs
                                                    font-semibold
                                                    text-slate-400
                                                    uppercase
                                                    tracking-wide
                                                    mb-1">

                                            Catatan

                                        </div>

                                        {{ $log->catatan }}

                                    </div>

                                @endif

                            </div>


                            {{-- USER --}}
                            <div class="flex items-center gap-2
                                        text-sm text-slate-500
                                        whitespace-nowrap
                                        lg:pt-1">

                                <i class="fa-solid fa-user text-slate-400"></i>

                                <span>
                                    {{ $log->user->nama ?? '-' }}
                                </span>

                            </div>

                        </div>

                    </div>


                @empty

                    {{-- EMPTY --}}
                    <div class="px-6 py-16 text-center text-slate-500">

                        <div class="flex flex-col items-center">

                            <div class="w-14 h-14
                                        rounded-2xl
                                        bg-slate-100
                                        text-slate-400
                                        flex items-center justify-center
                                        mb-4">

                                <i class="fa-solid fa-clock-rotate-left text-xl"></i>

                            </div>

                            <div class="font-semibold text-slate-700">
                                Belum ada riwayat approval
                            </div>

                            <div class="text-sm text-slate-400 mt-1">
                                Aktivitas approval dataset akan muncul di sini.
                            </div>

                        </div>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- FOOTER --}}
        @if($dataset->approvalLogs->count() > 0)

            <div class="px-6 py-3
                        bg-slate-50
                        border-t border-slate-200">

                <p class="text-xs text-slate-500">

                    Menampilkan
                    <span class="font-semibold text-slate-700">
                        {{ $dataset->approvalLogs->count() }}
                    </span>
                    aktivitas approval.

                </p>

            </div>

        @endif

    </div>


    {{-- BACK --}}
    <div class="flex justify-end">

        <a href="{{ route('admin.approval.index') }}"
           class="inline-flex items-center gap-2 rounded-2xl bg-slate-800 hover:bg-slate-900 px-5 py-3 text-sm font-medium text-white transition">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

</div>

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DATASET DATA TABLE
    |--------------------------------------------------------------------------
    */

    const table = $('#datasetDataTable');

    /*
    |--------------------------------------------------------------------------
    | Pastikan tabel memang ada
    |--------------------------------------------------------------------------
    */

    if (!table.length) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Hindari inisialisasi DataTables lebih dari satu kali
    |--------------------------------------------------------------------------
    */

    if ($.fn.DataTable.isDataTable('#datasetDataTable')) {
        table.DataTable().destroy();
    }


    /*
    |--------------------------------------------------------------------------
    | INIT DATATABLE
    |--------------------------------------------------------------------------
    */

    table.DataTable({

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        pageLength: 25,

        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Semua"]
        ],


        /*
        |--------------------------------------------------------------------------
        | SCROLL
        |--------------------------------------------------------------------------
        */

        scrollY: '420px',

        scrollX: true,

        scrollCollapse: true,


        /*
        |--------------------------------------------------------------------------
        | WIDTH
        |--------------------------------------------------------------------------
        */

        autoWidth: false,

        deferRender: true,


        /*
        |--------------------------------------------------------------------------
        | JANGAN GUNAKAN STATE SAVE
        |--------------------------------------------------------------------------
        */

        stateSave: false,


        /*
        |--------------------------------------------------------------------------
        | DEFAULT SORT
        |--------------------------------------------------------------------------
        */

        order: [],


        /*
        |--------------------------------------------------------------------------
        | LANGUAGE
        |--------------------------------------------------------------------------
        */

        language: {

            search: "",

            searchPlaceholder: "Cari data...",

            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

            infoEmpty: "Tidak ada data",

            infoFiltered: "(difilter dari _MAX_ total data)",

            zeroRecords: "Data tidak ditemukan",

            emptyTable: "Belum ada data dataset",

            paginate: {

                previous: "←",

                next: "→"

            }

        },


        /*
        |--------------------------------------------------------------------------
        | CALLBACK
        |--------------------------------------------------------------------------
        */

        initComplete: function () {

            const filter =
                $('#datasetDataTable_wrapper .dataTables_filter label');

            if (
                filter.length &&
                !filter.find('.fa-magnifying-glass').length
            ) {

                filter.prepend(
                    '<i class="fa-solid fa-magnifying-glass text-slate-400 mr-2"></i>'
                );

            }

        }

    });
});

</script>

@endpush

@endsection