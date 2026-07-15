@extends('layouts.admin')

@section('title', 'Portal Data & Informasi')
@section('subtitle', 'Kumpulan data dan informasi dari masing-masing seksi.')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<section class="mb-10">
    <div class="rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white p-8 sm:p-10 shadow-lg overflow-hidden relative">
        <div class="relative z-10 max-w-2xl">
            <p class="text-sm uppercase tracking-widest text-white/80 mb-2">
                Pusdatin Kemenag Tuban
            </p>
            <h2 class="text-3xl sm:text-4xl font-bold leading-tight">
                Satu Portal Untuk Data & Informasi
            </h2>
            <p class="mt-3 text-white/90">
                Akses kategori data secara cepat, rapi, dan terintegrasi.
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 text-white/10 text-[180px]">
            <i class="fa-solid fa-chart-column"></i>
        </div>
    </div>
</section>

{{-- STATISTIK --}}
<section class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
        <p class="text-sm font-medium text-slate-500">Kategori</p>
        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $kategori->count() }}</h3>
    </div>
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
        <p class="text-sm font-medium text-slate-500">Dataset</p>
        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $dataset->count() }}</h3>
    </div>
</section>

{{-- TITLE --}}
<div class="mb-6 border-l-4 border-emerald-500 pl-4">
    <h2 class="text-2xl font-bold">Kategori Data</h2>
    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">
        Pilih kategori yang ingin Anda akses
    </p>
</div>

{{-- LOADING SKELETON --}}
<div id="skeleton" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @for($i=1; $i<=6; $i++)
        <div class="h-[150px] rounded-2xl bg-gray-200 dark:bg-slate-800 animate-pulse"></div>
    @endfor
</div>

{{-- CARD LIST --}}
<div id="realContent" class="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach($kategori as $item)
        <a href="{{ route('admin.dashboard.kategori.show', $item->id) }}" class="block h-full group">
            <div class="bg-white
            border border-slate-200
            rounded-2xl
            p-6
            min-h-[180px]
            h-full
            shadow-sm
            hover:border-emerald-300
            hover:shadow-lg
            hover:-translate-y-1
            transition-all duration-300">
                <div class="flex flex-col items-center justify-center text-center h-full">
                    <div class="w-14 h-14
            rounded-2xl
            bg-emerald-50
            flex items-center justify-center
            group-hover:scale-110
            group-hover:rotate-6
            transition-all duration-300
            mb-5
            shrink-0">
                            
                        <i class="fa-solid fa-folder-open text-xl text-emerald-700"></i>        
                    </div>

                    <h3 class="font-bold
           text-lg
           text-slate-800
           leading-snug
           line-clamp-2
           min-h-[56px]
           flex items-center
           group-hover:text-emerald-700
           transition-colors">
                        {{ $item->nama }}
                    </h3>
                    <p class="text-sm text-slate-500 mt-2">
                        Lihat data & informasi terkait
                    </p>
                </div>
            </div>
        </a>
    @endforeach
</div>

@endsection

@push('scripts')
<script>
window.addEventListener('load', function(){
    setTimeout(() => {
        document.getElementById('skeleton').classList.add('hidden');
        document.getElementById('realContent').classList.remove('hidden');
    }, 500);
});
</script>
@endpush