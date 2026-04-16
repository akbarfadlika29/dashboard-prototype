@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar User</h2>
        <p class="text-sm text-gray-500">Kelola semua user sistem</p>
    </div>

    <a href="{{ route('admin.user.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow flex items-center gap-2">
        <i class="fa fa-plus"></i> Tambah User
    </a>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4">NIP</th>
                <th class="p-4">Role</th>
                <th class="p-4">Seksi</th>
                <th class="p-4">Aksi</th>
            </tr>
        </thead>

        <tbody>
        @foreach($users as $u)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="p-4 font-medium">{{ $u->nama }}</td>
                <td class="p-4 text-center">{{ $u->nip }}</td>

                <td class="p-4 text-center">
                    <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                        {{ $u->role }}
                    </span>
                </td>

                <td class="p-4 text-center">
                    {{ $u->seksi->pluck('nama')->join(', ') ?: '-' }}
                </td>

                <td class="p-4 text-center flex justify-center gap-2">
                    <a href="{{ route('admin.user.edit', $u) }}"
                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg">
                        Edit
                    </a>

                    <form action="{{ route('admin.user.destroy', $u) }}" method="POST"
                          onsubmit="return confirm('Hapus user ini?')">
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
        {{ $users->links() }}
    </div>
</div>

@endsection