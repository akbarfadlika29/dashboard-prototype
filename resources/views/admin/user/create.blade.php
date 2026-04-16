@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow">

<form method="POST" action="{{ route('admin.user.store') }}" autocomplete="off">
@csrf

<div class="grid gap-5">

    <input name="nama" autocomplete="off" placeholder="Nama"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none" required>

    <input name="nip" autocomplete="off" placeholder="NIP"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none" required>

    <input name="email" autocomplete="off" placeholder="Email"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none">

    <input type="password" autocomplete="off" name="password" placeholder="Password"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none" required>

    <select name="role"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none">
        <option value="superadmin">Superadmin</option>
        <option value="admin_umum">Admin Umum</option>
        <option value="admin_seksi">Admin Seksi</option>
        <option value="kepala_seksi">Kepala Seksi</option>
    </select>

    <div>
        <label class="font-semibold mb-2 block">Seksi</label>

        <div class="grid grid-cols-2 gap-3">
            @foreach($seksi as $s)
                <label class="flex items-center gap-2 border rounded-lg px-3 py-2 hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox" name="seksi_id[]" value="{{ $s->id }}">
                    {{ $s->nama }}
                </label>
            @endforeach
        </div>
    </div>

    <button class="bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold shadow">
        Simpan
    </button>

</div>
</form>

</div>



@endsection