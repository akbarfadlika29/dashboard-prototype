@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">{{ $dataset->nama }}</h1>
            <div class="mt-2 flex items-center gap-2 text-sm text-slate-500">
                <span>Status Dataset</span>

                @php
                    $statusColor = match($dataset->status) {
                        'draft' => 'bg-slate-100 text-slate-700',
                        'pending' => 'bg-amber-100 text-amber-700',
                        'approved' => 'bg-green-100 text-green-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-700'
                    };
                @endphp

                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                    {{ ucfirst($dataset->status) }}
                </span>
            </div>
        </div>

        <div class="flex flex-wrap gap-2">

            @if($dataset->canEdit())
                <form method="POST" action="{{ route('dataset.submit', $dataset) }}">
                    @csrf
                    <button class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                        Ajukan Dataset
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('dataset.destroy', $dataset) }}"
                      onsubmit="return confirm('Yakin ingin menghapus dataset ini?')">
                    @csrf
                    @method('DELETE')

                    <button class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition">
                        Hapus Dataset
                    </button>
                </form>
            @endif

            @if(auth()->user()->role == 'kepala_seksi' && $dataset->status == 'pending')

                <form method="POST" action="/admin-dataset/{{ $dataset->id }}/approve" class="flex items-center gap-2">
                    @csrf
                    <input name="catatan"
                           placeholder="Catatan approve"
                           class="h-10 rounded-xl border border-slate-300 px-3 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">

                    <button class="h-10 px-4 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-medium transition">
                        Approve
                    </button>
                </form>

                <form method="POST" action="/admin-dataset/{{ $dataset->id }}/reject" class="flex items-center gap-2">
                    @csrf
                    <input name="catatan"
                           placeholder="Alasan reject"
                           class="h-10 rounded-xl border border-slate-300 px-3 text-sm focus:ring-2 focus:ring-red-500 focus:outline-none">

                    <button class="h-10 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition">
                        Reject
                    </button>
                </form>

            @endif
        </div>
    </div>


    {{-- STRUKTUR KOLOM --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-4 py-2.5 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">Struktur Kolom</h2>
            <span class="text-sm text-slate-500">{{ count($dataset->schema_json) }} kolom</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-[13px] leading-tight">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Kolom</th>
                        <th class="px-6 py-3 text-left">Key</th>
                        @if($dataset->canEdit())
                        <th class="px-6 py-3 text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @foreach($dataset->schema_json as $i => $key)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-2.5">
                                <form method="POST"
                                      action="{{ route('columns.update', [$dataset, $i]) }}"
                                      class="flex items-center gap-3">
                                    @csrf
                                    @method('PUT')

                                    <input type="text"
                                           @disabled(!$dataset->canEdit())
                                           name="label"
                                           value="{{ $dataset->kolom[$i]['name'] }}"
                                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>

                            <td class="px-4 py-2.5 w-72">
                                    <input type="text"
                                           @disabled(!$dataset->canEdit())
                                           name="key"
                                           value="{{ $key['name'] }}"
                                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </td>

                            <td class="px-4 py-2.5">
                                <div class="flex justify-end items-center gap-2">
                                    @if($dataset->canEdit())
                                        <button class="px-3 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium transition">
                                            Update
                                        </button>
                                    @endif
                                </form>

                                    @if($dataset->canEdit())
                                    <form method="POST"
                                          action="{{ route('columns.destroy', [$dataset, $i]) }}"
                                          onsubmit="return confirm('Hapus kolom ini? Semua data pada kolom ini juga akan ikut terhapus.')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-xs font-medium transition">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- DATA DATASET --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-4 py-2.5 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">Data Dataset</h2>
            <span class="text-sm text-slate-500">Menampilkan {{ $data->count() }} data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-[13px] leading-tight">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wide whitespace-nowrap">
                    <tr>
                        @foreach($dataset->schema_json as $i => $key)
                            <th class="px-3 py-2 text-left">
                                {{ $dataset->kolom[$i]['name'] }}
                            </th>
                        @endforeach
                        @if($dataset->canEdit())
                        <th class="px-3 py-2 text-right w-44">Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $row)
                        <tr class="hover:bg-slate-50 transition align-top">
                            <form method="POST" action="{{ route('rows.update', [$dataset, $row]) }}">
                                @csrf
                                @method('PUT')

                                @foreach($dataset->schema_json as $i => $key)
                                    @php
                                        $field = is_array($key)
                                            ? ($key['key'] ?? $key['name'])
                                            : $key;
                                    @endphp

                                    <td class="px-3 py-2 min-w-[180px]">
                                        <input type="text"
                                               @disabled(!$dataset->canEdit())
                                               name="{{ $field }}"
                                               value="{{ $row->data_json[$field] ?? '' }}"
                                               class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                @endforeach

                                <td class="px-3 py-2">
                                    <div class="flex justify-end gap-2 whitespace-nowrap">
                                        @if($dataset->canEdit())
                                            <button class="px-3 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium transition">
                                                Update
                                            </button>
                                        @endif
                            </form>

                                        @if($dataset->canEdit())
                                        <form method="POST"
                                              action="{{ route('rows.destroy', [$dataset, $row]) }}"
                                              onsubmit="return confirm('Hapus data ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 text-xs font-medium transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                    </div>
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($dataset->schema_json) + 1 }}" class="px-6 py-10 text-center text-slate-500">
                                Belum ada data pada dataset ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-4 py-2.5 border-t border-slate-200 bg-slate-50">
            {{ $data->onEachSide(1)->links() }}
        </div>
    </div>


    {{-- TAMBAH DATA --}}
    @if($dataset->canEdit())
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-5">Tambah Data Baru</h2>

        <form method="POST" action="{{ route('dataset.data.store', $dataset) }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach($dataset->schema_json as $i => $key)
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            {{ $dataset->kolom[$i]['name'] }}
                        </label>

                        <input type="text"
                               name="data[{{ $key['name'] }}]"
                               class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                @endforeach
            </div>

            <div class="mt-5 flex justify-end">
                <button class="px-5 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-medium transition">
                    Tambah Data
                </button>
            </div>
        </form>
    </div>
    @endif


    {{-- FILTER DATASET --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-slate-800">Filter Dataset</h2>
            <span class="text-sm text-slate-500">{{ $dataset->filters->count() }} filter</span>
        </div>

        <form method="POST"
              action="{{ route('filters.store', $dataset) }}"
              class="flex flex-col md:flex-row gap-3 mb-5">
            @csrf

            <select name="kolom"
                    class="flex-1 h-11 rounded-xl border border-slate-300 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                <option value="">Pilih Kolom</option>

                @foreach($dataset->schema_json as $i => $key)
                    <option value="{{ $key['name'] }}">
                        {{ $dataset->kolom[$i]['name'] }}
                    </option>
                @endforeach
            </select>

            <button class="h-11 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium whitespace-nowrap transition">
                Tambah Filter
            </button>
        </form>

        <div class="space-y-2">
            @forelse($dataset->filters as $filter)
                <div class="flex items-center justify-between rounded-xl border border-slate-200 px-3 py-2 hover:bg-slate-50 transition">
                    <div class="text-sm font-medium text-slate-700">
                        {{ $filter->kolom }}
                    </div>

                    <form method="POST"
                          action="{{ route('filters.destroy', [$dataset, $filter]) }}"
                          onsubmit="return confirm('Hapus filter ini?')">
                        @csrf
                        @method('DELETE')

                        <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 border border-red-200 hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            @empty
                <div class="rounded-xl border border-dashed border-slate-300 py-8 text-center text-sm text-slate-500">
                    Belum ada filter.
                </div>
            @endforelse
        </div>
    </div>


    {{-- APPROVAL HISTORY --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-4 py-2.5 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">History Approval</h2>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($dataset->approvalLogs as $log)
                <div class="px-4 py-2.5 flex items-start justify-between gap-4 hover:bg-slate-50 transition">
                    <div>
                        <div class="font-medium text-slate-800">
                            {{ ucfirst($log->action) }} oleh {{ $log->user->nama }}
                        </div>

                        @if($log->catatan)
                            <div class="text-sm text-slate-500 mt-1">
                                {{ $log->catatan }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-sm text-slate-500">
                    Belum ada riwayat approval.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection