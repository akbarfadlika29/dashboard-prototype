@extends('layouts.public')

@section('title', $dataset->nama)

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

<style>
.filter-select-wrapper{ width:220px; }
@media (max-width:640px){
    .filter-select-wrapper{ width:100%; }
}

.ts-wrapper{ width:100%; }

.ts-control{
    min-height:42px;
    border-radius:0.85rem;
    border:1px solid #d1d5db;
    padding:0 12px;
    display:flex;
    align-items:center;
    font-size:14px;
    box-shadow:none;
}

.dark .ts-control{
    background:#0f172a;
    border-color:#334155;
    color:#fff;
}

.ts-control input{ font-size:14px !important; }

.ts-dropdown{
    border-radius:0.85rem;
    overflow:hidden;
    border:1px solid #e5e7eb;
}

.dark .ts-dropdown{
    background:#0f172a;
    border-color:#334155;
    color:#fff;
}

.ts-wrapper.focus .ts-control{
    border-color:#059669;
    box-shadow:0 0 0 3px rgba(5,150,105,.12);
}
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="mb-8">
    <div class="rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white p-6 sm:p-8 shadow-lg relative overflow-hidden">

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">

            <div class="max-w-3xl">
                <p class="text-sm uppercase tracking-widest text-white/80 mb-2">
                    Detail Dataset
                </p>

                <h1 class="text-2xl sm:text-3xl font-bold leading-tight">
                    {{ $dataset->nama }}
                </h1>

                <p class="text-sm sm:text-base text-white/90 mt-2">
                    {{ $dataset->deskripsi }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                <a href="{{ route('dataset.export.pdf', [$dataset->slug ?? $dataset->id] + request()->query()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-500/90 hover:bg-red-600 text-white text-sm font-medium transition">
                    <i class="fa-solid fa-file-pdf"></i>
                    PDF
                </a>

                <a href="{{ route('dataset.export.excel', [$dataset->slug ?? $dataset->id] + request()->query()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-500/90 hover:bg-emerald-600 text-white text-sm font-medium transition">
                    <i class="fa-solid fa-file-excel"></i>
                    Excel
                </a>

                <a href="{{ route('kategori.show', $dataset->kategori_id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/15 hover:bg-white/25 border border-white/30 text-sm font-medium transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>

            </div>

        </div>

        <div class="absolute -right-8 -bottom-8 text-white/10 text-[150px] sm:text-[190px]">
            <i class="fa-solid fa-table"></i>
        </div>

    </div>
</section>

{{-- FILTER BAR --}}
<div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 p-5 shadow-sm mb-6">

    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-5">

        {{-- LEFT --}}
        @if($filters->count())
        <form method="GET" class="flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">

                @foreach($filters as $filter)
                <div class="filter-select-wrapper xl:w-auto">
                    <select name="{{ $filter->kolom }}" class="filter-select w-full">
                        <option value=""></option>

                        @foreach($filterOptions[$filter->kolom] as $option)
                        <option value="{{ $option }}"
                            {{ request($filter->kolom) == $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                        @endforeach

                    </select>
                </div>
                @endforeach

                <button type="submit"
                        class="h-[42px] px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition">
                    Filter
                </button>

                <a href="{{ route('dataset.show', [$dataset->slug ?? $dataset->id, 'per_page' => $perPage]) }}"
                   class="h-[42px] px-4 rounded-xl bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-sm flex items-center justify-center transition">
                    Reset
                </a>

            </div>
        </form>
        @endif

        {{-- RIGHT --}}
        <form method="GET" class="flex items-center gap-2">

            @foreach(request()->except('per_page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <span class="text-sm text-gray-500 dark:text-slate-400 whitespace-nowrap">Tampilkan</span>

            <select name="per_page"
                    onchange="this.form.submit()"
                    class="h-[42px] px-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-sm">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
            </select>

            <span class="text-sm text-gray-500 dark:text-slate-400 whitespace-nowrap">baris</span>

        </form>

    </div>

</div>

{{-- INFO --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
    <p class="text-sm text-gray-500 dark:text-slate-400">
        Menampilkan {{ $datasetData->firstItem() ?? 0 }} - {{ $datasetData->lastItem() ?? 0 }}
        dari {{ $datasetData->total() }} data
    </p>
</div>

{{-- TABLE --}}
<div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden">

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">

            <thead class="bg-gray-50 dark:bg-slate-900">
                <tr>
                    <th class="px-4 py-3 border-b text-center font-semibold w-16">No</th>

                    @foreach($dataset->kolom as $column)
                    <th class="px-4 py-3 border-b text-left font-semibold whitespace-nowrap">
                        {{ $column['name'] }}
                    </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @forelse($datasetData as $index => $row)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-900/60 transition">

                    <td class="px-4 py-3 border-b text-center text-gray-500">
                        {{ $datasetData->firstItem() + $index }}
                    </td>

                    @foreach($dataset->schema_json as $column)
                    <td class="px-4 py-3 border-b whitespace-nowrap">
                        {{ $row->data_json[$column['name']] ?? '-' }}
                    </td>
                    @endforeach

                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($dataset->schema_json) + 1 }}"
                        class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                        Belum ada data tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

{{-- FOOT INFO --}}
<p class="text-sm text-gray-500 dark:text-slate-400 mt-4">
    Menampilkan {{ $datasetData->firstItem() ?? 0 }} - {{ $datasetData->lastItem() ?? 0 }}
    dari {{ $datasetData->total() }} data
</p>

{{-- PAGINATION --}}
@if ($datasetData->hasPages())
<div class="flex justify-end mt-5">

    <div class="flex flex-wrap items-center gap-2">

        @if ($datasetData->onFirstPage())
            <span class="px-3 py-2 rounded-xl border text-gray-400">‹</span>
        @else
            <a href="{{ $datasetData->previousPageUrl() }}"
               class="px-3 py-2 rounded-xl border hover:bg-gray-100 dark:hover:bg-slate-700 transition">‹</a>
        @endif

        @php
            $start = max($datasetData->currentPage() - 2, 1);
            $end   = min($datasetData->currentPage() + 2, $datasetData->lastPage());
        @endphp

        @if($start > 1)
            <a href="{{ $datasetData->url(1) }}" class="px-3 py-2 rounded-xl border">1</a>
            @if($start > 2)
                <span class="px-1">...</span>
            @endif
        @endif

        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $datasetData->currentPage())
                <span class="px-3 py-2 rounded-xl bg-emerald-600 text-white">{{ $page }}</span>
            @else
                <a href="{{ $datasetData->url($page) }}"
                   class="px-3 py-2 rounded-xl border hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                    {{ $page }}
                </a>
            @endif
        @endfor

        @if($end < $datasetData->lastPage())
            @if($end < $datasetData->lastPage() - 1)
                <span class="px-1">...</span>
            @endif

            <a href="{{ $datasetData->url($datasetData->lastPage()) }}"
               class="px-3 py-2 rounded-xl border">
                {{ $datasetData->lastPage() }}
            </a>
        @endif

        @if ($datasetData->hasMorePages())
            <a href="{{ $datasetData->nextPageUrl() }}"
               class="px-3 py-2 rounded-xl border hover:bg-gray-100 dark:hover:bg-slate-700 transition">›</a>
        @else
            <span class="px-3 py-2 rounded-xl border text-gray-400">›</span>
        @endif

    </div>

</div>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>
function cleanText(text){
    return (text || '')
        .replace(/\u00A0/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();
}

document.querySelectorAll('.filter-select').forEach(function(select){

    let label = select.getAttribute('name');

    let ts = new TomSelect(select,{
        create:false,
        allowEmptyOption:true,
        maxOptions:null,
        searchField:['text'],
        sortField:[],
        dropdownDirection:"down",
        placeholder:"Cari " + label.replace('_',' '),
        items:[],
        render:{
            item:function(data, escape){
                return `<div>${escape(cleanText(data.text))}</div>`;
            },
            option:function(data, escape){
                return `<div>${escape(cleanText(data.text))}</div>`;
            }
        }
    });

    ts.on('item_add', function(value, item){
        item.innerText = cleanText(item.innerText);
    });
});
</script>
@endpush