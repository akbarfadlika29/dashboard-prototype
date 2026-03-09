@extends('layouts.app')

@section('title', $dataset->nama)

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-semibold">
            {{ $dataset->nama }}
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            {{ $dataset->deskripsi }}
        </p>
    </div>

    <a href="{{ route('kategori.show', $dataset->kategori_id) }}"
       class="text-sm px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
        ← Kembali
    </a>
</div>


{{-- TOOLBAR FILTER --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">

    {{-- FILTER --}}
    <form method="GET" class="flex flex-wrap items-center gap-2">

        @foreach($filters as $filter)

            <select name="{{ $filter->kolom }}"
                    class="border border-gray-300 rounded-lg px-3 py-1 text-sm">

                <option value="">
                    Semua {{ ucfirst($filter->kolom) }}
                </option>

                @foreach($filterOptions[$filter->kolom] as $option)

                    <option value="{{ $option }}"
                        {{ request($filter->kolom) == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>

                @endforeach

            </select>

        @endforeach


        <button type="submit"
                class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
            Filter
        </button>


        {{-- RESET FILTER --}}
        <a href="{{ route('dataset.show', [$dataset->slug ?? $dataset->id, 'per_page' => $perPage]) }}"
           class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition">
            Reset
        </a>

    </form>



    {{-- PER PAGE --}}
    <form method="GET" class="flex items-center">

        {{-- Pertahankan filter --}}
        @foreach(request()->except('per_page') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <label class="text-sm text-gray-600 mr-2">
            Tampilkan
        </label>

        <select name="per_page"
                onchange="this.form.submit()"
                class="border border-gray-300 rounded-lg px-2 py-1 text-sm">

            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>

        </select>

        <span class="text-sm text-gray-600 ml-1">
            baris
        </span>

    </form>

</div>



{{-- INFO DATA --}}
<p class="text-sm text-gray-500 mb-3">
    Menampilkan
    {{ $datasetData->firstItem() ?? 0 }}
    -
    {{ $datasetData->lastItem() ?? 0 }}
    dari
    {{ $datasetData->total() }}
    data
</p>



{{-- TABEL --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-x-auto">

    <table class="min-w-full text-sm border-collapse">

        <thead>
            <tr class="bg-gray-100 text-left">

                @foreach($dataset->schema_json as $column)

                    <th class="px-4 py-2 border font-semibold whitespace-nowrap">
                        {{ ucwords(str_replace('_', ' ', $column)) }}
                    </th>

                @endforeach

            </tr>
        </thead>

        <tbody>

            @forelse($datasetData as $row)

                <tr class="hover:bg-gray-50">

                    @foreach($dataset->schema_json as $column)

                        <td class="px-4 py-2 border whitespace-nowrap">
                            {{ $row->data_json[$column] ?? '-' }}
                        </td>

                    @endforeach

                </tr>

            @empty

                <tr>
                    <td colspan="{{ count($dataset->schema_json) }}"
                        class="px-4 py-6 text-center text-gray-500">
                        Belum ada data tersedia.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>



{{-- PAGINATION --}}
<div class="flex justify-between items-center mt-6">

    <p class="text-sm text-gray-500">
        Menampilkan
        {{ $datasetData->firstItem() ?? 0 }}
        -
        {{ $datasetData->lastItem() ?? 0 }}
        dari
        {{ $datasetData->total() }}
        data
    </p>


    @if ($datasetData->hasPages())

    <div class="flex items-center space-x-1">

        {{-- PREVIOUS --}}
        @if ($datasetData->onFirstPage())

            <span class="px-3 py-1 text-sm rounded-lg border border-gray-300 bg-gray-200 text-gray-400">
                ‹
            </span>

        @else

            <a href="{{ $datasetData->previousPageUrl() }}"
               class="px-3 py-1 text-sm rounded-lg border border-gray-300 bg-gray-200 text-gray-700 hover:bg-gray-300">
                ‹
            </a>

        @endif



        {{-- PAGE NUMBER --}}
        @foreach ($datasetData->getUrlRange(1, $datasetData->lastPage()) as $page => $url)

            @if ($page == $datasetData->currentPage())

                <span class="px-3 py-1 text-sm rounded-lg bg-blue-600 text-white font-semibold">
                    {{ $page }}
                </span>

            @else

                <a href="{{ $url }}"
                   class="px-3 py-1 text-sm rounded-lg border border-gray-300 bg-gray-200 text-gray-700 hover:bg-gray-300">
                    {{ $page }}
                </a>

            @endif

        @endforeach



        {{-- NEXT --}}
        @if ($datasetData->hasMorePages())

            <a href="{{ $datasetData->nextPageUrl() }}"
               class="px-3 py-1 text-sm rounded-lg border border-gray-300 bg-gray-200 text-gray-700 hover:bg-gray-300">
                ›
            </a>

        @else

            <span class="px-3 py-1 text-sm rounded-lg border border-gray-300 bg-gray-200 text-gray-400">
                ›
            </span>

        @endif

    </div>

    @endif

</div>

@endsection