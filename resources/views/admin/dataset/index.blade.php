@extends('layouts.admin')

@section('title', 'Dataset')
@section('subtitle', 'Kelola dataset sesuai hak akses pengguna')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h3 class="text-lg font-semibold text-gray-800">
            Daftar Dataset
        </h3>
        <p class="text-sm text-gray-500 mt-1">
            Total {{ $dataset->count() }} dataset
        </p>
    </div>

    <!-- BUTTON -->
    <button onclick="openModal()"
        class="inline-flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white px-5 py-3 rounded-xl font-medium transition">
        <i class="fa-solid fa-plus"></i>
        Tambah Dataset
    </button>
</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-[420px] rounded-2xl shadow-lg p-6">

        <h2 class="text-lg font-bold mb-4">Tambah Dataset</h2>

        <p class="text-sm text-gray-500 mb-4">
            Pilih metode input data
        </p>

        <div class="space-y-3">
            <button onclick="goToManual()"
                class="w-full border p-4 rounded-xl hover:bg-gray-100 text-left">
                <div class="font-semibold">✍️ Input Manual</div>
                <div class="text-sm text-gray-500">Isi data satu per satu</div>
            </button>

            <button onclick="goToImport()"
                class="w-full border p-4 rounded-xl hover:bg-gray-100 text-left">
                <div class="font-semibold">📄 Import Excel</div>
                <div class="text-sm text-gray-500">Upload file Excel</div>
            </button>
        </div>

        <button onclick="closeModal()"
            class="mt-4 text-sm text-gray-500 hover:underline">
            Batal
        </button>

    </div>
</div>

{{-- TABLE (tidak berubah) --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wide">
                <tr>
                    <th class="px-6 py-4 text-left">Nama Dataset</th>
                    <th class="px-6 py-4 text-left">Kategori</th>
                    <th class="px-6 py-4 text-left">Seksi</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($dataset as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $item->nama }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $item->kategori->nama }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $item->seksi->nama }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            @php
                                $badge = match($item->status) {
                                    'draft' => 'bg-gray-100 text-gray-700',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'approved' => 'bg-green-100 text-green-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                };
                            @endphp

                            <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $badge }}">
                                {{ $item->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin-dataset.show', $item->id) }}"
                               class="inline-flex items-center gap-2 text-green-700 hover:text-green-900 font-medium">
                                <i class="fa-solid fa-eye"></i>
                                Detail
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            Belum ada dataset.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SCRIPT --}}
<script>
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.getElementById('modal').classList.remove('flex');
}

function goToManual() {
    window.location.href = "{{ route('dataset.create') }}";
}

function goToImport() {
    window.location.href = "{{ route('dataset.import') }}";
}
</script>

@endsection