@extends('layouts.admin')

@section('title', 'Import Dataset')

@section('content')

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 md:p-10 mb-6">
    <div class="flex flex-col md:flex-row items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Import Dataset CSV
            </h1>

            <p class="mt-1 text-slate-500">
                Upload file CSV kemudian lakukan mapping kolom sebelum dataset diimport.
            </p>
        </div>

        <a href="{{ route('dataset.index') }}"
            class="inline-flex items-center gap-2
            px-5 py-2.5
            rounded-xl
            border border-slate-300
            bg-white
            text-slate-700
            shadow-sm
            hover:bg-slate-50
            hover:border-slate-400
            transition">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali ke Daftar
        </a>

    </div>
</div>

<form method="POST"
      action="{{ route('dataset.import.preview') }}"
      enctype="multipart/form-data">
@csrf

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 md:p-10 space-y-8">

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Nama Dataset
            <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="nama"
            value="{{ old('nama') }}"
            placeholder="Contoh : Data Pernikahan Tahun 2026"

            class="
            w-full
            rounded-2xl
            border-2
            border-slate-300
            px-5
            py-3.5
            shadow-sm

            hover:border-slate-400

            focus:border-emerald-500
            focus:ring-4
            focus:ring-emerald-100

            transition">
    </div>

    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Kategori Dataset
            <span class="text-red-500">*</span>
        </label>

        <select
            name="kategori_id"
            required

            class="
                w-full
                rounded-2xl
                border-2
                border-slate-300
                px-5
                py-3.5
                shadow-sm

                hover:border-slate-400

                focus:border-emerald-500
                focus:ring-4
                focus:ring-emerald-100

                transition">

            <option value="">
                -- Pilih Kategori Dataset --
            </option>

            @foreach($kategori as $k)
                <option value="{{ $k->id }}">
                    {{ $k->nama }}
                </option>
            @endforeach

        </select>

        <p class="text-xs text-slate-500 mt-2">
            Kategori digunakan untuk mengelompokkan dataset pada portal.
        </p>

    </div>

    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Seksi Pengelola
            <span class="text-red-500">*</span>
        </label>

        <select
            name="seksi_id"
            required

            class="
                w-full
                rounded-2xl
                border-2
                border-slate-300
                px-5
                py-3.5
                shadow-sm

                hover:border-slate-400

                focus:border-emerald-500
                focus:ring-4
                focus:ring-emerald-100

                transition">

            <option value="">
                -- Pilih Seksi --
            </option>

            @foreach($seksi as $s)
                <option value="{{ $s->id }}">
                    {{ $s->nama }}
                </option>
            @endforeach

        </select>

        <p class="text-xs text-slate-500 mt-2">
            Dataset akan dikelola oleh seksi yang dipilih.
        </p>

    </div>

    <div>

        <label class="block text-sm font-semibold text-slate-700 mb-2">
            File Dataset
            <span class="text-red-500">*</span>
        </label>

        <input
            type="file"
            name="file"
            accept=".csv,.txt"
            required

            class="
                block
                w-full

                rounded-2xl

                border-2
                border-dashed
                border-slate-300

                bg-slate-50

                px-5
                py-4

                text-slate-600

                file:mr-4
                file:rounded-xl
                file:border-0
                file:bg-emerald-600
                file:px-4
                file:py-2
                file:text-white
                file:font-medium

                hover:border-emerald-400

                transition">

        <p class="text-xs text-slate-500 mt-2">
            Format yang didukung: CSV (.csv) atau TXT (.txt).
        </p>

    </div>

    <div class="flex justify-end pt-4 border-t border-slate-200">

        <button
            type="submit"

            class="
                inline-flex
                items-center
                gap-2

                rounded-xl

                bg-emerald-600

                px-6
                py-3

                font-semibold
                text-white

                shadow-md

                hover:bg-emerald-700
                hover:shadow-xl

                transition">

            <i class="fa-solid fa-eye"></i>

            Preview Data

        </button>

    </div>

</div>
</form>

@endsection