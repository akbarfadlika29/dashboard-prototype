@extends('layouts.admin')

@section('title', 'Detail Dataset Approval')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.approval.index') }}" class="hover:text-blue-600 transition">
                    Approval Dataset
                </a>
                <span>/</span>
                <span class="text-gray-700">Detail Dataset</span>
            </div>

            <h1 class="text-3xl font-bold text-gray-900">{{ $dataset->nama }}</h1>
            <p class="text-gray-500 mt-2 max-w-3xl">
                {{ $dataset->deskripsi ?: 'Tidak ada deskripsi dataset.' }}
            </p>
        </div>

        @php
            $statusClass = match($dataset->status) {
                'approved' => 'bg-green-100 text-green-700 border-green-200',
                'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                'rejected' => 'bg-red-100 text-red-700 border-red-200',
                'draft' => 'bg-gray-100 text-gray-700 border-gray-200',
                default => 'bg-blue-100 text-blue-700 border-blue-200',
            };
        @endphp

        <div class="inline-flex items-center px-4 py-2 rounded-2xl border text-sm font-semibold capitalize {{ $statusClass }} h-fit">
            {{ $dataset->status }}
        </div>
    </div>

    {{-- Info Card --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white border border-gray-200 rounded-3xl p-5 shadow-sm">
            <p class="text-sm text-gray-500 mb-1">Seksi</p>
            <p class="text-lg font-semibold text-gray-900">{{ $dataset->seksi->nama ?? '-' }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-3xl p-5 shadow-sm">
            <p class="text-sm text-gray-500 mb-1">Pembuat</p>
            <p class="text-lg font-semibold text-gray-900">{{ $dataset->creator->nama ?? '-' }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-3xl p-5 shadow-sm">
            <p class="text-sm text-gray-500 mb-1">Tanggal Dibuat</p>
            <p class="text-lg font-semibold text-gray-900">{{ $dataset->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>

    {{-- Struktur Dataset --}}
    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Isi Dataset</h2>
            <p class="text-sm text-gray-500 mt-1">
                Berikut adalah struktur dan isi dataset yang diajukan.
            </p>
        </div>

        @if($dataset->data->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach($dataset->kolom ?? [] as $column)
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 whitespace-nowrap">
                                    {{ $column['name'] }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($dataset->data as $row)
                            <tr class="hover:bg-gray-50 transition">
                                @foreach($dataset->kolom ?? [] as $column)
                                    <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $row->data_json[$column['name']] ?? '-' }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-16 text-center text-gray-500">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8L10 18" />
                    </svg>
                </div>

                <p class="font-semibold text-gray-700">Belum ada isi dataset</p>
                <p class="text-sm text-gray-500 mt-1">
                    Dataset ini belum memiliki data untuk ditampilkan.
                </p>
            </div>
        @endif
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.approval.index') }}"
           class="inline-flex items-center gap-2 rounded-2xl bg-gray-900 text-white px-5 py-3 text-sm font-medium hover:bg-black transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Approval
        </a>
    </div>
</div>
@endsection