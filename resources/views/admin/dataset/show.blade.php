@extends('layouts.admin')

@section('content')

<h1 class="text-xl font-bold mb-4">
    {{ $dataset->nama }}
</h1>

{{-- STATUS --}}
<div class="mb-4">
    Status:
    <span class="font-semibold">{{ $dataset->status }}</span>
</div>

{{-- ACTION --}}
<div class="mb-4 flex gap-2 flex-wrap">

    @if($dataset->canEdit())

        <form method="POST" action="{{ route('dataset.submit', $dataset) }}">
            @csrf
            <button class="bg-blue-500 text-white px-3 py-1 rounded">
                Ajukan Dataset
            </button>
        </form>

        {{-- Requirement terpenuhi:
             - Hapus dataset saat status draft / rejected --}}
        <form method="POST"
              action="{{ route('dataset.destroy', $dataset) }}"
              onsubmit="return confirm('Yakin ingin menghapus dataset ini?')">
            @csrf
            @method('DELETE')

            <button class="bg-red-600 text-white px-3 py-1 rounded">
                Hapus Dataset
            </button>
        </form>

    @endif

    @if(auth()->user()->role == 'kepala_seksi' && $dataset->status == 'pending')

        <form method="POST" action="/admin-dataset/{{ $dataset->id }}/approve" class="flex gap-2">
            @csrf
            <input name="catatan"
                   placeholder="Catatan"
                   class="border px-2 py-1 rounded">

            <button class="bg-green-500 text-white px-3 py-1 rounded">
                Approve
            </button>
        </form>

        <form method="POST" action="/admin-dataset/{{ $dataset->id }}/reject" class="flex gap-2">
            @csrf
            <input name="catatan"
                   placeholder="Alasan reject"
                   class="border px-2 py-1 rounded">

            <button class="bg-red-500 text-white px-3 py-1 rounded">
                Reject
            </button>
        </form>

    @endif

</div>

{{-- STRUKTUR KOLOM --}}
<div class="bg-white p-4 rounded shadow mb-6">

    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold">Struktur Kolom</h3>
    </div>

    @foreach($dataset->schema_json as $i => $key)

        <div class="border rounded p-3 mb-3">

            {{-- Requirement terpenuhi:
                 - Edit kolom --}}
            <form method="POST"
                  action="{{ route('columns.update', [$dataset, $i]) }}"
                  class="grid grid-cols-12 gap-2 mb-2">
                @csrf
                @method('PUT')

                <div class="col-span-5">
                    <label class="text-sm block mb-1">Nama Kolom</label>
                    <input type="text"
                           name="label"
                           value="{{ $dataset->kolom[$i]['name'] }}"
                           class="border p-2 w-full rounded">
                </div>

                <div class="col-span-5">
                    <label class="text-sm block mb-1">Key Kolom</label>
                    <input type="text"
                           name="key"
                           value="{{ $key['name'] }}"
                           class="border p-2 w-full rounded">
                </div>

                <div class="col-span-2 flex items-end">
                    <button class="bg-yellow-500 text-white px-3 py-2 rounded w-full">
                        Update
                    </button>
                </div>
            </form>

            {{-- Requirement terpenuhi:
                 - Hapus kolom walaupun sudah punya data --}}
            <form method="POST"
                  action="{{ route('columns.destroy', [$dataset, $i]) }}"
                  onsubmit="return confirm('Hapus kolom ini? Semua data pada kolom ini juga akan ikut terhapus.')">
                @csrf
                @method('DELETE')

                <button class="text-red-600 text-sm">
                    Hapus Kolom
                </button>
            </form>

        </div>

    @endforeach

</div>

{{-- DATA DATASET --}}
<div class="bg-white p-4 rounded shadow mb-6">

    <h3 class="font-semibold mb-4">Data Dataset</h3>

    @foreach($data as $row)

        <div class="border rounded p-4 mb-4">

            {{-- Requirement terpenuhi:
                 - Edit data dataset --}}
            <form method="POST"
                  action="{{ route('rows.update', [$dataset, $row]) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-3">

                    @foreach($dataset->schema_json as $i => $key)

                        @php
                            $field = is_array($key)
                                ? ($key['key'] ?? $key['name'])
                                : $key;
                        @endphp

                        <div>
                            <label class="block text-sm mb-1">
                                {{ $dataset->kolom[$i]['name'] }}
                            </label>

                            <input type="text"
                                name="{{ $field }}"
                                value="{{ $row->data_json[$field] ?? '' }}"
                                class="border p-2 w-full rounded">
                        </div>

                    @endforeach

                </div>

                <div class="flex gap-2 mt-4">
                    <button class="bg-yellow-500 text-white px-3 py-2 rounded">
                        Update Data
                    </button>
            </form>

                    {{-- Requirement terpenuhi:
                         - Hapus data dataset --}}
                    <form method="POST"
                          action="{{ route('rows.destroy', [$dataset, $row]) }}"
                          onsubmit="return confirm('Hapus data ini?')">
                        @csrf
                        @method('DELETE')

                        <button class="bg-red-600 text-white px-3 py-2 rounded">
                            Hapus Data
                        </button>
                    </form>
                </div>

        </div>

    @endforeach

</div>

{{-- TAMBAH DATA --}}
@if($dataset->canEdit())

<div class="bg-white p-4 rounded shadow mb-6">

    <form method="POST" action="{{ route('dataset.data.store', $dataset) }}">
        @csrf

        <h3 class="font-semibold mb-4">Tambah Data</h3>

        @foreach($dataset->schema_json as $i => $key)

            <div class="mb-3">
                <label class="block mb-1">
                    {{ $dataset->kolom[$i]['name'] }}
                </label>

                <input type="text"
                       name="data[{{ $key['name'] }}]"
                       class="border p-2 w-full rounded">
            </div>

        @endforeach

        <button class="bg-green-600 text-white px-4 py-2 rounded mt-2">
            Tambah Data
        </button>
    </form>

</div>

@endif

{{-- FILTER DATASET --}}
<div class="bg-white rounded shadow p-4 mt-6">
        <h2 class="font-semibold text-lg mb-4">Filter Dataset</h2>

        {{-- tambah filter --}}
        <form method="POST"
            action="{{ route('filters.store', $dataset) }}"
            class="flex gap-2 mb-4">
            @csrf

            <select name="kolom" class="border p-2 rounded w-full" required>
                <option value="">Pilih Kolom</option>

                @foreach($dataset->schema_json as $i => $key)
                    <option value="{{ $key['name'] }}">
                        {{ $dataset->kolom[$i]['name'] }}
                    </option>
                @endforeach
            </select>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Tambah Filter
            </button>
        </form>

        {{-- daftar filter --}}
        @forelse($dataset->filters as $filter)
            <div class="flex items-center justify-between border rounded p-3 mb-2">
                <div>
                    @php
                        $index = array_search($filter->kolom, $dataset->schema_json);
                    @endphp

                    <span class="font-medium">
                        {{ $index !== false ? $dataset->kolom[$index]['name'] : $filter->kolom }}
                    </span>
                </div>

                {{-- hapus filter --}}
                <form method="POST"
                    action="{{ route('filters.destroy', [$dataset, $filter]) }}"
                    onsubmit="return confirm('Hapus filter ini?')">
                    @csrf
                    @method('DELETE')

                    <button class="text-red-600 text-sm">
                        Hapus
                    </button>
                </form>
            </div>
        @empty
            <div class="text-gray-500 text-sm">
                Belum ada filter
            </div>
        @endforelse
    </div>

{{-- APPROVAL HISTORY --}}
<div class="mt-6 bg-white p-4 rounded shadow">

    <h3 class="font-semibold mb-3">History Approval</h3>

    @foreach($dataset->approvalLogs as $log)
        <div class="border-b py-2">
            <b>{{ $log->action }}</b> - {{ $log->user->nama }} <br>
            <small>{{ $log->catatan }}</small>
        </div>
    @endforeach

</div>

@endsection