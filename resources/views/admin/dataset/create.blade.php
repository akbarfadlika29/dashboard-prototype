@extends('layouts.admin')

@section('title', 'Tambah Dataset')

@section('content')

<h1 class="text-xl font-bold mb-6">Tambah Dataset</h1>

<form method="POST" action="{{ route('dataset.store') }}">
@csrf

<div id="wizard">

    {{-- STEP 1 --}}
    <div class="step">
        <h2 class="font-semibold mb-4">Info Dataset</h2>

        <input type="text" name="nama" placeholder="Nama Dataset"
               class="border p-2 w-full mb-3">

        <select name="kategori_id" class="border p-2 w-full mb-3">
            <option value="">Pilih Kategori</option>
            @foreach($kategori as $k)
                <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
        </select>

        <select name="seksi_id" class="border p-2 w-full mb-3">
            <option value="">Pilih Seksi</option>
            @foreach($seksi as $s)
                <option value="{{ $s->id }}">{{ $s->nama }}</option>
            @endforeach
        </select>

        <textarea name="deskripsi"
                  placeholder="Deskripsi"
                  class="border p-2 w-full"></textarea>
    </div>

    {{-- STEP 2 --}}
    <div class="step hidden">
        <h2 class="font-semibold mb-4">Kolom Dataset</h2>

        <div id="columns-wrapper"></div>

        <button type="button" onclick="addColumn()"
                class="bg-blue-500 text-white px-3 py-1 mt-3">
            + Tambah Kolom
        </button>
    </div>

    {{-- STEP 3 --}}
    <div class="step hidden">
        <h2 class="font-semibold mb-4">Review</h2>

        <p>Pastikan data sudah benar</p>
    </div>

</div>

<div class="mt-6 flex gap-2">
    <button type="button" onclick="prevStep()" class="px-4 py-2 bg-gray-300">Back</button>
    <button type="button" onclick="nextStep()" class="px-4 py-2 bg-blue-500 text-white">Next</button>
    <button type="submit" class="px-4 py-2 bg-green-600 text-white hidden" id="submitBtn">
        Simpan
    </button>
</div>

</form>

<script>
let currentStep = 0;
const steps = document.querySelectorAll('.step');

function showStep(index) {
    steps.forEach((s, i) => s.classList.toggle('hidden', i !== index));

    document.getElementById('submitBtn').classList.toggle('hidden', index !== 2);
}

function nextStep() {
    if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
    }
}

function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
}

function addColumn() {
    const wrapper = document.getElementById('columns-wrapper');

    const index = wrapper.children.length;

    const html = `
        <div class="flex gap-2 mb-2">
            <input name="kolom[${index}][name]" placeholder="Nama Kolom" class="border p-2 flex-1">
            <select name="kolom[${index}][type]" class="border p-2">
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="date">Date</option>
            </select>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
}

showStep(0);
</script>

@endsection