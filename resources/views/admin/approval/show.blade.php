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

    @endif

    @if($dataset->first_created != 'files')

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
                    {{ $datasetData->total() }} data
                </div>

            </div>

            @if($datasetData->count())

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

                            @foreach($datasetData as $row)

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
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $datasetData->links() }}
                    </div>

                </div>

            @else

                <div class="px-6 py-16 text-center text-slate-500">

                    Belum ada data dataset

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