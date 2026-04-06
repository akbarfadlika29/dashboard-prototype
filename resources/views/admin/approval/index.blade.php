@extends('layouts.admin')

@section('title', 'Approval Dataset')

@section('content')
<div class="space-y-4">
    @foreach($dataset as $item)
        <div class="bg-white rounded-2xl border p-6 flex justify-between items-start">
            <div>
                <h3 class="font-bold text-lg">{{ $item->nama }}</h3>
                <p class="text-sm text-gray-500">{{ $item->seksi->nama }}</p>
                <a href="{{ route('admin-dataset.show', $item) }}" class="text-blue-600 text-sm mt-2 inline-block">
                    Lihat detail
                </a>
            </div>

            <div class="flex gap-2">
                <form method="POST" action="{{ route('admin.approval.approve', $item) }}">
                    @csrf
                    <input type="text" name="catatan" class="border rounded px-3 py-2 mb-2" placeholder="Catatan approve">
                    <button class="bg-green-600 text-white px-4 py-2 rounded-xl w-full">Approve</button>
                </form>

                <form method="POST" action="{{ route('admin.approval.reject', $item) }}">
                    @csrf
                    <input type="text" name="catatan" class="border rounded px-3 py-2 mb-2" placeholder="Alasan reject">
                    <button class="bg-red-600 text-white px-4 py-2 rounded-xl w-full">Reject</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection