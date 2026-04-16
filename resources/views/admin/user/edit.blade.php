@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg border border-gray-100">

<form method="POST"
      action="{{ route('admin.user.update', $user) }}"
      autocomplete="off">
@csrf
@method('PUT')

<div class="grid gap-5">

    {{-- NAMA --}}
    <input name="nama"
        value="{{ $user->nama }}"
        autocomplete="off"
        placeholder="Nama"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none">

    {{-- NIP --}}
    <input name="nip"
        value="{{ $user->nip }}"
        autocomplete="off"
        placeholder="NIP"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none">

    {{-- EMAIL --}}
    <input name="email"
        value="{{ $user->email }}"
        autocomplete="new-email"
        placeholder="Email"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none">

    {{-- PASSWORD --}}
    <input type="password"
        name="password"
        autocomplete="new-password"
        placeholder="Password (Kosongkan jika tidak diubah)"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none">

    {{-- ROLE --}}
    <select name="role"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 outline-none">

        @foreach(['superadmin','admin_umum','admin_seksi','kepala_seksi'] as $role)
            <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                {{ ucfirst(str_replace('_',' ', $role)) }}
            </option>
        @endforeach

    </select>

    {{-- SEKSI --}}
    <div>
        <label class="font-semibold mb-2 block">Seksi</label>

        <div class="grid grid-cols-2 gap-3">
            @foreach($seksi as $s)
                <label class="flex items-center gap-2 border rounded-lg px-3 py-2 hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox"
                        name="seksi_id[]"
                        value="{{ $s->id }}"
                        {{ $user->seksi->contains($s->id) ? 'checked' : '' }}>
                    {{ $s->nama }}
                </label>
            @endforeach
        </div>
    </div>

    {{-- BUTTON --}}
    <div class="flex gap-3">
        <a href="{{ route('admin.user.index') }}"
           class="w-1/2 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-xl font-semibold">
            Batal
        </a>

        <button class="w-1/2 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold shadow">
            Update
        </button>
    </div>

</div>
</form>

</div>

@endsection