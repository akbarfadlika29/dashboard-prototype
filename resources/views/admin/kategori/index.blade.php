@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Kategori</h2>
        <p class="text-sm text-gray-500">Kelola kategori dataset</p>
    </div>

    <a href="{{ route('admin.kategori.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow flex items-center gap-2">
        <i class="fa fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4">Slug</th>
                <th class="p-4">Deskripsi</th>
                <th class="p-4">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($kategori as $k)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-4 font-medium">{{ $k->nama }}</td>
                <td class="p-4 text-center text-gray-500">{{ $k->slug }}</td>
                <td class="p-4 text-center">{{ $k->deskripsi ?: '-' }}</td>

                <td class="p-4 text-center flex justify-center gap-2">
                    <a href="{{ route('admin.kategori.edit', $k) }}"
                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg">
                        Edit
                    </a>

                    <form action="{{ route('admin.kategori.destroy', $k) }}" method="POST"
                          onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')

                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="p-4 border-t flex justify-center">
        {{ $kategori->links() }}
    </div>

</div>

@endsection