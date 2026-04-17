@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Grafik data')
@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach($seksi_id as $id)
        @if($id === $statistics['top_kecamatan']['seksi_id'])
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

        @if($id === $statistics['nikah_lokasi']['seksi_id'])
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
        @endforeach



        {{-- ========================= --}}
        {{-- CHART 3 (Placeholder) --}}
        {{-- ========================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-center text-gray-400">
            Chart berikutnya
        </div>

    </div>
@endsection

@push('scripts')
<script>
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