@extends('layouts.admin')

@section('title', $title)
@section('subtitle', 'Halaman ini belum dibuat dan akan dikembangkan berikutnya')

@section('content')

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-10 text-center">

    <div class="w-20 h-20 mx-auto rounded-full bg-green-100 flex items-center justify-center mb-5">
        <i class="fa-solid fa-screwdriver-wrench text-3xl text-green-700"></i>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-3">
        {{ $title }}
    </h2>

    <p class="text-gray-500 max-w-xl mx-auto leading-7">
        Halaman ini masih dalam proses pengembangan.
        Sidebar sudah aktif sehingga kamu sekarang bisa berpindah menu tanpa mengetik URL manual.
    </p>

</div>

@endsection