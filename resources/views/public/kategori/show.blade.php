@extends('layouts.public')

@section('title', $kategori->nama . ' - Portal Data & Informasi')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-semibold">
            {{ $kategori->nama }}
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Dataset dan dashboard grafik kategori ini
        </p>
    </div>

    <a href="{{ route('kategori.index') }}"
       class="text-sm px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
    </a>
</div>



{{-- TAB --}}
<div class="flex border-b border-gray-200 mb-8">

    <button onclick="showTab('dataset')" 
            id="btn-dataset"
            class="px-6 py-3 font-medium text-emerald-600 border-b-2 border-emerald-600">
        Dataset
    </button>

    <button onclick="showTab('grafik')" 
            id="btn-grafik"
            class="px-6 py-3 font-medium text-gray-500 hover:text-emerald-600">
        Grafik
    </button>

</div>



{{-- ========================= --}}
{{-- TAB DATASET --}}
{{-- ========================= --}}
<div id="tab-dataset">

    <div class="grid gap-6">

        @forelse($dataset as $item)

            <a href="{{ route('dataset.show', $item->id) }}" class="block">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">

                    <h3 class="text-lg font-semibold">
                        {{ $item->nama }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        {{ $item->deskripsi }}
                    </p>

                </div>

            </a>

        @empty

            <p class="text-gray-500">
                Belum ada dataset pada kategori ini.
            </p>

        @endforelse

    </div>

</div>



{{-- ========================= --}}
{{-- TAB GRAFIK --}}
{{-- ========================= --}}
<div id="tab-grafik" class="hidden">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @if($kategori->id === $statistics['top_kecamatan']['kategori_id'])
        {{-- ========================= --}}
        {{-- CHART 1 --}}
        {{-- ========================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <h4 class="text-sm font-semibold mb-4">
                5 Kecamatan Perkawinan Terbanyak (2025)
            </h4>

            <div class="h-64">
                <canvas id="chartTopKecamatan"></canvas>
            </div>

        </div>
        @endif

        @if($kategori->id === $statistics['nikah_lokasi']['kategori_id'])
        {{-- ========================= --}}
        {{-- CHART 2 --}}
        {{-- ========================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <h4 class="text-sm font-semibold mb-4">
                Perbandingan Nikah Dalam Kantor & Luar Kantor (2025)
            </h4>

            <div class="h-64">
                <canvas id="chartLokasiNikah"></canvas>
            </div>

        </div>
        @endif



        {{-- ========================= --}}
        {{-- CHART 3 (Placeholder) --}}
        {{-- ========================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-center text-gray-400">
            Chart berikutnya
        </div>

    </div>

</div>

@endsection



@push('scripts')
<script>

function showTab(tab) {

    document.getElementById('tab-dataset').classList.add('hidden');
    document.getElementById('tab-grafik').classList.add('hidden');

    document.getElementById('btn-dataset')
        .classList.remove('border-b-2','border-emerald-600','text-emerald-600');

    document.getElementById('btn-grafik')
        .classList.remove('border-b-2','border-emerald-600','text-emerald-600');


    if(tab === 'dataset'){

        document.getElementById('tab-dataset').classList.remove('hidden');

        document.getElementById('btn-dataset')
            .classList.add('border-b-2','border-emerald-600','text-emerald-600');

    } else {

        document.getElementById('tab-grafik').classList.remove('hidden');

        document.getElementById('btn-grafik')
            .classList.add('border-b-2','border-emerald-600','text-emerald-600');

    }

}



{{-- ========================= --}}
{{-- DATA DARI CONTROLLER --}}
{{-- ========================= --}}
const topKecamatan = @json($statistics['top_kecamatan'] ?? null);
const lokasiNikah = @json($statistics['nikah_lokasi'] ?? null);



{{-- ========================= --}}
{{-- CHART 1 : TOP KECAMATAN --}}
{{-- ========================= --}}
const ctx1 = document.getElementById('chartTopKecamatan');

if(ctx1 && topKecamatan){

    new Chart(ctx1, {

        type: 'bar',

        data: {
            labels: topKecamatan.labels,
            datasets: [{
                label: 'Jumlah Perkawinan',
                data: topKecamatan.values,
                borderWidth: 1
            }]
        },

        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false
        }

    });

}



{{-- ========================= --}}
{{-- CHART 2 : LOKASI NIKAH --}}
{{-- ========================= --}}
const ctx2 = document.getElementById('chartLokasiNikah');

if(ctx2 && lokasiNikah){

    new Chart(ctx2, {

        type: 'pie',

        data: {
            labels: lokasiNikah.labels,
            datasets: [{
                data: lokasiNikah.values
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false
        }

    });

}

</script>
@endpush