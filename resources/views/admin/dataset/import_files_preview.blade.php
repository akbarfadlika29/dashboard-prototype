@extends('layouts.admin')

@section('title','Preview Files')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Preview Dataset
</h1>

<div class="grid lg:grid-cols-2 gap-6">

    {{-- PREVIEW --}}
    <div class="bg-white rounded-xl shadow p-5">

        @if($extension == 'PDF')

            <iframe
                src="{{ public_asset($file_path) }}"
                class="w-full h-[650px] border rounded-lg">
            </iframe>

        @elseif(in_array($extension, ['JPG','JPEG','PNG']))

            <img src="{{ public_asset($file_path) }}"
                class="max-w-full rounded-lg border mx-auto">

        @elseif(in_array($extension, ['XLS','XLSX']))

            <div class="flex flex-col items-center justify-center h-[400px] text-center">

                <i class="fa-solid fa-file-excel text-green-600 text-7xl mb-4"></i>

                <div class="font-semibold">
                    {{ $original_name }}
                </div>

                <div class="text-slate-500 mt-2">
                    File Excel tidak dapat dipreview langsung.
                </div>

                <div class="text-sm text-slate-400">
                    File akan tetap tersimpan apa adanya.
                </div>

            </div>

        @else

            <div class="text-center py-20">

                Preview tidak tersedia.

            </div>

        @endif

    </div>

    {{-- INFORMASI --}}
    <div class="bg-white rounded-xl shadow p-5">

        <h2 class="font-semibold text-lg mb-4">
            Informasi File
        </h2>

        <table class="table-auto w-full">

            <tr class="border-b">
                <td class="py-3 font-medium">Nama File</td>
                <td>{{ $original_name }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-3 font-medium">Jenis</td>
                <td>{{ strtoupper($extension) }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-3 font-medium">MIME</td>
                <td>{{ $mime }}</td>
            </tr>

            <tr class="border-b">
                <td class="py-3 font-medium">Ukuran</td>
                <td>{{ $size_human }}</td>
            </tr>

        </table>

        <form
            method="POST"
            action="{{ route('dataset.importFilesStore') }}"
            class="mt-8"
            onsubmit="submitFileDataset(this)">

            @csrf

            <input type="hidden" name="nama" value="{{ $request['nama'] }}">
            <input type="hidden" name="kategori_id" value="{{ $request['kategori_id'] }}">
            <input type="hidden" name="seksi_id" value="{{ $request['seksi_id'] }}">

            <input type="hidden" name="file_path" value="{{ $file_path }}">
            <input type="hidden" name="original_name" value="{{ $original_name }}">
            <input type="hidden" name="mime" value="{{ $mime }}">
            <input type="hidden" name="size" value="{{ $size }}">

            <button
                type="submit"
                id="saveDatasetButton"
                class="w-full inline-flex items-center justify-center gap-2
                    bg-green-700
                    hover:bg-green-800
                    text-white
                    py-3
                    rounded-xl
                    transition
                    disabled:opacity-60
                    disabled:cursor-not-allowed">

                {{-- SPINNER --}}
                <svg
                    id="saveDatasetSpinner"
                    class="hidden animate-spin w-5 h-5"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24">

                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4">
                    </circle>

                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                    </path>

                </svg>


                {{-- ICON --}}
                <i
                    id="saveDatasetIcon"
                    class="fa-solid fa-floppy-disk">
                </i>


                {{-- TEXT --}}
                <span id="saveDatasetText">
                    Simpan Dataset
                </span>

            </button>

        </form>

    </div>

</div>

@endsection

@push('scripts')

<script>

    function submitFileDataset(form)
    {
        const button =
            document.getElementById('saveDatasetButton');

        const spinner =
            document.getElementById('saveDatasetSpinner');

        const icon =
            document.getElementById('saveDatasetIcon');

        const text =
            document.getElementById('saveDatasetText');


        if (!button) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | DISABLE BUTTON
        |--------------------------------------------------------------------------
        */

        button.disabled = true;


        /*
        |--------------------------------------------------------------------------
        | SHOW SPINNER
        |--------------------------------------------------------------------------
        */

        spinner?.classList.remove('hidden');


        /*
        |--------------------------------------------------------------------------
        | HIDE NORMAL ICON
        |--------------------------------------------------------------------------
        */

        icon?.classList.add('hidden');


        /*
        |--------------------------------------------------------------------------
        | CHANGE TEXT
        |--------------------------------------------------------------------------
        */

        if (text) {
            text.textContent = 'Menyimpan...';
        }


        /*
        |--------------------------------------------------------------------------
        | LANJUTKAN SUBMIT FORM
        |--------------------------------------------------------------------------
        */

        return true;
    }

</script>

@endpush