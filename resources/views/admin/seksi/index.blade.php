@extends('layouts.admin')

@section('title', 'Manajemen Seksi')

@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Seksi</h2>
        <p class="text-sm text-gray-500">Kelola data seksi</p>
    </div>

    <a href="{{ route('admin.seksi.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow flex items-center gap-2">
        <i class="fa fa-plus"></i> Tambah Seksi
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4">Jumlah User</th>
                <th class="p-4">Jumlah Dataset</th>
                <th class="p-4">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($seksi as $s)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-4 font-medium">{{ $s->nama }}</td>

                <td class="p-4 text-center">
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs">
                        {{ $s->users_count }}
                    </span>
                </td>

                <td class="p-4 text-center">
                    <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-lg text-xs">
                        {{ $s->datasets_count }}
                    </span>
                </td>

                <td class="p-4 text-center flex justify-center gap-2">
                    <a href="{{ route('admin.seksi.edit', $s) }}"
                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg">
                        Edit
                    </a>

                    <form action="{{ route('admin.seksi.destroy', $s) }}" method="POST"
                          onsubmit="return confirm('Hapus seksi ini?')">
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
        {{ $seksi->links() }}
    </div>

</div>

@endsection