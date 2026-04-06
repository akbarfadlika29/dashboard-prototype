@extends('layouts.admin')

@section('title', 'Edit Dataset')

@section('content')
<form method="POST" action="{{ route('dataset.update', $dataset) }}">
    @csrf
    @method('PUT')

    @include('admin.dataset.form')

    <button class="bg-green-700 text-white px-5 py-3 rounded-xl mt-6">
        Simpan Perubahan
    </button>
</form>
@endsection