@extends('layouts.public')

@section('title', 'Portal Data & Informasi')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-semibold">
            Kategori Data
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Daftar kategori data dan informasi tersedia
        </p>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

    @foreach($kategori as $item)
        <a href="{{ route('kategori.show', $item->id) }}" class="block">
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg 
                        transition duration-300 border border-gray-100 
                        p-6 cursor-pointer group">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-xl 
                                bg-emerald-50 
                                flex items-center justify-center 
                                group-hover:bg-emerald-100 
                                transition">

                        <i class="fa-solid fa-folder-open 
                                  text-emerald-600 
                                  text-lg"></i>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium 
                                   group-hover:text-emerald-600 
                                   transition">
                            {{ $item->nama }}
                        </h3>

                        <p class="text-sm text-gray-500">
                            Lihat data & informasi terkait
                        </p>
                    </div>

                </div>

            </div>
        </a>
    @endforeach

</div>

@endsection