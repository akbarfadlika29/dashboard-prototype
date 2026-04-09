@extends('layouts.admin')

@section('title', 'Approval Dataset')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Approval Dataset</h1>
            <p class="text-gray-500 mt-1">
                Kelola seluruh dataset, lakukan approve, reject, atau kembalikan ke draft.
            </p>
        </div>

        <div class="flex gap-3 flex-wrap">
            <div class="bg-white border rounded-2xl px-5 py-3 shadow-sm min-w-[130px]">
                <p class="text-xs uppercase tracking-wide text-gray-500">Total</p>
                <p class="text-2xl font-bold text-gray-900">{{ $dataset->count() }}</p>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl px-5 py-3 min-w-[130px]">
                <p class="text-xs uppercase tracking-wide text-yellow-700">Pending</p>
                <p class="text-2xl font-bold text-yellow-700">
                    {{ $dataset->where('status', 'pending')->count() }}
                </p>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-2xl px-5 py-3 min-w-[130px]">
                <p class="text-xs uppercase tracking-wide text-green-700">Approved</p>
                <p class="text-2xl font-bold text-green-700">
                    {{ $dataset->where('status', 'approved')->count() }}
                </p>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-3 min-w-[130px]">
                <p class="text-xs uppercase tracking-wide text-red-700">Rejected</p>
                <p class="text-2xl font-bold text-red-700">
                    {{ $dataset->where('status', 'rejected')->count() }}
                </p>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Daftar Dataset</h2>
                <p class="text-sm text-gray-500">Semua dataset ditampilkan beserta status dan aksi yang tersedia.</p>
            </div>

            <div class="text-sm text-gray-500">
                {{ $dataset->count() }} dataset ditemukan
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Dataset</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Seksi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Pembuat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($dataset as $item)
                        <tr class="hover:bg-gray-50 transition duration-150 align-top">

                            {{-- Dataset --}}
                            <td class="px-6 py-5">
                                <div>
                                    <div class="font-semibold text-gray-900 text-sm md:text-base">
                                        {{ $item->nama }}
                                    </div>

                                    @if($item->deskripsi)
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-2 max-w-md">
                                            {{ $item->deskripsi }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            {{-- Seksi --}}
                            <td class="px-6 py-5 text-sm text-gray-700 whitespace-nowrap">
                                {{ $item->seksi->nama ?? '-' }}
                            </td>

                            {{-- Creator --}}
                            <td class="px-6 py-5 text-sm text-gray-700 whitespace-nowrap">
                                {{ $item->creator->nama ?? '-' }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-5 whitespace-nowrap">
                                @php
                                    $statusClass = match($item->status) {
                                        'approved' => 'bg-green-100 text-green-700 border-green-200',
                                        'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'rejected' => 'bg-red-100 text-red-700 border-red-200',
                                        'draft' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        default => 'bg-blue-100 text-blue-700 border-blue-200',
                                    };
                                @endphp

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClass }} capitalize">
                                    {{ $item->status }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-5 text-sm text-gray-500 whitespace-nowrap">
                                <div>{{ $item->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $item->created_at->format('H:i') }}</div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-5">
                                <div class="flex flex-col gap-2 min-w-[220px]">

                                    {{-- Detail button --}}
                                    <a href="{{ route('admin.approval.show', $item) }}"
                                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:border-gray-300 transition">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>

                                        Lihat Detail
                                    </a>

                                    {{-- Pending: approve + reject --}}
                                    @if($item->status === 'pending')
                                        <div class="grid grid-cols-1 gap-2">

                                            <form method="POST" action="{{ route('admin.approval.approve', $item) }}" class="space-y-2">
                                                @csrf

                                                <input
                                                    type="text"
                                                    name="catatan"
                                                    placeholder="Catatan approve (opsional)"
                                                    class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:border-green-500 focus:ring focus:ring-green-100"
                                                >

                                                <button
                                                    type="submit"
                                                    class="w-full rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700 transition shadow-sm"
                                                >
                                                    Approve Dataset
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.approval.reject', $item) }}" class="space-y-2">
                                                @csrf

                                                <input
                                                    type="text"
                                                    name="catatan"
                                                    placeholder="Alasan reject"
                                                    class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:border-red-500 focus:ring focus:ring-red-100"
                                                    required
                                                >

                                                <button
                                                    type="submit"
                                                    class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition shadow-sm"
                                                >
                                                    Reject Dataset
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    {{-- Approved: cancel / return to draft --}}
                                    @if($item->status === 'approved')
                                        <form method="POST" action="{{ route('admin.approval.cancel', $item) }}" class="space-y-2">
                                            @csrf

                                            <input
                                                type="text"
                                                name="catatan"
                                                placeholder="Alasan kembalikan ke draft"
                                                class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:border-amber-500 focus:ring focus:ring-amber-100"
                                                required
                                            >

                                            <button
                                                type="submit"
                                                class="w-full rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-amber-600 transition shadow-sm"
                                            >
                                                Kembalikan ke Draft
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Draft / Rejected --}}
                                    @if(in_array($item->status, ['draft', 'rejected']))
                                        <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 px-4 py-3 text-center text-xs text-gray-500">
                                            Tidak ada aksi yang tersedia untuk status ini.
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8L10 18" />
                                        </svg>
                                    </div>

                                    <p class="font-semibold text-gray-700">Belum ada dataset</p>
                                    <p class="text-sm text-gray-500 mt-1">Dataset yang memerlukan approval akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection