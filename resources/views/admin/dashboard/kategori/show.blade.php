@extends('layouts.admin')

@section('title', $kategori->nama . ' - Portal Data & Informasi')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

{{-- HERO HEADER --}}
<section class="mb-8">
    <div class="rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white p-6 sm:p-8 shadow-lg relative overflow-hidden">

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-5">

            <div class="max-w-2xl">
                <p class="text-sm uppercase tracking-widest text-white/80 mb-2">
                    Detail Kategori
                </p>

                <h2 class="text-2xl sm:text-3xl font-bold leading-tight">
                    {{ $kategori->nama }}
                </h2>

                <p class="text-sm sm:text-base text-white/90 mt-2">
                    Dataset dan dashboard grafik kategori ini
                </p>
            </div>

            <div>
                <a href="{{ route('admin.dashboard.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/15 hover:bg-white/25 border border-white/30 backdrop-blur text-sm font-medium transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>
            </div>

        </div>

        <div class="absolute -right-8 -bottom-8 text-white/10 text-[140px] sm:text-[180px]">
            <i class="fa-solid fa-layer-group"></i>
        </div>

    </div>
</section>

{{-- TAB NAV --}}
<div class="mb-8">
    <div class="inline-flex bg-slate-100 border border-slate-200 p-1 rounded-2xl gap-1">

        <button onclick="showTab('dataset')"
                id="btn-dataset"
                class="tab-btn active-tab">
            <i class="fa-solid fa-table-list mr-2"></i>Dataset
        </button>

        <button onclick="showTab('grafik')"
                id="btn-grafik"
                class="tab-btn">
            <i class="fa-solid fa-chart-pie mr-2"></i>Grafik
        </button>

    </div>
</div>

{{-- ===================== --}}
{{-- TAB DATASET --}}
{{-- ===================== --}}
<div id="tab-dataset">

    @if($dataset->count())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @foreach($dataset as $item)
                <a href="{{ route('admin.dashboard.dataset.show', $item->id) }}" class="block group">

                    <div class="bg-white
            border border-slate-200
            rounded-2xl
            p-6
            h-full
            shadow-sm
            hover:border-emerald-300
            hover:shadow-lg
            hover:-translate-y-1
            transition-all duration-300">

                        <div class="flex items-start gap-4">

                            <div class="w-12 h-12
            rounded-xl
            bg-emerald-50
            flex items-center justify-center
            shrink-0
            group-hover:scale-110
            transition-all duration-300">
                                <i class="fa-solid fa-database text-emerald-600"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-slate-800 leading-snug group-hover:text-emerald-700 transition-colors">
                                    {{ $item->nama }}
                                </h3>

                                <p class="text-sm text-slate-500 mt-2 line-clamp-3">
                                    {{ $item->deskripsi }}
                                </p>

                                <div class="mt-4 text-sm font-medium text-emerald-600 inline-flex items-center gap-2">
                                    Lihat Detail
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </div>
                            </div>

                        </div>

                    </div>

                </a>
            @endforeach

        </div>
    @else
        <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-10 text-center shadow-sm">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 flex items-center justify-center mb-4">
                <i class="fa-solid fa-folder-open text-gray-400"></i>
            </div>
            <h3 class="font-semibold text-lg">Belum Ada Dataset</h3>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-2">
                Dataset untuk kategori ini belum tersedia.
            </p>
        </div>
    @endif

</div>

{{-- ===================== --}}
{{-- TAB GRAFIK --}}
{{-- ===================== --}}
<div id="tab-grafik" class="hidden">

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        @if(isset($statistics['top_kecamatan']) && $kategori->id === $statistics['top_kecamatan']['kategori_id'])
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold">5 Kecamatan Perkawinan Terbanyak</h4>
                <span class="text-xs px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600">2025</span>
            </div>

            <div class="h-72">
                <canvas id="chartTopKecamatan"></canvas>
            </div>
        </div>
        @endif

        @if(isset($statistics['nikah_lokasi']) && $kategori->id === $statistics['nikah_lokasi']['kategori_id'])
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold">Nikah Dalam & Luar Kantor</h4>
                <span class="text-xs px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600">2025</span>
            </div>

            <div class="h-72">
                <canvas id="chartLokasiNikah"></canvas>
            </div>
        </div>
        @endif

        @if(
            !isset($statistics['top_kecamatan']) &&
            !isset($statistics['nikah_lokasi'])
        )
        <div class="xl:col-span-2 bg-white rounded-2xl border border-dashed border-slate-300 p-10 text-center shadow-sm">
            <i class="fa-solid fa-chart-line text-3xl text-gray-300 mb-3"></i>
            <h3 class="font-semibold">Belum Ada Grafik</h3>
            <p class="text-sm text-gray-500 dark:text-slate-400 mt-2">
                Grafik untuk kategori ini belum tersedia.
            </p>
        </div>
        @endif

    </div>

</div>

@endsection

@push('styles')
<style>
.tab-btn{
    padding: .7rem 1rem;
    border-radius: 1rem;
    font-size: .95rem;
    font-weight: 600;
    color:#64748b;
    transition:all .25s ease;
}

.tab-btn:hover{
    color:#059669;
    background:#ecfdf5;
}

.active-tab{
    background:white;
    color:#059669 !important;
    box-shadow:0 2px 6px rgba(15,23,42,.08);
}
</style>
@endpush

@push('scripts')
<script>
function showTab(tab){

    document.getElementById('tab-dataset').classList.add('hidden');
    document.getElementById('tab-grafik').classList.add('hidden');

    document.getElementById('btn-dataset').classList.remove('active-tab');
    document.getElementById('btn-grafik').classList.remove('active-tab');

    if(tab === 'dataset'){
        document.getElementById('tab-dataset').classList.remove('hidden');
        document.getElementById('btn-dataset').classList.add('active-tab');
    }else{
        document.getElementById('tab-grafik').classList.remove('hidden');
        document.getElementById('btn-grafik').classList.add('active-tab');
    }
}

const topKecamatan = @json($statistics['top_kecamatan'] ?? null);
const lokasiNikah  = @json($statistics['nikah_lokasi'] ?? null);

if(document.getElementById('chartTopKecamatan') && topKecamatan){
    new Chart(document.getElementById('chartTopKecamatan'), {
        type: 'bar',
        data: {
            labels: topKecamatan.labels,
            datasets: [{
                label: 'Jumlah',
                data: topKecamatan.values,
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display:false } }
        }
    });
}

if(document.getElementById('chartLokasiNikah') && lokasiNikah){
    new Chart(document.getElementById('chartLokasiNikah'), {
        type: 'doughnut',
        data: {
            labels: lokasiNikah.labels,
            datasets: [{
                data: lokasiNikah.values,
                borderWidth: 0
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