@extends('layouts.admin')

@section('title', 'Detail Approval Dataset')
@section('subtitle', 'Review dataset dan revisi dataset')

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


    {{-- ACTION --}}
    @if($dataset->status === 'pending')

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

            <h2 class="text-lg font-semibold text-slate-800 mb-5">
                Approval Dataset
            </h2>

            <div class="flex flex-col md:flex-row gap-3">

                <form method="POST"
                      action="{{ route('admin.approval.approve', $dataset) }}"
                      class="flex-1">
                    @csrf

                    <button class="w-full h-12 rounded-2xl bg-green-600 hover:bg-green-700 text-white font-medium transition">
                        Approve Dataset
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('admin.approval.reject', $dataset) }}"
                      class="flex-1">
                    @csrf

                    <button class="w-full h-12 rounded-2xl bg-red-600 hover:bg-red-700 text-white font-medium transition">
                        Reject Dataset
                    </button>
                </form>

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

                <form method="POST"
                      action="{{ route('admin.approval.approveUpdate', $dataset) }}"
                      class="flex-1">
                    @csrf

                    <button class="w-full h-12 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                        Approve Revisi
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('admin.approval.rejectUpdate', $dataset) }}"
                      class="flex-1">
                    @csrf

                    <button class="w-full h-12 rounded-2xl bg-orange-600 hover:bg-orange-700 text-white font-medium transition">
                        Reject Revisi
                    </button>
                </form>

            </div>

        </div>

    @endif


    {{-- KOLOM --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

            <div>

                <h2 class="text-xl font-bold text-slate-800">
                    Struktur Kolom
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Struktur kolom dataset
                </p>

            </div>

            <div class="text-sm text-slate-500">
                {{ count($dataset->schema_json ?? []) }} kolom
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                    <tr>

                        <th class="px-6 py-4 text-left">
                            Nama Kolom
                        </th>

                        <th class="px-6 py-4 text-left">
                            Tipe
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($dataset->schema_json ?? [] as $column)

                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $column['name'] ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600 capitalize">
                                {{ $column['type'] ?? 'text' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="2"
                                class="px-6 py-12 text-center text-slate-500">

                                Tidak ada struktur kolom

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- DATASET --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

            <div>

                <h2 class="text-xl font-bold text-slate-800">
                    Isi Dataset
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Data utama dataset
                </p>

            </div>

            <div class="text-sm text-slate-500">
                {{ $dataset->data->count() }} data
            </div>

        </div>

        @if($dataset->data->count())

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide whitespace-nowrap">

                        <tr>

                            @foreach($dataset->schema_json ?? [] as $column)

                                <th class="px-6 py-4 text-left">
                                    {{ $column['name'] }}
                                </th>

                            @endforeach

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @foreach($dataset->data as $row)

                            <tr class="hover:bg-slate-50 transition">

                                @foreach($dataset->schema_json ?? [] as $column)

                                    <td class="px-6 py-4 whitespace-nowrap text-slate-700">

                                        {{ $row->data_json[$column['name']] ?? '-' }}

                                    </td>

                                @endforeach

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="px-6 py-16 text-center text-slate-500">

                Belum ada data dataset

            </div>

        @endif

    </div>


    {{-- REVISION DATA --}}
    @if($dataset->activeRevision)

        <div class="bg-white rounded-3xl border border-blue-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-blue-200 bg-blue-50 flex items-center justify-between">

                <div>

                    <h2 class="text-xl font-bold text-blue-800">
                        Draft Revisi Dataset
                    </h2>

                    <p class="text-sm text-blue-600 mt-1">
                        Data revisi yang diajukan
                    </p>

                </div>

                <div class="text-sm text-blue-700">
                    {{ $dataset->activeRevision->data->count() }} data
                </div>

            </div>

            @if($dataset->activeRevision->data->count())

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead class="bg-blue-50 text-blue-700 uppercase text-xs tracking-wide whitespace-nowrap">

                            <tr>

                                @foreach($dataset->schema_json ?? [] as $column)

                                    <th class="px-6 py-4 text-left">
                                        {{ $column['name'] }}
                                    </th>

                                @endforeach

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-blue-100">

                            @foreach($dataset->activeRevision->data as $row)

                                <tr class="hover:bg-blue-50 transition">

                                    @foreach($dataset->schema_json ?? [] as $column)

                                        <td class="px-6 py-4 whitespace-nowrap text-slate-700">

                                            {{ $row->data_json[$column['name']] ?? '-' }}

                                        </td>

                                    @endforeach

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="px-6 py-16 text-center text-slate-500">

                    Belum ada draft revisi

                </div>

            @endif

        </div>

    @endif


    {{-- LOG --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200">

            <h2 class="text-xl font-bold text-slate-800">
                Riwayat Approval
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Seluruh aktivitas approval dataset
            </p>

        </div>

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
                @endphp

                <div class="px-6 py-5 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">

                    <div>

                        <div class="flex items-center gap-2 flex-wrap">

                            <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $badge }}">
                                {{ str_replace('_', ' ', $log->action) }}
                            </span>

                            <span class="text-sm text-slate-500">
                                {{ $log->created_at->format('d M Y H:i') }}
                            </span>

                        </div>

                        @if($log->catatan)

                            <div class="mt-3 text-sm text-slate-700">
                                {{ $log->catatan }}
                            </div>

                        @endif

                    </div>

                    <div class="text-sm text-slate-500 whitespace-nowrap">

                        {{ $log->creator->nama ?? '-' }}

                    </div>

                </div>

            @empty

                <div class="px-6 py-16 text-center text-slate-500">

                    Belum ada riwayat approval

                </div>

            @endforelse

        </div>

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

@endsection