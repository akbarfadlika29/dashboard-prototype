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

                                        <div
                                            x-data="{
                                                showModal: false,
                                                loading: false
                                            }"
                                        >

                                            {{-- BUTTON KEMBALIKAN KE DRAFT --}}
                                            <button
                                                type="button"
                                                @click="showModal = true"
                                                class="w-full rounded-xl bg-slate-700 hover:bg-slate-800 px-4 py-2 text-sm font-medium text-white transition"
                                            >
                                                <i class="fa-solid fa-rotate-left mr-1"></i>
                                                Kembalikan ke Draft
                                            </button>


                                            {{-- MODAL --}}
                                            <div
                                                x-show="showModal"
                                                x-cloak
                                                x-transition.opacity
                                                class="fixed inset-0 z-[100] flex items-center justify-center p-4"
                                            >

                                                {{-- OVERLAY --}}
                                                <div
                                                    class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm"
                                                    @click="if (!loading) showModal = false"
                                                ></div>


                                                {{-- MODAL CONTENT --}}
                                                <div
                                                    x-show="showModal"
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 scale-95"
                                                    x-transition:enter-end="opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-150"
                                                    x-transition:leave-start="opacity-100 scale-100"
                                                    x-transition:leave-end="opacity-0 scale-95"
                                                    class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden"
                                                >

                                                    {{-- ICON --}}
                                                    <div class="px-6 pt-6">

                                                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center">

                                                            <i class="fa-solid fa-rotate-left text-lg"></i>

                                                        </div>

                                                    </div>


                                                    {{-- CONTENT --}}
                                                    <div class="px-6 py-5">

                                                        <h3 class="text-lg font-bold text-slate-800">
                                                            Kembalikan ke Draft?
                                                        </h3>

                                                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">

                                                            Apakah Anda yakin ingin mengembalikan dataset

                                                            <span class="font-semibold text-slate-700">
                                                                "{{ $item->nama }}"
                                                            </span>

                                                            ke status Draft?

                                                        </p>

                                                        <p class="text-xs text-amber-600 mt-3">
                                                            Dataset yang dikembalikan ke Draft tidak dapat diajukan kembali. Hanya berfungsi untuk menghapus Dataset.
                                                        </p>

                                                    </div>


                                                    {{-- ACTION --}}
                                                    <div class="px-6 py-5 bg-slate-50 border-t border-slate-200">

                                                        <div class="flex gap-3">

                                                            {{-- BATAL --}}
                                                            <button
                                                                type="button"
                                                                @click="showModal = false"
                                                                :disabled="loading"
                                                                class="flex-1 h-11 rounded-xl border border-slate-300 bg-white text-slate-700 font-medium hover:bg-slate-100 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                                            >
                                                                Batal
                                                            </button>


                                                            {{-- KONFIRMASI --}}
                                                            <form
                                                                method="POST"
                                                                action="{{ route('admin.approval.cancel', $item) }}"
                                                                class="flex-1"
                                                                @submit="loading = true"
                                                            >

                                                                @csrf

                                                                <button
                                                                    type="submit"
                                                                    :disabled="loading"
                                                                    class="w-full h-11 rounded-xl bg-slate-700 hover:bg-slate-800 text-white font-medium transition flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed"
                                                                >

                                                                    {{-- ICON --}}
                                                                    <i
                                                                        x-show="!loading"
                                                                        class="fa-solid fa-rotate-left"
                                                                    ></i>

                                                                    {{-- SPINNER --}}
                                                                    <i
                                                                        x-show="loading"
                                                                        class="fa-solid fa-spinner fa-spin"
                                                                    ></i>

                                                                    {{-- TEXT --}}
                                                                    <span
                                                                        x-text="loading
                                                                            ? 'Mengembalikan...'
                                                                            : 'Ya, Kembalikan'"
                                                                    ></span>

                                                                </button>

                                                            </form>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

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