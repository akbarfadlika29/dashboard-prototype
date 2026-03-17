@extends('layouts.app')

@section('title', $dataset->nama)

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

<style>

.filter-select-wrapper{
    width:220px;
}

.ts-wrapper{
    width:100%;
}

.ts-control{
    height:40px;
    min-height:40px;
    border-radius:0.5rem;
    border:1px solid #d1d5db;
    padding:0 12px;
    display:flex;
    align-items:center;
    font-size:14px;
}

.ts-control input{
    font-size:14px !important;
}

.ts-dropdown{
    border-radius:0.5rem;
}

.ts-control:hover{
    border-color:#9ca3af;
}

.ts-wrapper.focus .ts-control{
    border-color:#2563eb;
    box-shadow:0 0 0 1px #2563eb;
}

</style>
@endpush



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



<div class="flex flex-wrap items-center justify-between gap-4 mb-4">

@if($filters->count())

<form method="GET" class="flex flex-wrap items-center gap-3">

@foreach($filters as $filter)

<div class="filter-select-wrapper">

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
class="h-10 px-4 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
Filter
</button>


<a href="{{ route('dataset.show', [$dataset->slug ?? $dataset->id, 'per_page' => $perPage]) }}"
class="h-10 px-4 flex items-center bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition">
Reset
</a>

</form>

@endif



<form method="GET" class="flex items-center gap-2">

@foreach(request()->except('per_page') as $key => $value)
<input type="hidden" name="{{ $key }}" value="{{ $value }}">
@endforeach

<span class="text-sm text-gray-600">Tampilkan</span>

<select name="per_page"
onchange="this.form.submit()"
class="border border-gray-300 rounded-lg px-3 py-2 text-sm">

<option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
<option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
<option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
<option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>

</select>

<span class="text-sm text-gray-600">baris</span>

</form>

</div>



<p class="text-sm text-gray-500 mb-3">
Menampilkan
{{ $datasetData->firstItem() ?? 0 }}
-
{{ $datasetData->lastItem() ?? 0 }}
dari
{{ $datasetData->total() }}
data
</p>



<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 overflow-x-auto">

<table class="min-w-full text-sm border-collapse">

<thead>
<tr class="bg-gray-100 text-left">

<th class="px-4 py-2 border font-semibold text-center w-16">No</th>

@foreach($dataset->kolom as $column)
<th class="px-4 py-2 border font-semibold whitespace-nowrap">
{{ $column }}
</th>
@endforeach

</tr>
</thead>

<tbody>

@forelse($datasetData as $index => $row)

<tr class="hover:bg-gray-50">

<td class="px-4 py-2 border text-center">
{{ $datasetData->firstItem() + $index }}
</td>

@foreach($dataset->schema_json as $column)
<td class="px-4 py-2 border whitespace-nowrap">
{{ $row->data_json[$column] ?? '-' }}
</td>
@endforeach

</tr>

@empty

<tr>
<td colspan="{{ count($dataset->schema_json) + 1 }}"
class="px-4 py-6 text-center text-gray-500">
Belum ada data tersedia.
</td>
</tr>

@endforelse

</tbody>

</table>

</div>



<p class="text-sm text-gray-500 mt-3">
Menampilkan
{{ $datasetData->firstItem() ?? 0 }}
-
{{ $datasetData->lastItem() ?? 0 }}
dari
{{ $datasetData->total() }}
data
</p>



@if ($datasetData->hasPages())

<div class="flex justify-end mt-4">

<div class="flex items-center space-x-1">

@if ($datasetData->onFirstPage())
<span class="px-3 py-1 border rounded text-gray-400">‹</span>
@else
<a href="{{ $datasetData->previousPageUrl() }}"
class="px-3 py-1 border rounded hover:bg-gray-100">‹</a>
@endif


@php
$start = max($datasetData->currentPage() - 2, 1);
$end = min($datasetData->currentPage() + 2, $datasetData->lastPage());
@endphp


@if($start > 1)
<a href="{{ $datasetData->url(1) }}" class="px-3 py-1 border rounded">1</a>
@if($start > 2)
<span class="px-2">...</span>
@endif
@endif


@for ($page = $start; $page <= $end; $page++)

@if ($page == $datasetData->currentPage())
<span class="px-3 py-1 bg-blue-600 text-white rounded">{{ $page }}</span>
@else
<a href="{{ $datasetData->url($page) }}"
class="px-3 py-1 border rounded hover:bg-gray-100">{{ $page }}</a>
@endif

@endfor


@if($end < $datasetData->lastPage())

@if($end < $datasetData->lastPage() - 1)
<span class="px-2">...</span>
@endif

<a href="{{ $datasetData->url($datasetData->lastPage()) }}"
class="px-3 py-1 border rounded">
{{ $datasetData->lastPage() }}
</a>

@endif


@if ($datasetData->hasMorePages())
<a href="{{ $datasetData->nextPageUrl() }}"
class="px-3 py-1 border rounded hover:bg-gray-100">›</a>
@else
<span class="px-3 py-1 border rounded text-gray-400">›</span>
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

        placeholder: "Cari " + label.replace('_',' '),
        items: [],

        render: {
            item: function(data, escape) {
                return `<div>${escape(cleanText(data.text))}</div>`;
            },
            option: function(data, escape) {
                return `<div>${escape(cleanText(data.text))}</div>`;
            }
        }

    });

    // 🔥 paksa clean setelah select
    ts.on('item_add', function(value, item){
        item.innerText = cleanText(item.innerText);
    });

});

</script>

@endpush