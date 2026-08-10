@extends('layouts.admin')

@section('title', $dataset->nama)

@section('content')

@php
    $revision = $dataset->activeRevision;
    $canEdit = $dataset->canEdit();
    $displayData = $dataset->displayData();

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
@endphp


    @php
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

            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

                <div>

                    <h2 class="text-xl font-bold text-slate-800">
                        Struktur Dataset
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ count($schema) }} kolom dataset
                    </p>

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Nama Kolom
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Tipe
                            </th>

                            @if($canEdit)
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Aksi
                                </th>
                            @endif

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @foreach($schema as $i => $column)

                            @php
                                $name = is_array($column)
                                    ? ($column['name'] ?? '-')
                                    : $column;

                                $type = is_array($column)
                                    ? ($column['type'] ?? 'text')
                                    : 'text';
                            @endphp

                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-5">

                                    @if($canEdit)

                                        <form method="POST"
                                            action="{{ route('columns.update', [$dataset, $i]) }}"
                                            class="flex items-center gap-3">

                                            @csrf
                                            @method('PUT')

                                            <input type="text"
                                                name="label"
                                                value="{{ $name }}"
                                                @disabled(!(($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft'))
                                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                                    @else

                                        <div class="font-medium text-slate-800">
                                            {{ $name }}
                                        </div>

                                    @endif

                                </td>

                                <td class="px-6 py-5">

                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                                        {{ ucfirst($type) }}
                                    </span>

                                </td>

                                @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

                                    <td class="px-6 py-5">

                                        <div class="flex items-center justify-end gap-2">

                                            <button class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium transition">
                                                Update
                                            </button>

                                        </form>

                                        <form method="POST"
                                            action="{{ route('columns.destroy', [$dataset, $i]) }}"
                                            onsubmit="return confirm('Hapus kolom ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="px-4 py-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 text-sm font-medium transition">
                                                Hapus
                                            </button>

                                        </form>

                                        </div>

                                    </td>

                                @endif

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        {{-- DATA --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

                <div>

                    <h2 class="text-xl font-bold text-slate-800">
                        Data Dataset
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ $data->total() }} data ditemukan
                    </p>

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            @foreach($columns as $column)

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 whitespace-nowrap">

                                    {{ $column['name'] ?? '-' }}

                                </th>

                            @endforeach

                            @if($canEdit)

                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 whitespace-nowrap">
                                    Aksi
                                </th>

                            @endif

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($data as $row)

                            <tr class="hover:bg-slate-50 transition align-top">

                                <form method="POST"
                                    action="{{ route('rows.update', [$dataset, $row]) }}">

                                    @csrf
                                    @method('PUT')

                                    @foreach($columns as $column)

                                        @php
                                            $field = $column['name'];
                                        @endphp

                                        <td class="px-6 py-4 min-w-[220px]">

                                            <input type="text"
                                                name="data[{{ $field }}]"
                                                value="{{ $row->data_json[$field] ?? '' }}"
                                                @disabled(!(($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft'))
                                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                                        </td>

                                    @endforeach

                                    @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

                                        <td class="px-6 py-4">

                                            <div class="flex justify-end gap-2">

                                                <button class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium transition">
                                                    Update
                                                </button>

                                </form>

                                <form method="POST"
                                    action="{{ route('rows.destroy', [$dataset, $row]) }}"
                                    onsubmit="return confirm('Hapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="px-4 py-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 text-sm font-medium transition">
                                        Hapus
                                    </button>

                                </form>

                                            </div>

                                        </td>

                                    @endif

                            </tr>

                        @empty

                            <tr>

                                <td colspan="{{ count($columns) + 1 }}"
                                    class="px-6 py-16 text-center text-slate-500">

                                    Belum ada data dataset.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $data->links() }}
                </div>

            </div>

        </div>

        {{-- ADD DATA --}}
        @if (($canEdit && !$revision) || $dataset->activeRevision?->status === 'draft')

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

                <h2 class="text-xl font-bold text-slate-800 mb-6">
                    Tambah Data Baru
                </h2>

                <form method="POST"
                    action="{{ route('dataset.data.store', $dataset) }}">

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                        @foreach($columns as $column)

                            @php
                                $field = $column['name'];
                            @endphp

                            <div>

                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    {{ $field }}
                                </label>

                                <input type="text"
                                    name="data[{{ $field }}]"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

                            </div>

                        @endforeach

                    </div>

                    <div class="mt-6 flex justify-end">

                        <button class="px-5 py-2.5 rounded-2xl bg-green-600 hover:bg-green-700 text-white text-sm font-medium transition">
                            Tambah Data
                        </button>

                    </div>

                </form>

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
<script>

function submitButton(form)
{
    const button = form.querySelector('button');

    button.disabled = true;

    button.querySelector('.submit-spinner').classList.remove('hidden');

    button.querySelector('.submit-icon').classList.add('hidden');
}

function confirmDelete(e,form)
{
    e.preventDefault();

    if(!confirm('Yakin ingin menghapus dataset ini?'))
    {
        return false;
    }

    const button=form.querySelector('button');

    button.disabled=true;

    button.querySelector('.delete-spinner').classList.remove('hidden');

    button.querySelector('.delete-icon').classList.add('hidden');

    form.submit();

    return false;
}

</script>
@endpush

@endsection