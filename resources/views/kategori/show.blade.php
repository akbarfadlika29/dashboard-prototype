@extends('layouts.app')

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

{{-- TAB BUTTON --}}
<div class="flex border-b border-gray-200 mb-8">
    <button onclick="showTab('dataset')" 
            id="btn-dataset"
            class="px-6 py-3 font-medium transition-all duration-200 ease-in-out text-emerald-600 border-b-2 border-emerald-600">
        Dataset
    </button>

    <button onclick="showTab('grafik')" 
            id="btn-grafik"
            class="px-6 py-3 font-medium transition-all duration-200 ease-in-out text-gray-500 hover:text-emerald-600">
        Grafik
    </button>
</div>

{{-- TAB DATASET --}}
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

{{-- TAB GRAFIK --}}
<div id="tab-grafik" class="hidden">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold mb-6">
            Dashboard Grafik {{ $kategori->nama }}
        </h3>

        <div class="h-80">
            <canvas id="dashboardChart"></canvas>
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

    if(tab === 'dataset') {
        document.getElementById('tab-dataset').classList.remove('hidden');
        document.getElementById('btn-dataset')
            .classList.add('border-b-2','border-emerald-600','text-emerald-600');
    } else {
        document.getElementById('tab-grafik').classList.remove('hidden');
        document.getElementById('btn-grafik')
            .classList.add('border-b-2','border-emerald-600','text-emerald-600');
    }
}

const ctx = document.getElementById('dashboardChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
        datasets: [{
            label: 'Total Data',
            data: [12, 19, 8, 15, 10],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>
@endpush