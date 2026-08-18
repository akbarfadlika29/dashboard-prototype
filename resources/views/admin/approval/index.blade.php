@extends('layouts.admin')

@section('title', 'Approval Dataset')
@section('subtitle', 'Kelola approval dataset dan revisi dataset')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Approval Dataset
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Monitoring approval dataset dan revisi dataset
            </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">

            <div class="bg-white border border-slate-200 rounded-2xl px-5 py-4 shadow-sm">
                <div class="text-xs text-slate-500 uppercase tracking-wide">
                    Total
                </div>

                <div class="mt-2 text-2xl font-bold text-slate-800">
                    {{ $dataset->count() }}
                </div>
            </div>

            <div class="bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4">
                <div class="text-xs text-slate-500 uppercase tracking-wide">
                    Draft
                </div>

                <div class="mt-2 text-2xl font-bold text-slate-700">
                    {{ $dataset->where('status', 'draft')->count() }}
                </div>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4">
                <div class="text-xs text-amber-700 uppercase tracking-wide">
                    Pending
                </div>

                <div class="mt-2 text-2xl font-bold text-amber-700">
                    {{ $dataset->where('status', 'pending')->count() }}
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-2xl px-5 py-4">
                <div class="text-xs text-green-700 uppercase tracking-wide">
                    Approved
                </div>

                <div class="mt-2 text-2xl font-bold text-green-700">
                    {{ $dataset->where('status', 'approved')->count() }}
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-2xl px-5 py-4">
                <div class="text-xs text-red-700 uppercase tracking-wide">
                    Rejected
                </div>

                <div class="mt-2 text-2xl font-bold text-red-700">
                    {{ $dataset->where('status', 'rejected')->count() }}
                </div>
            </div>

        </div>
    </div>


    {{-- TABLE --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-800">
                    Daftar Dataset
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Semua dataset yang dapat dilakukan approval
                </p>
            </div>

            <div class="text-sm text-slate-500">
                {{ $dataset->count() }} dataset
            </div>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            Dataset
                        </th>

                        <th class="px-6 py-4 text-left">
                            Kategori
                        </th>

                        <th class="px-6 py-4 text-left">
                            Seksi
                        </th>

                        <th class="px-6 py-4 text-left">
                            Pembuat
                        </th>

                        <th class="px-6 py-4 text-center">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center">
                            Revisi
                        </th>

                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($dataset as $item)

                        @php
                            $statusColor = match($item->status) {
                                'draft' => 'bg-slate-100 text-slate-700',
                                'pending' => 'bg-amber-100 text-amber-700',
                                'approved' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-700',
                            };

                            $revisionStatusColor = match(optional($item->activeRevision)->status) {
                                'pending' => 'bg-amber-100 text-amber-700',
                                'approved' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                'draft' => 'bg-slate-100 text-slate-700',
                                default => 'bg-slate-100 text-slate-500',
                            };
                        @endphp

                        <tr class="hover:bg-slate-50 transition align-top">

                            {{-- DATASET --}}
                            <td class="px-6 py-5">

                                <div class="font-semibold text-slate-800">
                                    {{ $item->nama }}
                                </div>

                                @if($item->deskripsi)
                                    <div class="text-sm text-slate-500 mt-1 max-w-md line-clamp-2">
                                        {{ $item->deskripsi }}
                                    </div>
                                @endif

                            </td>

                            {{-- KATEGORI --}}
                            <td class="px-6 py-5 whitespace-nowrap text-slate-600">
                                {{ $item->kategori->nama ?? '-' }}
                            </td>

                            {{-- SEKSI --}}
                            <td class="px-6 py-5 whitespace-nowrap text-slate-600">
                                {{ $item->seksi->nama ?? '-' }}
                            </td>

                            {{-- CREATOR --}}
                            <td class="px-6 py-5 whitespace-nowrap text-slate-600">
                                {{ $item->creator->nama ?? '-' }}
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-5 text-center whitespace-nowrap">

                                <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $statusColor }}">
                                    {{ str_replace('_', ' ', $item->status) }}
                                </span>

                            </td>

                            {{-- REVISION --}}
                            <td class="px-6 py-5 text-center whitespace-nowrap">

                                @if($item->activeRevision)

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $revisionStatusColor }}">
                                        {{ str_replace('_', ' ', $item->activeRevision->status) }}
                                    </span>

                                @else

                                    <span class="text-xs text-slate-400">
                                        Tidak ada
                                    </span>

                                @endif

                            </td>

                            {{-- ACTION --}}
                            <td class="px-6 py-5">

                                <div class="flex flex-col gap-2 min-w-[220px]">

                                    {{-- DETAIL --}}
                                    <a href="{{ route('admin.approval.show', $item) }}"
                                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 transition">

                                        <i class="fa-solid fa-eye"></i>

                                        Detail
                                    </a>

                                    {{-- CANCEL --}}
                                    @if($item->status === 'approved')

                                        <form method="POST"
                                              action="{{ route('admin.approval.cancel', $item) }}">
                                            @csrf

                                            <button class="w-full rounded-xl bg-slate-700 hover:bg-slate-800 px-4 py-2 text-sm font-medium text-white transition">
                                                Kembalikan ke Draft
                                            </button>
                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                class="px-6 py-14 text-center text-slate-500">

                                Belum ada dataset

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection