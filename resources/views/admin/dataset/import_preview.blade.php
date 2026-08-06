@extends('layouts.admin')

@push('styles')

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.11/css/jquery.dataTables.min.css">

<style>

table.dataTable thead th{

    background:#f8fafc !important;

    color:#334155;

    font-size:12px;

    text-transform:uppercase;

    letter-spacing:.5px;

    font-weight:700;

    border-bottom:1px solid #e2e8f0 !important;

}

table.dataTable tbody td{
    white-space: nowrap;
}

table.dataTable tbody tr:hover{

    background:#f0fdf4 !important;

}

table.dataTable tbody tr:nth-child(even){

    background:#fcfcfd;

}

table.dataTable td,
table.dataTable th{

    padding:12px 16px;

}

/* Tinggi area data */
div.dt-scroll-body{
    max-height:420px !important;
}

.dt-scroll-body::-webkit-scrollbar{

    height:10px;
    width:10px;

}

.dt-scroll-body::-webkit-scrollbar-thumb{

    background:#94a3b8;

    border-radius:20px;

}

.dt-scroll-body::-webkit-scrollbar-track{

    background:#f1f5f9;

}

/* Header tetap */
div.dt-scroll-head{
    overflow:hidden !important;
}

/* Toolbar */
div.dt-layout-row{
    margin-bottom:12px;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter{

    margin-top:16px;

    margin-bottom:18px;

    padding:14px 18px;

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:14px;

    font-size:.9rem;

}

.dataTables_wrapper{

    padding:0 16px 16px;

}

.dataTables_wrapper .dataTables_filter input{

    width:240px;

    height:42px;

    border:1px solid #cbd5e1;

    border-radius:10px;

    padding:0 14px;

}

.dataTables_wrapper .dataTables_filter input:focus{
    border-color:#10b981;
    box-shadow:0 0 0 4px rgb(16 185 129 / .15);
}

.dataTables_wrapper .dataTables_length select{

    height:42px;

    border:1px solid #cbd5e1;

    border-radius:10px;

    padding:0 14px;

}

.dataTables_wrapper .dataTables_paginate{

    margin-top:18px;

}

.dataTables_wrapper .paginate_button{

    min-width:38px;

    height:38px;

    line-height:26px;

    padding:6px 12px !important;

    border-radius:10px !important;

    transition:all .2s ease;

}

.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{

    background:#059669 !important;

    border:1px solid #059669 !important;

    color:#ffffff !important;

    font-weight:700;

    box-shadow:0 4px 12px rgba(5,150,105,.25);

}

.dataTables_wrapper .paginate_button:not(.current):hover{

    background:#f1f5f9 !important;

    border:1px solid #cbd5e1 !important;

    color:#334155 !important;

}

.dataTables_wrapper .paginate_button:not(.current):hover *{

    color:#334155 !important;

}

.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate{

    padding-top:18px;

    margin-top:18px;

    border-top:1px solid #e2e8f0;

    color:#64748b;

}

.dataTables_processing{

    border-radius:12px;

    padding:18px;

    background:white;

    box-shadow:0 10px 25px rgba(0,0,0,.1);

}

</style>

@endpush

@section('title', 'Preview Import')

@section('content')

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 md:p-10 mb-6">
    <div class="flex flex-col md:flex-row items-start justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Preview Import Dataset
            </h1>

            <p class="text-slate-500 mt-1">
                Periksa data CSV dan sesuaikan tipe data sebelum proses import dilakukan.
            </p>
        </div>

        <a href="{{ route('dataset.import') }}"
            class="inline-flex items-center gap-2
            px-5 py-2.5
            rounded-xl
            border border-slate-300
            bg-white
            text-slate-700
            shadow-sm
            hover:bg-slate-50
            hover:border-slate-400
            transition">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali
        </a>

    </div>
</div>

{{-- Preview Table --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 mb-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h2 class="text-xl font-semibold text-slate-800">
                Preview Data CSV
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Menampilkan isi file CSV yang akan diimport.
            </p>
        </div>

        <div class="flex gap-3">

            <div class="px-4 py-2 rounded-xl bg-emerald-50 border border-emerald-100">
                <div class="text-xs text-emerald-600">
                    Total Data
                </div>

                <div class="font-semibold text-emerald-700">
                    {{ number_format($totalRows) }}
                </div>
            </div>

            <div class="px-4 py-2 rounded-xl bg-blue-50 border border-blue-100">
                <div class="text-xs text-blue-600">
                    Total Kolom
                </div>

                <div class="font-semibold text-blue-700">
                    {{ $totalColumns }}
                </div>
            </div>

        </div>

    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">

        <div class="bg-white rounded-xl overflow-hidden">

            <table
                id="previewTable"
                class="display nowrap w-full text-sm">

                <thead class="bg-slate-100 sticky top-0 z-10">

                    <tr>

                        @foreach($headers as $header)
                            <th class="px-4 py-3 border-b border-slate-200 text-left font-semibold whitespace-nowrap">
                                {{ $header }}
                            </th>
                        @endforeach

                    </tr>

                </thead>

                <tbody>

                    @foreach($data as $row)

                        <tr class="hover:bg-slate-50 transition">

                            @foreach($headers as $i => $header)

                                <td>
                                    {{ $row[$i] ?? '' }}
                                </td>

                            @endforeach

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

</div> {{-- tutup card Preview CSV --}}

{{-- Mapping Tipe Data --}}
<form
    method="POST"
    action="{{ route('dataset.importStore') }}"
    x-data="{ importing:false }"
    @submit="importing=true"
>
    @csrf

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">

        {{-- hidden data lama --}}
        <input type="hidden" name="nama" value="{{ $request['nama'] }}">
        <input type="hidden" name="kategori_id" value="{{ $request['kategori_id'] }}">
        <input type="hidden" name="seksi_id" value="{{ $request['seksi_id'] }}">
        <input type="hidden" name="file_path" value="{{ $file_path }}">

        <div class="rounded-2xl border border-slate-200 overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">

                <h2 class="text-lg font-semibold text-slate-800">
                    Mapping Kolom
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Pastikan tipe data yang terdeteksi sudah sesuai.
                </p>

            </div>

            <div class="overflow-y-auto max-h-[420px]">

                <table class="min-w-full text-sm">

                    <thead class="sticky top-0 bg-slate-100 z-10">

                        <tr>

                            <th class="px-5 py-3 border-b border-slate-200 text-left">
                                Nama Kolom
                            </th>

                            <th class="px-5 py-3 border-b border-slate-200 text-left">
                                Tipe Data
                            </th>

                        </tr>

                    </thead>

                    <tbody>
                        @foreach($headers as $i => $header)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="border-b border-slate-200 px-5 py-4 align-middle">
                                    <div class="flex items-center gap-2">

                                        <span>
                                            {{ $header }}
                                        </span>

                                        <span class="text-[11px]
                                            px-2
                                            py-1
                                            rounded-full
                                            bg-emerald-100
                                            text-emerald-700">

                                            Auto Detect

                                        </span>

                                    </div>

                                    <input type="hidden"
                                        name="columns[{{ $i }}][name]"
                                        value="{{ $header }}">
                                </td>

                                <td class="border-b border-slate-200 px-5 py-4 align-middle">
                                    <select name="columns[{{ $i }}][type]"
                                            class="
                                                w-full
                                                rounded-xl
                                                border-2
                                                border-slate-300
                                                px-4
                                                py-2.5
                                                shadow-sm

                                                hover:border-slate-400

                                                focus:border-emerald-500
                                                focus:ring-4
                                                focus:ring-emerald-100

                                                transition">

                                        <option value="text"
                                            {{ $types[$i] == 'text' ? 'selected' : '' }}>
                                            Text
                                        </option>

                                        <option value="number"
                                            {{ $types[$i] == 'number' ? 'selected' : '' }}>
                                            Number
                                        </option>

                                        <option value="date"
                                            {{ $types[$i] == 'date' ? 'selected' : '' }}>
                                            Date
                                        </option>

                                        <option value="boolean"
                                            {{ $types[$i] == 'boolean' ? 'selected' : '' }}>
                                            Boolean
                                        </option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
        <div class="flex justify-between items-center mt-6 pt-6 border-t border-slate-200">

            <a href="{{ route('dataset.import') }}"
                class="
                inline-flex
                items-center
                gap-2

                px-5
                py-3

                rounded-xl

                border
                border-slate-300

                bg-white

                shadow-sm

                hover:bg-slate-50

                transition">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

            <button
                type="submit"

                :disabled="importing"

                :class="importing
                    ? 'bg-slate-400 cursor-not-allowed shadow-none'
                    : 'bg-emerald-600 hover:bg-emerald-700 hover:shadow-xl'"

                class="
                inline-flex
                items-center
                justify-center
                gap-2

                px-6
                py-3

                rounded-xl

                text-white

                font-semibold

                shadow-md

                transition-all
                duration-200">

                {{-- Icon normal --}}
                <i
                    x-show="!importing"
                    x-transition
                    class="fa-solid fa-file-import">
                </i>

                {{-- Spinner --}}
                <i
                    x-show="importing"
                    x-transition
                    class="fa-solid fa-spinner fa-spin">
                </i>

                {{-- Text --}}
                <span
                    x-text="importing
                        ? 'Mengimpor Dataset...'
                        : 'Import Dataset'">
                </span>

            </button>

        </div>
    </div>

</form>

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    $(function () {

        $('#previewTable').DataTable({

            pageLength:25,

            lengthMenu:[
                [10,25,50,100,-1],
                [10,25,50,100,"Semua"]
            ],

            scrollY:'420px',

            scrollX:true,

            scrollCollapse:true,

            fixedHeader:true,

            autoWidth:false,

            deferRender:true,

            stateSave:true,

            language:{
                search:"",
                searchPlaceholder:"Cari data...",
                lengthMenu:"Tampilkan _MENU_ data",
                info:"Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty:"Tidak ada data",
                zeroRecords:"Data tidak ditemukan",
                paginate:{
                    previous:"←",
                    next:"→"
                }
            },

            initComplete:function(){

                $('.dataTables_filter label').prepend(
                    '<i class="fa-solid fa-magnifying-glass text-slate-400 mr-2"></i>'
                );

            }

        });

    });

});

</script>

@endpush

@endsection