@extends('layouts.admin')

@section('title', 'Dataset')
@section('subtitle', 'Kelola dataset sesuai hak akses pengguna')

@section('content')

@php
    function datasetStatusBadge($dataset) {

        if ($dataset->status === 'approved') {
            return [
                'label' => 'Approved',
                'class' => 'bg-green-100 text-green-700'
            ];
        }

        if ($dataset->status === 'pending') {
            return [
                'label' => 'Waiting for Approval',
                'class' => 'bg-blue-100 text-blue-700'
            ];
        }

        if ($dataset->status === 'rejected') {
            return [
                'label' => 'Rejected',
                'class' => 'bg-red-100 text-red-700'
            ];
        }

        return [
            'label' => 'Draft',
            'class' => 'bg-slate-100 text-slate-700'
        ];
    }

    function datasetStatusRevisionBadge($dataset) {

        if ($dataset->activeRevision && $dataset->activeRevision->status === 'approved') {
            return [
                'label' => 'Approved',
                'class' => 'bg-green-100 text-green-700'
            ];
        }

        if ($dataset->activeRevision && $dataset->activeRevision->status === 'pending') {
            return [
                'label' => 'Waiting for Approval',
                'class' => 'bg-blue-100 text-blue-700'
            ];
        }

        if ($dataset->activeRevision && $dataset->activeRevision->status === 'rejected') {
            return [
                'label' => 'Rejected',
                'class' => 'bg-red-100 text-red-700'
            ];
        }

        return [
            'label' => 'Draft',
            'class' => 'bg-slate-100 text-slate-700'
        ];
    }
@endphp

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Daftar Dataset
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Total {{ $dataset->count() }} dataset
        </p>
    </div>

    <button onclick="openModal()"
        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-green-700 hover:bg-green-800 text-white px-5 py-3 font-medium transition shadow-sm">

        <i class="fa-solid fa-plus"></i>

        Tambah Dataset
    </button>
</div>

{{-- SUMMARY --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <div class="text-sm text-slate-500">
            Total
        </div>

        <div class="mt-2 text-3xl font-bold text-slate-800">
            {{ $dataset->count() }}
        </div>
    </div>

    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
        <div class="text-sm text-slate-500">
            Draft
        </div>

        <div class="mt-2 text-3xl font-bold text-slate-700">
            {{ $dataset->where('status', 'draft')->count() }}
        </div>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5">
        <div class="text-sm text-yellow-600">
            Waiting for Approval
        </div>

        <div class="mt-2 text-3xl font-bold text-yellow-700">
            {{ $dataset->where('status', 'pending')->count() }}
        </div>
    </div>

    <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
        <div class="text-sm text-green-600">
            Approved
        </div>

        <div class="mt-2 text-3xl font-bold text-green-700">
            {{ $dataset->where('status', 'approved')->count() }}
        </div>
    </div>

    <div class="bg-red-50 border border-red-200 rounded-2xl p-5">
        <div class="text-sm text-red-600">
            Rejected
        </div>

        <div class="mt-2 text-3xl font-bold text-red-700">
            {{ $dataset->where('status', 'rejected')->count() }}
        </div>
    </div>

</div>

{{-- MODAL --}}
<div id="modal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white w-[420px] rounded-3xl shadow-xl p-6">

        <h2 class="text-xl font-bold text-slate-800 mb-2">
            Tambah Dataset
        </h2>

        <p class="text-sm text-slate-500 mb-6">
            Pilih metode input dataset
        </p>

        <div class="space-y-3">

            <button onclick="goToManual()"
                class="w-full border border-slate-200 rounded-2xl p-5 hover:bg-slate-50 transition text-left">

                <div class="font-semibold text-slate-800">
                    <i class="fa-solid fa-pencil"></i> Input Manual
                </div>

                <div class="text-sm text-slate-500 mt-1">
                    Isi dataset secara manual
                </div>
            </button>

            <button onclick="goToImportCSV()"
                class="w-full border border-slate-200 rounded-2xl p-5 hover:bg-slate-50 transition text-left">

                <div class="font-semibold text-slate-800">
                    <i class="fa-solid fa-file-csv"></i> Import CSV
                </div>

                <div class="text-sm text-slate-500 mt-1">
                    Upload file CSV format standar
                </div>
            </button>

            <button onclick="goToImportFiles()"
                class="w-full border border-slate-200 rounded-2xl p-5 hover:bg-slate-50 transition text-left">

                <div class="font-semibold text-slate-800">
                    <i class="fa-solid fa-file"></i> Import PDF/XLSX/JPG/PNG
                </div>

                <div class="text-sm text-slate-500 mt-1">
                    Upload file berdasarkan format Anda
                </div>
            </button>

        </div>

        <button onclick="closeModal()"
            class="mt-5 text-sm text-slate-500 hover:text-slate-700 transition">
            Batal
        </button>

    </div>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-slate-50 border-b border-slate-200">

                <tr>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Dataset
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Kategori
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Seksi
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Revision
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">

                @forelse($dataset as $item)

                    @php
                        $badge = datasetStatusBadge($item);
                    @endphp

                    @php
                        $badgeRevision = datasetStatusRevisionBadge($item);
                    @endphp

                    <tr class="hover:bg-slate-50 transition">

                        {{-- DATASET --}}
                        <td class="px-6 py-5">

                            <div class="font-semibold text-slate-800">
                                {{ $item->nama }}
                            </div>

                            @if($item->deskripsi)
                                <div class="text-sm text-slate-500 mt-1 line-clamp-2">
                                    {{ $item->deskripsi }}
                                </div>
                            @endif

                        </td>

                        {{-- KATEGORI --}}
                        <td class="px-6 py-5 text-sm text-slate-600 whitespace-nowrap">
                            {{ $item->kategori->nama ?? '-' }}
                        </td>

                        {{-- SEKSI --}}
                        <td class="px-6 py-5 text-sm text-slate-600 whitespace-nowrap">
                            {{ $item->seksi->nama ?? '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-5 whitespace-nowrap">

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badge['class'] }}">
                                {{ $badge['label'] }}
                            </span>

                        </td>

                        {{-- REVISION --}}
                        <td class="px-6 py-5 whitespace-nowrap">

                            @if($item->activeRevision)

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeRevision['class'] }}">
                                    {{ $badgeRevision['label'] }}
                                </span>

                            @else

                                <span class="text-sm text-slate-400">
                                    Tidak ada
                                </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center justify-center">

                                <a href="{{ route('dataset.show.admin', $item) }}"
                                   class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 transition">

                                    <i class="fa-solid fa-eye"></i>

                                    Detail

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="px-6 py-14 text-center text-slate-500">

                            Belum ada dataset.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<script>

function openModal() {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.getElementById('modal').classList.remove('flex');
}

function goToManual() {
    window.location.href = "{{ route('dataset.create') }}";
}

function goToImportCSV() {
    window.location.href = "{{ route('dataset.import') }}";
}

function goToImportFiles() {
    window.location.href = "{{ route('dataset.importFiles') }}";
}

</script>

@endsection