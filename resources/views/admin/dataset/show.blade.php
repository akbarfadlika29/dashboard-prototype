@extends('layouts.admin')

@push('styles')

<link rel="stylesheet"
    href="https://cdn.datatables.net/1.13.11/css/jquery.dataTables.min.css">

<style>

/* =========================================================
   DATASET DATA TABLE
   ========================================================= */

#datasetTable_wrapper {
    padding: 0 16px 16px;
}

/* Header */

#datasetTable.dataTable thead th {

    background: #f8fafc !important;

    color: #334155;

    font-size: 12px;

    text-transform: uppercase;

    letter-spacing: .5px;

    font-weight: 700;

    border-bottom: 1px solid #e2e8f0 !important;

}

/* Cell */

#datasetTable.dataTable tbody td {

    white-space: nowrap;

    padding: 12px 16px;

    vertical-align: middle;

}

#datasetTable.dataTable thead th {

    padding: 14px 16px;

}

/* Row */

#datasetTable.dataTable tbody tr {

    transition: background-color .15s ease;

}

#datasetTable.dataTable tbody tr:hover {

    background: #f0fdf4 !important;

}

#datasetTable.dataTable tbody tr:nth-child(even) {

    background: #fcfcfd;

}

/* Scroll */

#datasetTable_wrapper div.dt-scroll-body {

    max-height: 420px !important;

}

#datasetTable_wrapper .dataTables_scrollBody {

    max-height: 420px !important;

}

#datasetTable_wrapper .dataTables_scrollBody::-webkit-scrollbar {

    width: 10px;

    height: 10px;

}

#datasetTable_wrapper .dataTables_scrollBody::-webkit-scrollbar-thumb {

    background: #94a3b8;

    border-radius: 20px;

}

#datasetTable_wrapper .dataTables_scrollBody::-webkit-scrollbar-track {

    background: #f1f5f9;

}

/* Toolbar */

#datasetTable_wrapper .dataTables_length,
#datasetTable_wrapper .dataTables_filter {

    margin-top: 16px;

    margin-bottom: 18px;

    padding: 14px 18px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    border-radius: 14px;

    font-size: .9rem;

}

/* Search */

#datasetTable_wrapper .dataTables_filter input {

    width: 240px;

    height: 42px;

    border: 1px solid #cbd5e1;

    border-radius: 10px;

    padding: 0 14px;

    outline: none;

    transition: all .2s ease;

}

#datasetTable_wrapper .dataTables_filter input:focus {

    border-color: #10b981;

    box-shadow: 0 0 0 4px rgb(16 185 129 / .15);

}

/* Length */

#datasetTable_wrapper .dataTables_length select {

    height: 42px;

    border: 1px solid #cbd5e1;

    border-radius: 10px;

    padding: 0 14px;

    outline: none;

}

/* Pagination */

#datasetTable_wrapper .dataTables_paginate {

    margin-top: 18px;

}

#datasetTable_wrapper .paginate_button {

    min-width: 38px;

    height: 38px;

    line-height: 26px;

    padding: 6px 12px !important;

    border-radius: 10px !important;

    transition: all .2s ease;

}

#datasetTable_wrapper .dataTables_paginate .paginate_button.current,
#datasetTable_wrapper .dataTables_paginate .paginate_button.current:hover {

    background: #059669 !important;

    border: 1px solid #059669 !important;

    color: #ffffff !important;

    font-weight: 700;

    box-shadow: 0 4px 12px rgba(5, 150, 105, .25);

}

#datasetTable_wrapper .paginate_button:not(.current):hover {

    background: #f1f5f9 !important;

    border: 1px solid #cbd5e1 !important;

    color: #334155 !important;

}

/* Info */

#datasetTable_wrapper .dataTables_info,
#datasetTable_wrapper .dataTables_paginate {

    padding-top: 18px;

    margin-top: 18px;

    border-top: 1px solid #e2e8f0;

    color: #64748b;

}

/* Processing */

#datasetTable_wrapper .dataTables_processing {

    border-radius: 12px;

    padding: 18px;

    background: white;

    box-shadow: 0 10px 25px rgba(0,0,0,.1);

}

/* Action column */

.dataset-action {

    display: inline-flex;

    align-items: center;

    justify-content: flex-end;

    gap: 6px;

}

.dataset-action button {

    width: 36px;

    height: 36px;

    border-radius: 10px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    transition: all .2s ease;

}

.dataset-edit-btn {

    color: #d97706;

    background: #fffbeb;

    border: 1px solid #fde68a;

}

.dataset-edit-btn:hover {

    background: #fef3c7;

    border-color: #fbbf24;

    transform: translateY(-1px);

}

.dataset-delete-btn {

    color: #dc2626;

    background: #fef2f2;

    border: 1px solid #fecaca;

}

.dataset-delete-btn:hover {

    background: #fee2e2;

    border-color: #fca5a5;

    transform: translateY(-1px);

}

/* Empty state */

.dataset-empty {

    padding: 50px 20px;

    text-align: center;

    color: #64748b;

}

</style>

@endpush

@section('title', $dataset->nama)

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
   ACTION BUTTON
   ========================================================= */

.dataset-action-btn {

    width: 36px;

    height: 36px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    transition: all .2s ease;

}

.dataset-action-btn:hover {

    transform: translateY(-1px);

}

/* =========================================================
   MODAL
   ========================================================= */

.dataset-modal-backdrop {

    background:
        rgba(15, 23, 42, .55);

    backdrop-filter: blur(4px);

}

.dataset-modal {

    animation:
        datasetModalIn .2s ease-out;

}

@keyframes datasetModalIn {

    from {

        opacity: 0;

        transform:
            translateY(10px)
            scale(.98);

    }

    to {

        opacity: 1;

        transform:
            translateY(0)
            scale(1);

    }

}

/* =========================================================
   FORM INPUT
   ========================================================= */

.dataset-form-input {

    width: 100%;

    border: 2px solid #e2e8f0;

    border-radius: 12px;

    padding: 11px 14px;

    font-size: .875rem;

    color: #334155;

    background: #fff;

    outline: none;

    transition: all .2s ease;

}

.dataset-form-input:hover {

    border-color: #cbd5e1;

}

.dataset-form-input:focus {

    border-color: #10b981;

    box-shadow:
        0 0 0 4px rgb(16 185 129 / .12);

}

</style>

@endpush

@section('content')

@php
    $revision = $dataset->activeRevision;
    $canEdit = $dataset->canEdit();
    $displayData = $dataset->displayData();

    $canModify =
        ($canEdit && !$revision)
        || $revision?->status === 'draft';

    function datasetStatusConfig($dataset)
    {
        if ($dataset->activeRevision && $dataset->activeRevision->status === 'pending') {
            return [
                'label' => 'Pending Revision',
                'class' => 'bg-amber-100 text-amber-700'
            ];
        }

        return match($dataset->status) {

            'draft' => [
                'label' => 'Draft',
                'class' => 'bg-slate-100 text-slate-700'
            ],

            'pending' => [
                'label' => 'Pending Publish',
                'class' => 'bg-blue-100 text-blue-700'
            ],

            'published' => [
                'label' => 'Published',
                'class' => 'bg-green-100 text-green-700'
            ],

            'rejected' => [
                'label' => 'Rejected',
                'class' => 'bg-red-100 text-red-700'
            ],

            default => [
                'label' => ucfirst($dataset->status),
                'class' => 'bg-slate-100 text-slate-700'
            ]
        };
    }

    $status = datasetStatusConfig($dataset);

    $schema = $revision?->schema_json ?? $dataset->schema_json ?? [];
    $columns = $revision?->kolom ?? $dataset->kolom ?? [];
    $totalChanges = $revision?->changes?->count() ?? 0;
@endphp

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- ================= HEADER ================= --}}
        <div class="bg-gradient-to-r from-white to-slate-50 rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="p-8">

                <div class="flex flex-col xl:flex-row xl:justify-between gap-8">

                    <div class="flex-1">

                        <div class="flex flex-wrap items-center gap-3">

                            <h1 class="text-3xl font-bold text-slate-800">
                                {{ $dataset->nama }}
                            </h1>

                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>

                        </div>

                        @if($dataset->deskripsi)

                            <p class="mt-4 max-w-4xl text-slate-600 leading-relaxed">
                                {{ $dataset->deskripsi }}
                            </p>

                        @endif

                        <div class="mt-6 flex flex-wrap gap-x-8 gap-y-3 text-sm">

                            <div>
                                <div class="text-slate-400">
                                    Kategori
                                </div>

                                <div class="font-semibold text-slate-700">
                                    {{ $dataset->kategori->nama ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-slate-400">
                                    Seksi
                                </div>

                                <div class="font-semibold text-slate-700">
                                    {{ $dataset->seksi->nama ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-slate-400">
                                    Dibuat
                                </div>

                                <div class="font-semibold text-slate-700">
                                    {{ $dataset->created_at->format('d M Y H:i') }}
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="flex flex-wrap gap-3 items-start">

                        {{-- Submit --}}
                        @if ($canEdit && $dataset->count_approved === 0)

                            <form method="POST"
                                action="{{ route('dataset.submit', $dataset) }}"
                                onsubmit="submitButton(this)">

                                @csrf

                                <button
                                    type="submit"
                                    class="submit-btn inline-flex items-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 font-medium transition disabled:opacity-60 disabled:cursor-not-allowed">

                                    <svg class="submit-spinner hidden animate-spin h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24">

                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"/>

                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>

                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="submit-icon w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 4v16h16"/>

                                    </svg>

                                    <span>

                                        @if($dataset->status=='draft')
                                            Ajukan Dataset
                                        @else
                                            Ajukan Kembali
                                        @endif

                                    </span>

                                </button>

                            </form>

                        @endif

                        @if(
                            ($canEdit &&
                            $dataset->hasDraftRevision() &&
                            $totalChanges > 0 &&
                            $dataset->count_approved > 0 &&
                            $dataset->activeRevision->status === 'draft')

                            ||

                            ($canEdit &&
                            $dataset->hasDraftRevision() &&
                            $dataset->count_approved > 0 &&
                            $dataset->activeRevision->status === 'draft' &&
                            $dataset->first_created === 'files')
                        )

                            <form method="POST"
                                action="{{ route('dataset.submit', $dataset) }}">

                                @csrf

                                <button
                                class="px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                                
                                Ajukan Revision
                                @if($dataset->first_created !== 'files')
                                    ({{ $totalChanges }} Perubahan)
                                @endif
                                
                            </button>
                            
                        </form>
                        
                        @endif

                        {{-- Delete --}}
                        @if($canEdit && ($dataset->status=='draft' || $dataset->status=='rejected'))

                            <form method="POST"
                                action="{{ route('dataset.destroy',$dataset) }}"
                                onsubmit="return confirmDelete(event,this)">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="delete-btn inline-flex items-center gap-2 rounded-xl border border-red-300 text-red-600 hover:bg-red-50 px-5 py-3 font-medium transition disabled:opacity-60">

                                    <svg class="delete-spinner hidden animate-spin h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24">

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                            class="opacity-25"/>

                                        <path
                                            fill="currentColor"
                                            class="opacity-75"
                                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>

                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="delete-icon w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7L5 7M10 11v6m4-6v6M6 7l1-2h10l1 2"/>

                                    </svg>

                                    Hapus Dataset

                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Statistic --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 border-t border-slate-200 bg-slate-50">

                <div class="p-5">

                    <div class="text-sm text-slate-500">
                        Jumlah Data
                    </div>

                    <div class="mt-1 text-3xl font-bold text-slate-800">
                        {{ $displayData->count() }}
                    </div>

                </div>

                <div class="p-5 border-l border-slate-200">

                    <div class="text-sm text-slate-500">
                        Jumlah Kolom
                    </div>

                    <div class="mt-1 text-3xl font-bold text-slate-800">
                        {{ count($columns) }}
                    </div>

                </div>

                <div class="p-5 border-l border-slate-200">

                    <div class="text-sm text-slate-500">
                        Filter
                    </div>

                    <div class="mt-1 text-3xl font-bold text-slate-800">
                        {{ $dataset->filters->count() }}
                    </div>

                </div>

                <div class="p-5 border-l border-slate-200">

                    <div class="text-sm text-slate-500">
                        Revision
                    </div>

                    <div class="mt-1 text-3xl font-bold text-slate-800">
                        {{ $revision ? $totalChanges : 0 }}
                    </div>

                </div>

            </div>

        </div>
        
        @if($dataset->first_created === 'files')
        
            @include('admin.dataset.partials.show-files')
        
        @else
        {{-- REVISION INFO --}}
        @if($revision)

        @php

        $createCount = $revision->changes
            ->where('action','create_row')
            ->count();

        $updateCount = $revision->changes
            ->where('action','update_row')
            ->count();

        $deleteCount = $revision->changes
            ->where('action','delete_row')
            ->count();

        $datasetUpdate = $revision->changes
            ->where('action','update_dataset')
            ->count();

        @endphp

        <div class="grid md:grid-cols-4 gap-4">

            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">

                <div class="text-sm text-blue-600">
                    Update Dataset
                </div>

                <div class="text-2xl font-bold text-blue-700">
                    {{ $datasetUpdate }}
                </div>

            </div>

            <div class="bg-green-50 border border-green-200 rounded-2xl p-4">

                <div class="text-sm text-green-600">
                    Tambah Data
                </div>

                <div class="text-2xl font-bold text-green-700">
                    {{ $createCount }}
                </div>

            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">

                <div class="text-sm text-amber-600">
                    Ubah Data
                </div>

                <div class="text-2xl font-bold text-amber-700">
                    {{ $updateCount }}
                </div>

            </div>

            <div class="bg-red-50 border border-red-200 rounded-2xl p-4">

                <div class="text-sm text-red-600">
                    Hapus Data
                </div>

                <div class="text-2xl font-bold text-red-700">
                    {{ $deleteCount }}
                </div>

            </div>

        </div>

        @endif
        @if($revision)

            <div class="bg-amber-50 border border-amber-200 rounded-3xl p-5">

                <div class="flex items-start justify-between gap-5">

                    <div>

                        <h2 class="text-lg font-semibold text-amber-800">
                            Revision Aktif
                        </h2>

                        <p class="text-sm text-amber-700 mt-1">
                            Dataset ini memiliki revision dengan status:
                            <strong>{{ ucfirst($revision->status) }}</strong>
                        </p>

                        <p class="text-sm text-amber-700 mt-1">
                            Total perubahan:
                            <strong>{{ $totalChanges }}</strong>
                        </p>

                    </div>

                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                        {{ ucfirst($revision->status) }}
                    </span>

                </div>

            </div>

        @endif

        @if($revision)

        @php
        $datasetChange = $revision->changes
            ->firstWhere('action','update_dataset');
        @endphp

        @if($datasetChange)

        <div class="bg-white rounded-3xl border border-blue-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 bg-blue-50 border-b border-blue-200">

                <h2 class="text-xl font-bold text-blue-800">
                    Draft Perubahan Dataset
                </h2>

            </div>

            <div class="p-6">

                @foreach($datasetChange->after_json as $field => $newValue)

                    @php
                        $oldValue =
                            $datasetChange->before_json[$field] ?? null;
                    @endphp

                    @if($oldValue != $newValue)

                        <div class="mb-5">

                            <div class="font-semibold text-slate-700 mb-2">
                                {{ ucfirst($field) }}
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">

                                <div class="rounded-xl bg-red-50 p-4">

                                    <div class="text-xs text-red-500 mb-1">
                                        Sebelum
                                    </div>

                                    <div>
                                        {{ is_array($oldValue) ? json_encode($oldValue, JSON_PRETTY_PRINT) : $oldValue }}
                                    </div>

                                </div>

                                <div class="rounded-xl bg-green-50 p-4">

                                    <div class="text-xs text-green-500 mb-1">
                                        Sesudah
                                    </div>

                                    <div>
                                        {{ is_array($newValue) ? json_encode($newValue, JSON_PRETTY_PRINT) : $newValue }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>

        </div>

        @endif
        @endif

        @if($revision)

        <div class="bg-white rounded-3xl border border-amber-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 bg-amber-50 border-b border-amber-200">

                <h2 class="text-xl font-bold text-amber-800">
                    Draft Perubahan Data
                </h2>

            </div>

            <div class="divide-y divide-slate-200">

                @foreach($revision->changes as $change)

                    @if(in_array($change->action,[
                        'create_row',
                        'update_row',
                        'delete_row'
                    ]))

                        <div class="p-6">

                            <div class="mb-4">

                                @switch($change->action)

                                    @case('create_row')
                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                            DATA BARU
                                        </span>
                                    @break

                                    @case('update_row')
                                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                            DATA DIUBAH
                                        </span>
                                    @break

                                    @case('delete_row')
                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                            DATA DIHAPUS
                                        </span>
                                    @break

                                @endswitch

                            </div>

                            {{-- CREATE --}}
                            @if($change->action == 'create_row')

                                <div class="overflow-x-auto">

                                    <table class="min-w-full text-sm">

                                        <tbody>

                                            @foreach($change->after_json['data_json'] as $field => $value)

                                                <tr class="border-b">

                                                    <td class="py-2 font-medium text-slate-700 w-64">
                                                        {{ $field }}
                                                    </td>

                                                    <td class="py-2 text-green-700">
                                                        {{ $value }}
                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            @endif

                            {{-- DELETE --}}
                            @if($change->action == 'delete_row')

                                <div class="overflow-x-auto">

                                    <table class="min-w-full text-sm">

                                        <tbody>

                                            @foreach($change->before_json['data_json'] as $field => $value)

                                                <tr class="border-b">

                                                    <td class="py-2 font-medium text-slate-700 w-64">
                                                        {{ $field }}
                                                    </td>

                                                    <td class="py-2 text-red-700">
                                                        {{ $value }}
                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            @endif

                            {{-- UPDATE --}}
                            @if($change->action == 'update_row')

                                <div class="overflow-x-auto">

                                    <table class="min-w-full text-sm">

                                        <thead>

                                            <tr>

                                                <th class="text-left py-2">
                                                    Kolom
                                                </th>

                                                <th class="text-left py-2">
                                                    Sebelum
                                                </th>

                                                <th class="text-left py-2">
                                                    Sesudah
                                                </th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($change->after_json['data_json'] as $field => $value)

                                                @php
                                                    $old =
                                                        $change->before_json['data_json'][$field] ?? null;
                                                @endphp

                                                @if($old != $value)

                                                    <tr>

                                                        <td class="py-2 font-medium">
                                                            {{ $field }}
                                                        </td>

                                                        <td class="py-2 text-red-600">
                                                            {{ $old }}
                                                        </td>

                                                        <td class="py-2 text-green-600">
                                                            {{ $value }}
                                                        </td>

                                                    </tr>

                                                @endif

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            @endif

                        </div>

                    @endif

                @endforeach

            </div>

        </div>

        @endif
        
        {{-- STRUKTUR KOLOM --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-5 border-b border-slate-200">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div class="flex items-start gap-3">

                        {{-- Icon --}}
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

                        <div>

                            <h2 class="text-lg font-bold text-slate-800">
                                Struktur Dataset
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                {{ count($schema) }} kolom tersedia dalam dataset ini
                            </p>

                        </div>

                    </div>

                    @if($canModify)

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
                                Gunakan aksi pada setiap kolom untuk mengubah struktur
                            </span>

                        </div>

                    @endif

                </div>

            </div>


            {{-- TABLE --}}
            <div class="overflow-x-auto">

                {{-- 
                    max-height dibuat statis agar card tidak terlalu panjang.
                    Header tetap berada di atas ketika body di-scroll.
                --}}
                <div class="max-h-[420px] overflow-y-auto custom-scrollbar">

                    <table class="min-w-full">

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

                                @if($canModify)

                                    <th class="w-32 px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Aksi
                                    </th>

                                @endif

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse($schema as $i => $column)

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


                                    {{-- ACTION --}}
                                    @if($canModify)

                                        <td class="px-6 py-4">

                                            <div class="flex items-center justify-end gap-2">

                                                {{-- EDIT --}}
                                                <button
                                                    type="button"
                                                    onclick="openColumnEditModal({{ $i }})"
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition"
                                                    title="Edit kolom">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="1.8">

                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 15.07a4.5 4.5 0 01-1.897 1.13L6 17l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>

                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M19.5 7.125L16.875 4.5"/>

                                                    </svg>

                                                </button>


                                                {{-- DELETE --}}
                                                <button
                                                    type="button"
                                                    onclick="openColumnDeleteModal({{ $i }})"
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition"
                                                    title="Hapus kolom">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="1.8">

                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M6 7h12M10 11v6M14 11v6M8 7l1-2h6l1 2m2 0v11a2 2 0 01-2 2H8a2 2 0 01-2-2V7"/>

                                                    </svg>

                                                </button>

                                            </div>

                                        </td>

                                    @endif

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="{{ $canModify ? 4 : 3 }}"
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
            @if($canModify && count($schema) > 0)

                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">

                    <div class="flex items-center justify-between gap-4">

                        <p class="text-xs text-slate-500">

                            <span class="font-semibold text-slate-600">
                                {{ count($schema) }}
                            </span>

                            kolom terdaftar dalam dataset.

                        </p>

                        <p class="hidden sm:block text-xs text-slate-400">
                            Perubahan struktur akan membuat dataset kembali ke status Draft.
                        </p>

                    </div>

                </div>

            @endif

        </div>

        {{-- =========================================================
            MODAL EDIT KOLOM
        ========================================================= --}}
        @if($canModify)

        <div id="columnEditModal"
            class="fixed inset-0 z-[100] hidden"
            aria-labelledby="columnEditModalTitle"
            aria-modal="true"
            role="dialog">

            {{-- BACKDROP --}}
            <div
                class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                onclick="closeColumnEditModal()">
            </div>


            {{-- MODAL WRAPPER --}}
            <div class="relative min-h-screen flex items-center justify-center p-4">

                <div
                    class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

                    {{-- HEADER --}}
                    <div class="px-6 py-5 border-b border-slate-200">

                        <div class="flex items-start justify-between gap-4">

                            <div class="flex items-start gap-3">

                                <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 15.07a4.5 4.5 0 01-1.897 1.13L6 17l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19.5 7.125L16.875 4.5"/>

                                    </svg>

                                </div>

                                <div>

                                    <h3 id="columnEditModalTitle"
                                        class="text-lg font-bold text-slate-800">

                                        Edit Kolom

                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">

                                        Ubah nama kolom dataset.

                                    </p>

                                </div>

                            </div>


                            <button
                                type="button"
                                onclick="closeColumnEditModal()"
                                class="w-9 h-9 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 mx-auto"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"/>

                                </svg>

                            </button>

                        </div>

                    </div>


                    {{-- FORM --}}
                    <form
                        id="columnEditForm"
                        method="POST">

                        @csrf
                        @method('PUT')

                        <div class="p-6 space-y-5">

                            {{-- CURRENT NAME --}}
                            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">

                                <div class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                    Kolom yang dipilih
                                </div>

                                <div
                                    id="columnEditCurrentName"
                                    class="mt-1 font-semibold text-slate-700 break-words">
                                    -
                                </div>

                            </div>


                            {{-- NEW NAME --}}
                            <div>

                                <label
                                    for="columnEditLabel"
                                    class="block text-sm font-semibold text-slate-700 mb-2">

                                    Nama Kolom Baru

                                    <span class="text-red-500">*</span>

                                </label>

                                <input
                                    type="text"
                                    id="columnEditLabel"
                                    name="label"
                                    required
                                    autocomplete="off"
                                    class="w-full h-12 rounded-2xl border border-slate-300 bg-white px-4 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition"
                                    placeholder="Contoh: Jumlah Penduduk">

                                <p class="text-xs text-slate-400 mt-2">

                                    Gunakan nama kolom yang jelas dan mudah dipahami.

                                </p>

                            </div>


                            {{-- WARNING --}}
                            <div class="flex items-start gap-3 rounded-2xl bg-amber-50 border border-amber-200 p-4">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v3.75m0 3.75h.008M10.29 3.86l-7.04 12.2A1.75 1.75 0 004.77 18.7h14.46a1.75 1.75 0 001.515-2.64l-7.04-12.2a1.75 1.75 0 00-3.03 0z"/>

                                </svg>

                                <div class="text-sm text-amber-800">

                                    <div class="font-semibold">
                                        Perhatian
                                    </div>

                                    <p class="mt-1 text-amber-700 leading-relaxed">

                                        Mengubah nama kolom juga akan memperbarui data yang menggunakan kolom tersebut.

                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- FOOTER --}}
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">

                            <button
                                type="button"
                                onclick="closeColumnEditModal()"
                                class="h-11 px-5 rounded-xl border border-slate-300 bg-white text-slate-600 hover:bg-slate-100 text-sm font-semibold transition">

                                Batal

                            </button>


                            <button
                                type="submit"
                                id="columnEditSubmitButton"
                                class="inline-flex items-center gap-2 h-11 px-5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition disabled:opacity-60 disabled:cursor-not-allowed">

                                <svg
                                    id="columnEditSpinner"
                                    class="hidden animate-spin w-4 h-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24">

                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"/>

                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>

                                </svg>

                                <span id="columnEditSubmitText">
                                    Simpan Perubahan
                                </span>

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
        {{-- =========================================================
            MODAL KONFIRMASI HAPUS KOLOM
        ========================================================= --}}
        <div id="columnDeleteModal"
            class="fixed inset-0 z-[110] hidden"
            aria-labelledby="columnDeleteModalTitle"
            aria-modal="true"
            role="dialog">

            {{-- BACKDROP --}}
            <div
                class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                onclick="closeColumnDeleteModal()">
            </div>


            {{-- MODAL --}}
            <div class="relative min-h-screen flex items-center justify-center p-4">

                <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

                    <div class="p-6">

                        {{-- ICON --}}
                        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mb-5">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M6 7h12M10 11v6M14 11v6M8 7l1-2h6l1 2m2 0v11a2 2 0 01-2 2H8a2 2 0 01-2-2V7"/>

                            </svg>

                        </div>


                        <h3 id="columnDeleteModalTitle"
                            class="text-xl font-bold text-slate-800">

                            Hapus Kolom?

                        </h3>


                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">

                            Anda akan menghapus kolom:

                        </p>


                        <div class="mt-4 rounded-2xl bg-red-50 border border-red-100 px-4 py-3">

                            <div
                                id="columnDeleteName"
                                class="font-semibold text-red-700 break-words">

                                -

                            </div>

                        </div>


                        <div class="mt-4 text-sm text-slate-500 leading-relaxed">

                            Tindakan ini dapat memengaruhi struktur dataset dan data yang menggunakan kolom tersebut.

                            <span class="font-semibold text-slate-700">
                                Pastikan Anda benar-benar ingin melanjutkan.
                            </span>

                        </div>

                    </div>


                    {{-- FOOTER --}}
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">

                        <button
                            type="button"
                            onclick="closeColumnDeleteModal()"
                            class="h-11 px-5 rounded-xl border border-slate-300 bg-white text-slate-600 hover:bg-slate-100 text-sm font-semibold transition">

                            Batal

                        </button>


                        <form
                            id="columnDeleteForm"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                id="columnDeleteSubmitButton"
                                class="inline-flex items-center gap-2 h-11 px-5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition disabled:opacity-60 disabled:cursor-not-allowed">

                                <svg
                                    id="columnDeleteSpinner"
                                    class="hidden animate-spin w-4 h-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24">

                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"/>

                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>

                                </svg>

                                <span id="columnDeleteSubmitText">
                                    Ya, Hapus Kolom
                                </span>

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>
        @endif

        {{-- =========================================================
            DATA DATASET
            ========================================================= --}}

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- CARD HEADER --}}
            <div class="px-6 py-5 border-b border-slate-200">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <div>

                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-xl
                                bg-emerald-50
                                text-emerald-600
                                flex items-center justify-center">

                                <i class="fa-solid fa-table"></i>

                            </div>

                            <div>

                                <h2 class="text-xl font-bold text-slate-800">
                                    Data Dataset
                                </h2>

                                <p class="text-sm text-slate-500 mt-0.5">
                                    Kelola data yang tersimpan dalam dataset.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- ADD DATA BUTTON --}}
                    @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

                        <button
                            type="button"
                            onclick="openAddDataModal()"
                            class="inline-flex items-center justify-center gap-2
                                px-5 py-2.5
                                rounded-xl
                                bg-emerald-600
                                hover:bg-emerald-700
                                text-white
                                text-sm
                                font-semibold
                                shadow-sm
                                hover:shadow-md
                                transition-all">

                            <i class="fa-solid fa-plus"></i>

                            Tambah Data Baru

                        </button>

                    @endif

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

                                    @foreach($columns as $column)

                                        <th>
                                            {{ $column['name'] ?? '-' }}
                                        </th>

                                    @endforeach

                                    @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

                                        <th>
                                            Aksi
                                        </th>

                                    @endif

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($data as $row)

                                    <tr>

                                        @foreach($columns as $column)

                                            @php
                                                $field = $column['name'];
                                                $value = $row->data_json[$field] ?? '';
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


                                        @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

                                            <td>

                                                <div class="flex items-center justify-end gap-2">

                                                    {{-- EDIT --}}
                                                    <button
                                                        type="button"
                                                        class="dataset-action-btn
                                                            bg-amber-50
                                                            text-amber-600
                                                            hover:bg-amber-100"
                                                        title="Edit data"
                                                        data-row-id="{{ $row->id }}"
                                                        onclick="openEditDataModal({{ Js::from($row) }})">

                                                        <i class="fa-solid fa-pen-to-square"></i>

                                                    </button>


                                                    {{-- DELETE --}}
                                                    <button
                                                        type="button"
                                                        class="dataset-action-btn
                                                            bg-red-50
                                                            text-red-600
                                                            hover:bg-red-100"
                                                        title="Hapus data"
                                                        data-row-id="{{ $row->id }}"
                                                        onclick="openDeleteDataModal({{ $row->id }})">

                                                        <i class="fa-solid fa-trash"></i>

                                                    </button>

                                                </div>

                                            </td>

                                        @endif

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="{{ count($columns) + (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft' ? 1 : 0) }}"
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

        {{-- =========================================================
            MODAL EDIT DATA
            ========================================================= --}}

        @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

        <div
            id="editDataModal"
            class="fixed inset-0 z-[100] hidden items-center justify-center p-4">

            {{-- BACKDROP --}}
            <div
                class="dataset-modal-backdrop absolute inset-0"
                onclick="closeEditDataModal()">
            </div>


            {{-- MODAL --}}
            <div
                class="dataset-modal relative w-full max-w-3xl
                    max-h-[90vh]
                    bg-white
                    rounded-3xl
                    shadow-2xl
                    overflow-hidden">

                {{-- HEADER --}}
                <div class="px-6 py-5 border-b border-slate-200">

                    <div class="flex items-start justify-between gap-4">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11 rounded-xl
                                bg-amber-50
                                text-amber-600
                                flex items-center justify-center">

                                <i class="fa-solid fa-pen-to-square"></i>

                            </div>

                            <div>

                                <h3 class="text-lg font-bold text-slate-800">
                                    Edit Data
                                </h3>

                                <p class="text-sm text-slate-500 mt-0.5">
                                    Perbarui informasi data dataset.
                                </p>

                            </div>

                        </div>


                        <button
                            type="button"
                            onclick="closeEditDataModal()"
                            class="w-9 h-9 rounded-xl
                                text-slate-400
                                hover:bg-slate-100
                                hover:text-slate-600
                                transition">

                            <i class="fa-solid fa-xmark"></i>

                        </button>

                    </div>

                </div>


                {{-- FORM --}}
                <form
                    id="editDataForm"
                    method="POST"
                    class="flex flex-col max-h-[calc(90vh-90px)]">

                    @csrf

                    @method('PUT')


                    {{-- BODY --}}
                    <div class="p-6 overflow-y-auto">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            @foreach($columns as $column)

                                @php
                                    $field = $column['name'];
                                    $type = $column['type'] ?? 'text';
                                @endphp

                                <div>

                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        {{ $field }}

                                    </label>

                                    <input
                                        type="{{ $type === 'number' ? 'number' : ($type === 'date' ? 'date' : 'text') }}"
                                        name="data[{{ $field }}]"
                                        id="edit_field_{{ $loop->index }}"
                                        data-field="{{ $field }}"
                                        class="dataset-form-input">

                                </div>

                            @endforeach

                        </div>

                    </div>


                    {{-- FOOTER --}}
                    <div class="px-6 py-4
                        border-t border-slate-200
                        bg-slate-50
                        flex items-center justify-end gap-3">

                        {{-- BATAL --}}
                        <button
                            type="button"
                            onclick="closeEditDataModal()"
                            class="inline-flex items-center gap-2
                                px-5 py-2.5
                                rounded-xl
                                border border-slate-300
                                bg-white
                                text-slate-700
                                text-sm
                                font-semibold
                                hover:bg-slate-50
                                transition">

                            Batal

                        </button>


                        {{-- SIMPAN --}}
                        <button
                            type="submit"
                            id="editDataSubmitButton"
                            class="inline-flex items-center justify-center gap-2
                                min-w-[170px]
                                px-5 py-2.5
                                rounded-xl
                                bg-emerald-600
                                hover:bg-emerald-700
                                text-white
                                text-sm
                                font-semibold
                                shadow-sm
                                hover:shadow-md
                                transition-all
                                duration-200">

                            {{-- ICON NORMAL --}}
                            <i
                                id="editDataSubmitIcon"
                                class="fa-solid fa-floppy-disk">
                            </i>


                            {{-- SPINNER --}}
                            <i
                                id="editDataSubmitSpinner"
                                class="fa-solid fa-spinner fa-spin hidden">
                            </i>


                            {{-- TEXT --}}
                            <span id="editDataSubmitText">
                                Simpan Perubahan
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>

        @endif

        {{-- =========================================================
            MODAL TAMBAH DATA
            ========================================================= --}}

        @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

        <div
            id="addDataModal"
            class="fixed inset-0 z-[100] hidden items-center justify-center p-4">

            {{-- BACKDROP --}}
            <div
                class="dataset-modal-backdrop absolute inset-0"
                onclick="closeAddDataModal()">
            </div>


            {{-- MODAL --}}
            <div
                class="dataset-modal relative w-full max-w-3xl
                    max-h-[90vh]
                    bg-white
                    rounded-3xl
                    shadow-2xl
                    overflow-hidden">

                {{-- HEADER --}}
                <div class="px-6 py-5 border-b border-slate-200">

                    <div class="flex items-start justify-between gap-4">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11 rounded-xl
                                bg-emerald-50
                                text-emerald-600
                                flex items-center justify-center">

                                <i class="fa-solid fa-plus"></i>

                            </div>

                            <div>

                                <h3 class="text-lg font-bold text-slate-800">
                                    Tambah Data Baru
                                </h3>

                                <p class="text-sm text-slate-500 mt-0.5">
                                    Masukkan data baru ke dalam dataset.
                                </p>

                            </div>

                        </div>


                        <button
                            type="button"
                            onclick="closeAddDataModal()"
                            class="w-9 h-9 rounded-xl
                                text-slate-400
                                hover:bg-slate-100
                                hover:text-slate-600
                                transition">

                            <i class="fa-solid fa-xmark"></i>

                        </button>

                    </div>

                </div>


                {{-- FORM --}}
                <form
                    method="POST"
                    action="{{ route('dataset.data.store', $dataset) }}"
                    class="flex flex-col max-h-[calc(90vh-90px)]">

                    @csrf


                    {{-- BODY --}}
                    <div class="p-6 overflow-y-auto">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            @foreach($columns as $column)

                                @php
                                    $field = $column['name'];
                                    $type = $column['type'] ?? 'text';
                                @endphp

                                <div>

                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        {{ $field }}

                                    </label>

                                    <input
                                        type="{{ $type === 'number' ? 'number' : ($type === 'date' ? 'date' : 'text') }}"
                                        name="data[{{ $field }}]"
                                        class="dataset-form-input"
                                        placeholder="Masukkan {{ strtolower($field) }}">

                                </div>

                            @endforeach

                        </div>

                    </div>


                    {{-- FOOTER --}}
                    <div class="px-6 py-4
                        border-t border-slate-200
                        bg-slate-50
                        flex items-center justify-end gap-3">

                        <button
                            type="button"
                            onclick="closeAddDataModal()"
                            class="inline-flex items-center gap-2
                                px-5 py-2.5
                                rounded-xl
                                border border-slate-300
                                bg-white
                                text-slate-700
                                text-sm
                                font-semibold
                                hover:bg-slate-50
                                transition">

                            Batal

                        </button>


                        <button
                            type="submit"
                            class="inline-flex items-center gap-2
                                px-5 py-2.5
                                rounded-xl
                                bg-emerald-600
                                hover:bg-emerald-700
                                text-white
                                text-sm
                                font-semibold
                                shadow-sm
                                transition">

                            <i class="fa-solid fa-plus"></i>

                            Tambahkan Data

                        </button>

                    </div>

                </form>

            </div>

        </div>

        @endif

        {{-- =========================================================
            MODAL KONFIRMASI DELETE
            ========================================================= --}}

        @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

        <div
            id="deleteDataModal"
            class="fixed inset-0 z-[110] hidden items-center justify-center p-4">

            {{-- BACKDROP --}}
            <div
                class="dataset-modal-backdrop absolute inset-0"
                onclick="closeDeleteDataModal()">
            </div>


            {{-- MODAL --}}
            <div
                class="dataset-modal relative w-full max-w-md
                    bg-white
                    rounded-3xl
                    shadow-2xl
                    overflow-hidden">

                <form
                    id="deleteDataForm"
                    method="POST">

                    @csrf

                    @method('DELETE')


                    <div class="p-6">

                        <div class="flex flex-col items-center text-center">

                            <div class="w-14 h-14 rounded-2xl
                                bg-red-50
                                text-red-600
                                flex items-center justify-center
                                mb-4">

                                <i class="fa-solid fa-trash text-xl"></i>

                            </div>


                            <h3 class="text-lg font-bold text-slate-800">

                                Hapus Data?

                            </h3>


                            <p class="text-sm text-slate-500 mt-2 leading-relaxed">

                                Data yang dihapus tidak dapat dikembalikan.
                                Apakah Anda yakin ingin menghapus data ini?

                            </p>

                        </div>

                    </div>


                    <div class="px-6 py-4
                        border-t border-slate-200
                        bg-slate-50
                        flex items-center justify-end gap-3">

                        <button
                            type="button"
                            onclick="closeDeleteDataModal()"
                            class="px-5 py-2.5
                                rounded-xl
                                border border-slate-300
                                bg-white
                                text-slate-700
                                text-sm
                                font-semibold
                                hover:bg-slate-50
                                transition">

                            Batal

                        </button>


                        <button
                            type="submit"
                            id="deleteDataSubmitButton"
                            class="inline-flex items-center justify-center gap-2
                                min-w-[150px]
                                px-5 py-2.5
                                rounded-xl
                                bg-red-600
                                hover:bg-red-700
                                text-white
                                text-sm
                                font-semibold
                                shadow-sm
                                hover:shadow-md
                                transition-all
                                duration-200">

                            {{-- ICON NORMAL --}}
                            <i
                                id="deleteDataSubmitIcon"
                                class="fa-solid fa-trash">
                            </i>


                            {{-- SPINNER --}}
                            <i
                                id="deleteDataSubmitSpinner"
                                class="fa-solid fa-spinner fa-spin hidden">
                            </i>


                            {{-- TEXT --}}
                            <span id="deleteDataSubmitText">
                                Ya, Hapus Data
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>

        @endif

        {{-- FILTER --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

            <div class="flex items-center justify-between mb-5">

                <div>

                    <h2 class="text-xl font-bold text-slate-800">
                        Filter Dataset
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ $dataset->filters->count() }} filter aktif
                    </p>

                </div>

            </div>

            @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

                <form method="POST"
                    action="{{ route('filters.store', $dataset) }}"
                    class="flex flex-col md:flex-row gap-3 mb-6">

                    @csrf

                    <select name="kolom"
                            class="flex-1 h-12 rounded-2xl border border-slate-300 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <option value="">
                            Pilih Kolom
                        </option>

                        @foreach($columns as $column)

                            <option value="{{ $column['name'] }}">
                                {{ $column['name'] }}
                            </option>

                        @endforeach

                    </select>

                    <button class="h-12 px-5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                        Tambah Filter
                    </button>

                </form>

            @endif

            <div class="space-y-3">

                @forelse($dataset->filters as $filter)

                    <div class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 hover:bg-slate-50 transition">

                        <div class="font-medium text-slate-700">
                            {{ $filter->kolom }}
                        </div>

                        @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

                            <form method="POST"
                                action="{{ route('filters.destroy', [$dataset, $filter]) }}"
                                onsubmit="return confirm('Hapus filter ini?')">

                                @csrf
                                @method('DELETE')

                                <button class="px-4 py-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 text-sm font-medium transition">
                                    Hapus
                                </button>

                            </form>

                        @endif

                    </div>

                @empty

                    <div class="rounded-2xl border border-dashed border-slate-300 py-12 text-center text-slate-500">

                        Belum ada filter.

                    </div>

                @endforelse

            </div>

        </div>

    </div>
@endif

@push('scripts')

<style>
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

<script>

    /*
    |--------------------------------------------------------------------------
    | DATA KOLOM
    |--------------------------------------------------------------------------
    */

    const datasetColumns = @json($schema);

    /*
    |--------------------------------------------------------------------------
    | MODAL EDIT KOLOM
    |--------------------------------------------------------------------------
    */

    const columnEditModal = document.getElementById('columnEditModal');
    const columnEditForm = document.getElementById('columnEditForm');
    const columnEditLabel = document.getElementById('columnEditLabel');
    const columnEditCurrentName = document.getElementById('columnEditCurrentName');

    const columnEditSubmitButton =
        document.getElementById('columnEditSubmitButton');

    const columnEditSpinner =
        document.getElementById('columnEditSpinner');

    const columnEditSubmitText =
        document.getElementById('columnEditSubmitText');


    function openColumnEditModal(index)
    {
        const column = datasetColumns[index];

        if (!column) {
            return;
        }

        const name = typeof column === 'object'
            ? (column.name ?? '')
            : column;

        /*
        |--------------------------------------------------------------------------
        | Set informasi kolom
        |--------------------------------------------------------------------------
        */

        columnEditCurrentName.textContent = name;

        columnEditLabel.value = name;

        /*
        |--------------------------------------------------------------------------
        | Generate action URL
        |--------------------------------------------------------------------------
        */

        const updateUrl =
            "{{ route('columns.update', [$dataset, '__INDEX__']) }}"
                .replace('__INDEX__', index);

        columnEditForm.action = updateUrl;


        /*
        |--------------------------------------------------------------------------
        | Reset button
        |--------------------------------------------------------------------------
        */

        columnEditSubmitButton.disabled = false;

        columnEditSpinner.classList.add('hidden');

        columnEditSubmitText.textContent = 'Simpan Perubahan';


        /*
        |--------------------------------------------------------------------------
        | Show modal
        |--------------------------------------------------------------------------
        */

        columnEditModal.classList.remove('hidden');

        document.body.classList.add('overflow-hidden');


        /*
        |--------------------------------------------------------------------------
        | Focus input
        |--------------------------------------------------------------------------
        */

        setTimeout(() => {

            columnEditLabel.focus();

            columnEditLabel.select();

        }, 100);
    }


    function closeColumnEditModal()
    {
        columnEditModal.classList.add('hidden');

        document.body.classList.remove('overflow-hidden');

        columnEditForm.reset();
    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT EDIT
    |--------------------------------------------------------------------------
    */

    columnEditForm?.addEventListener('submit', function () {

        columnEditSubmitButton.disabled = true;

        columnEditSpinner.classList.remove('hidden');

        columnEditSubmitText.textContent = 'Menyimpan...';

    });


    /*
    |--------------------------------------------------------------------------
    | MODAL DELETE KOLOM
    |--------------------------------------------------------------------------
    */

    const columnDeleteModal =
        document.getElementById('columnDeleteModal');

    const columnDeleteForm =
        document.getElementById('columnDeleteForm');

    const columnDeleteName =
        document.getElementById('columnDeleteName');

    const columnDeleteSubmitButton =
        document.getElementById('columnDeleteSubmitButton');

    const columnDeleteSpinner =
        document.getElementById('columnDeleteSpinner');

    const columnDeleteSubmitText =
        document.getElementById('columnDeleteSubmitText');


    function openColumnDeleteModal(index)
    {
        const column = datasetColumns[index];

        if (!column) {
            return;
        }

        const name = typeof column === 'object'
            ? (column.name ?? '')
            : column;


        /*
        |--------------------------------------------------------------------------
        | Set column name
        |--------------------------------------------------------------------------
        */

        columnDeleteName.textContent = name;


        /*
        |--------------------------------------------------------------------------
        | Generate delete URL
        |--------------------------------------------------------------------------
        */

        const deleteUrl =
            "{{ route('columns.destroy', [$dataset, '__INDEX__']) }}"
                .replace('__INDEX__', index);

        columnDeleteForm.action = deleteUrl;


        /*
        |--------------------------------------------------------------------------
        | Reset button
        |--------------------------------------------------------------------------
        */

        columnDeleteSubmitButton.disabled = false;

        columnDeleteSpinner.classList.add('hidden');

        columnDeleteSubmitText.textContent = 'Ya, Hapus Kolom';


        /*
        |--------------------------------------------------------------------------
        | Show modal
        |--------------------------------------------------------------------------
        */

        columnDeleteModal.classList.remove('hidden');

        document.body.classList.add('overflow-hidden');
    }


    function closeColumnDeleteModal()
    {
        columnDeleteModal.classList.add('hidden');

        document.body.classList.remove('overflow-hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT DELETE
    |--------------------------------------------------------------------------
    */

    columnDeleteForm?.addEventListener('submit', function () {

        columnDeleteSubmitButton.disabled = true;

        columnDeleteSpinner.classList.remove('hidden');

        columnDeleteSubmitText.textContent = 'Menghapus...';

    });


    /*
    |--------------------------------------------------------------------------
    | ESCAPE KEY
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        if (!columnEditModal.classList.contains('hidden')) {
            closeColumnEditModal();
        }

        if (!columnDeleteModal.classList.contains('hidden')) {
            closeColumnDeleteModal();
        }

    });


    /*
    |--------------------------------------------------------------------------
    | SUBMIT DATASET
    |--------------------------------------------------------------------------
    */

    function submitButton(form)
    {
        const button = form.querySelector('button');

        button.disabled = true;

        button.querySelector('.submit-spinner').classList.remove('hidden');

        button.querySelector('.submit-icon').classList.add('hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE DATASET
    |--------------------------------------------------------------------------
    */

    function confirmDelete(e, form)
    {
        e.preventDefault();

        if (!confirm('Yakin ingin menghapus dataset ini?')) {
            return false;
        }

        const button = form.querySelector('button');

        button.disabled = true;

        button.querySelector('.delete-spinner').classList.remove('hidden');

        button.querySelector('.delete-icon').classList.add('hidden');

        form.submit();

        return false;
    }

    /* =========================================================
    DATASET ROW DATA
    ========================================================= */


    /* =========================================================
    DATATABLE
    ========================================================= */

    document.addEventListener('DOMContentLoaded', function () {

        $(function () {

            $('#datasetDataTable').DataTable({

                pageLength: 25,

                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Semua"]
                ],

                scrollY: '420px',

                scrollX: true,

                scrollCollapse: true,

                fixedHeader: true,

                autoWidth: false,

                deferRender: true,

                stateSave: true,

                order: [],

                language: {

                    search: "",

                    searchPlaceholder: "Cari data...",

                    lengthMenu: "Tampilkan _MENU_ data",

                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                    infoEmpty: "Tidak ada data",

                    zeroRecords: "Data tidak ditemukan",

                    emptyTable: "Belum ada data dataset",

                    paginate: {

                        previous: "←",

                        next: "→"

                    }

                },

                columnDefs: [

                    {
                        targets: -1,

                        orderable: false,

                        searchable: false
                    }

                ],

                initComplete: function () {

                    $('.dataTables_filter label').prepend(
                        '<i class="fa-solid fa-magnifying-glass text-slate-400 mr-2"></i>'
                    );

                }

            });

        });

    });


    /* =========================================================
    ADD DATA MODAL
    ========================================================= */

    function openAddDataModal()
    {

        const modal =
            document.getElementById('addDataModal');

        if (!modal) return;

        modal.classList.remove('hidden');

        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

    }


    function closeAddDataModal()
    {

        const modal =
            document.getElementById('addDataModal');

        if (!modal) return;

        modal.classList.add('hidden');

        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');

    }


    /* =========================================================
    EDIT DATA MODAL
    ========================================================= */

    function openEditDataModal(row)
    {
        const modal =
            document.getElementById('editDataModal');

        const form =
            document.getElementById('editDataForm');

        if (!modal || !form) {
            console.error('Modal edit data tidak ditemukan.');
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Reset tombol submit
        |--------------------------------------------------------------------------
        */

        const submitButton =
            document.getElementById('editDataSubmitButton');

        const submitIcon =
            document.getElementById('editDataSubmitIcon');

        const submitSpinner =
            document.getElementById('editDataSubmitSpinner');

        const submitText =
            document.getElementById('editDataSubmitText');


        if (submitButton) {

            submitButton.disabled = false;

            submitButton.classList.remove(
                'bg-slate-400',
                'cursor-not-allowed',
                'shadow-none'
            );

            submitButton.classList.add(
                'bg-emerald-600',
                'hover:bg-emerald-700',
                'hover:shadow-md'
            );
        }


        if (submitIcon) {
            submitIcon.classList.remove('hidden');
        }


        if (submitSpinner) {
            submitSpinner.classList.add('hidden');
        }


        if (submitText) {
            submitText.textContent =
                'Simpan Perubahan';
        }


        /*
        |--------------------------------------------------------------------------
        | Validasi row
        |--------------------------------------------------------------------------
        */

        if (!row || !row.id) {

            console.error(
                'Data row tidak valid:',
                row
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Set action URL
        |--------------------------------------------------------------------------
        */

        form.action =
            "{{ url('/admin-dataset') }}"
            + "/{{ $dataset->id }}"
            + "/rows/"
            + row.id;


        /*
        |--------------------------------------------------------------------------
        | Ambil data JSON
        |--------------------------------------------------------------------------
        */

        const data =
            row.data_json || {};


        /*
        |--------------------------------------------------------------------------
        | Isi semua field
        |--------------------------------------------------------------------------
        */

        form.querySelectorAll(
            '[data-field]'
        ).forEach(function (input) {

            const field =
                input.dataset.field;

            let value =
                data[field] ?? '';


            /*
            |--------------------------------------------------------------------------
            | Normalisasi value
            |--------------------------------------------------------------------------
            */

            if (value === null || value === undefined) {

                value = '';

            }


            /*
            |--------------------------------------------------------------------------
            | Khusus input date
            |--------------------------------------------------------------------------
            */

            if (
                input.type === 'date'
                && value
            ) {

                value =
                    String(value).substring(0, 10);

            }


            input.value = value;

        });


        /*
        |--------------------------------------------------------------------------
        | Tampilkan modal
        |--------------------------------------------------------------------------
        */

        modal.classList.remove('hidden');

        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');


        /*
        |--------------------------------------------------------------------------
        | Focus field pertama
        |--------------------------------------------------------------------------
        */

        const firstInput =
            form.querySelector('[data-field]');

        if (firstInput) {

            setTimeout(function () {

                firstInput.focus();

            }, 100);

        }
    }


    function closeEditDataModal()
    {

        const modal =
            document.getElementById('editDataModal');

        if (!modal) return;

        modal.classList.add('hidden');

        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');

    }


    /* =========================================================
    DELETE DATA MODAL
    ========================================================= */

    function openDeleteDataModal(rowId)
    {

        const modal =
            document.getElementById('deleteDataModal');

        const form =
            document.getElementById('deleteDataForm');

        if (!modal || !form) return;


        /*
        |--------------------------------------------------------------------------
        | Set form action
        |--------------------------------------------------------------------------
        */

        form.action =
            "{{ url('/admin-dataset') }}"
            + "/{{ $dataset->id }}"
            + "/rows/"
            + rowId;


        /*
        |--------------------------------------------------------------------------
        | Reset submit button
        |--------------------------------------------------------------------------
        */

        const submitButton =
            document.getElementById('deleteDataSubmitButton');

        const submitIcon =
            document.getElementById('deleteDataSubmitIcon');

        const submitSpinner =
            document.getElementById('deleteDataSubmitSpinner');

        const submitText =
            document.getElementById('deleteDataSubmitText');


        if (submitButton) {

            submitButton.disabled = false;

            submitButton.classList.remove(
                'bg-slate-400',
                'cursor-not-allowed',
                'shadow-none'
            );

            submitButton.classList.add(
                'bg-red-600',
                'hover:bg-red-700',
                'hover:shadow-md'
            );
        }


        if (submitIcon) {
            submitIcon.classList.remove('hidden');
        }


        if (submitSpinner) {
            submitSpinner.classList.add('hidden');
        }


        if (submitText) {
            submitText.textContent =
                'Ya, Hapus Data';
        }


        /*
        |--------------------------------------------------------------------------
        | Show modal
        |--------------------------------------------------------------------------
        */

        modal.classList.remove('hidden');

        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

    }


    function closeDeleteDataModal()
    {

        const modal =
            document.getElementById('deleteDataModal');

        if (!modal) return;

        modal.classList.add('hidden');

        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');

    }

    /* =========================================================
    SUBMIT DELETE DATA
    ========================================================= */

    const deleteDataForm =
        document.getElementById('deleteDataForm');

    const deleteDataSubmitButton =
        document.getElementById('deleteDataSubmitButton');

    const deleteDataSubmitIcon =
        document.getElementById('deleteDataSubmitIcon');

    const deleteDataSubmitSpinner =
        document.getElementById('deleteDataSubmitSpinner');

    const deleteDataSubmitText =
        document.getElementById('deleteDataSubmitText');


    deleteDataForm?.addEventListener('submit', function () {

        /*
        |--------------------------------------------------------------------------
        | Disable button
        |--------------------------------------------------------------------------
        */

        deleteDataSubmitButton.disabled = true;


        /*
        |--------------------------------------------------------------------------
        | Ubah tampilan button
        |--------------------------------------------------------------------------
        */

        deleteDataSubmitButton.classList.remove(
            'bg-red-600',
            'hover:bg-red-700',
            'hover:shadow-md'
        );

        deleteDataSubmitButton.classList.add(
            'bg-slate-400',
            'cursor-not-allowed',
            'shadow-none'
        );


        /*
        |--------------------------------------------------------------------------
        | Icon
        |--------------------------------------------------------------------------
        */

        deleteDataSubmitIcon.classList.add('hidden');

        deleteDataSubmitSpinner.classList.remove('hidden');


        /*
        |--------------------------------------------------------------------------
        | Text
        |--------------------------------------------------------------------------
        */

        deleteDataSubmitText.textContent =
            'Menghapus...';

    });


    /* =========================================================
    ESC KEY
    ========================================================= */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') return;


            closeAddDataModal();

            closeEditDataModal();

            closeDeleteDataModal();

        }
    );

    /* =========================================================
    SUBMIT EDIT DATA
    ========================================================= */

    const editDataForm =
        document.getElementById('editDataForm');

    const editDataSubmitButton =
        document.getElementById('editDataSubmitButton');

    const editDataSubmitIcon =
        document.getElementById('editDataSubmitIcon');

    const editDataSubmitSpinner =
        document.getElementById('editDataSubmitSpinner');

    const editDataSubmitText =
        document.getElementById('editDataSubmitText');


    editDataForm?.addEventListener('submit', function () {

        /*
        |--------------------------------------------------------------------------
        | Disable button
        |--------------------------------------------------------------------------
        */

        editDataSubmitButton.disabled = true;


        /*
        |--------------------------------------------------------------------------
        | Ubah tampilan button
        |--------------------------------------------------------------------------
        */

        editDataSubmitButton.classList.remove(
            'bg-emerald-600',
            'hover:bg-emerald-700',
            'hover:shadow-md'
        );

        editDataSubmitButton.classList.add(
            'bg-slate-400',
            'cursor-not-allowed',
            'shadow-none'
        );


        /*
        |--------------------------------------------------------------------------
        | Icon
        |--------------------------------------------------------------------------
        */

        editDataSubmitIcon.classList.add('hidden');

        editDataSubmitSpinner.classList.remove('hidden');


        /*
        |--------------------------------------------------------------------------
        | Text
        |--------------------------------------------------------------------------
        */

        editDataSubmitText.textContent =
            'Menyimpan...';

    });

</script>

@endpush

@endsection