@extends('layouts.admin')

@section('title', 'Edit File')

@section('content')
{{-- =========================================================
    DATASET FILE
    ========================================================= --}}

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

    {{-- HEADER --}}
    <div class="px-6 py-5 border-b border-slate-200">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl
                    bg-emerald-50
                    text-emerald-600
                    flex items-center justify-center">

                    <i class="fa-solid fa-file-arrow-up text-lg"></i>

                </div>

                <div>

                    <h2 class="text-xl font-bold text-slate-800">
                        File Dataset
                    </h2>

                    <p class="text-sm text-slate-500 mt-0.5">
                        Unggah atau perbarui file yang digunakan sebagai sumber dataset.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- FORM --}}
    <form
        id="datasetFileForm"
        method="POST"
        action="{{ route('dataset.files.update', $dataset) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')


        <div class="p-6">

            {{-- UPLOAD AREA --}}
            <label
                for="datasetFileInput"
                id="datasetFileDropzone"
                class="
                    group
                    relative
                    flex
                    flex-col
                    items-center
                    justify-center

                    w-full
                    min-h-[260px]

                    px-6
                    py-10

                    rounded-2xl

                    border-2
                    border-dashed
                    border-slate-300

                    bg-slate-50

                    cursor-pointer

                    transition-all
                    duration-200

                    hover:border-emerald-400
                    hover:bg-emerald-50/40
                ">

                {{-- DEFAULT CONTENT --}}
                <div
                    id="datasetFilePlaceholder"
                    class="flex flex-col items-center text-center">

                    {{-- ICON --}}
                    <div
                        class="
                            w-16
                            h-16
                            rounded-2xl

                            bg-white
                            border
                            border-slate-200

                            text-slate-400

                            flex
                            items-center
                            justify-center

                            shadow-sm

                            group-hover:text-emerald-500
                            group-hover:border-emerald-200

                            transition">

                        <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>

                    </div>


                    {{-- TITLE --}}
                    <h3 class="mt-5 text-base font-semibold text-slate-700">

                        Pilih file dataset

                    </h3>


                    {{-- DESCRIPTION --}}
                    <p class="mt-1 text-sm text-slate-500">

                        Klik untuk memilih file dari komputer Anda

                    </p>


                    {{-- SECONDARY DESCRIPTION --}}
                    <p class="mt-2 text-xs text-slate-400">

                        atau seret dan lepaskan file di area ini

                    </p>


                    {{-- FORMAT BADGES --}}
                    <div class="flex flex-wrap items-center justify-center gap-2 mt-5">

                        <span
                            class="
                                inline-flex
                                items-center
                                gap-1.5

                                px-3
                                py-1.5

                                rounded-lg

                                bg-white
                                border
                                border-slate-200

                                text-xs
                                font-medium
                                text-slate-600">

                            <i class="fa-solid fa-file-pdf text-slate-400"></i>

                            PDF

                        </span>


                        <span
                            class="
                                inline-flex
                                items-center
                                gap-1.5

                                px-3
                                py-1.5

                                rounded-lg

                                bg-white
                                border
                                border-slate-200

                                text-xs
                                font-medium
                                text-slate-600">

                            <i class="fa-solid fa-file-excel text-slate-400"></i>

                            XLSX/XLS

                        </span>

                        <span
                            class="
                                inline-flex
                                items-center
                                gap-1.5

                                px-3
                                py-1.5

                                rounded-lg

                                bg-white
                                border
                                border-slate-200

                                text-xs
                                font-medium
                                text-slate-600">

                            <i class="fa-solid fa-file-image text-slate-400"></i>

                            JPG/JPEG/PNG

                        </span>

                    </div>

                </div>


                {{-- SELECTED FILE --}}
                <div
                    id="datasetFileSelected"
                    class="hidden w-full max-w-xl">

                    <div
                        class="
                            flex
                            items-center
                            gap-4

                            p-4

                            rounded-2xl

                            bg-white

                            border
                            border-emerald-200

                            shadow-sm">

                        {{-- FILE ICON --}}
                        <div
                            class="
                                w-12
                                h-12
                                shrink-0

                                rounded-xl

                                bg-emerald-50
                                text-emerald-600

                                flex
                                items-center
                                justify-center">

                            <i class="fa-solid fa-file-lines text-lg"></i>

                        </div>


                        {{-- FILE INFORMATION --}}
                        <div class="min-w-0 flex-1">

                            <div
                                id="datasetFileName"
                                class="
                                    font-semibold
                                    text-slate-700
                                    truncate">

                                Nama file

                            </div>


                            <div
                                id="datasetFileSize"
                                class="
                                    text-xs
                                    text-slate-400
                                    mt-1">

                                0 KB

                            </div>

                        </div>


                        {{-- REMOVE --}}
                        <button
                            type="button"
                            id="datasetFileRemove"
                            class="
                                w-9
                                h-9
                                shrink-0

                                rounded-xl

                                text-slate-400

                                hover:bg-red-50
                                hover:text-red-600

                                transition">

                            <i class="fa-solid fa-xmark"></i>

                        </button>

                    </div>


                    {{-- SUCCESS STATUS --}}
                    <div
                        class="
                            flex
                            items-center
                            gap-2

                            mt-3

                            px-3
                            py-2

                            rounded-xl

                            bg-emerald-50

                            text-xs
                            text-emerald-700">

                        <i class="fa-solid fa-circle-check"></i>

                        File siap diunggah.

                    </div>

                </div>


                {{-- REAL FILE INPUT --}}
                <input
                    id="datasetFileInput"
                    type="file"
                    name="file"
                    accept=".pdf,.xlsx,.xls,.jpg,.jpeg,.png"
                    class="hidden"
                    required>

            </label>


            {{-- INFORMATION --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-5">

                {{-- FORMAT --}}
                <div
                    class="
                        flex
                        items-start
                        gap-3

                        p-4

                        rounded-2xl

                        bg-slate-50
                        border
                        border-slate-200">

                    <div
                        class="
                            w-9
                            h-9
                            shrink-0

                            rounded-lg

                            bg-white
                            border
                            border-slate-200

                            text-slate-500

                            flex
                            items-center
                            justify-center">

                        <i class="fa-solid fa-file-circle-check"></i>

                    </div>

                    <div>

                        <div class="text-xs font-semibold text-slate-700">
                            Format File
                        </div>

                        <div class="text-xs text-slate-500 mt-1">
                            PDF, XLSX, XLS, JPG, JPEG, PNG
                        </div>

                    </div>

                </div>


                {{-- DATA --}}
                <div
                    class="
                        flex
                        items-start
                        gap-3

                        p-4

                        rounded-2xl

                        bg-slate-50
                        border
                        border-slate-200">

                    <div
                        class="
                            w-9
                            h-9
                            shrink-0

                            rounded-lg

                            bg-white
                            border
                            border-slate-200

                            text-slate-500

                            flex
                            items-center
                            justify-center">

                        <i class="fa-solid fa-table"></i>

                    </div>

                    <div>

                        <div class="text-xs font-semibold text-slate-700">
                            Struktur Data
                        </div>

                        <div class="text-xs text-slate-500 mt-1">
                            Pastikan kolom sesuai schema
                        </div>

                    </div>

                </div>


                {{-- WARNING --}}
                <div
                    class="
                        flex
                        items-start
                        gap-3

                        p-4

                        rounded-2xl

                        bg-amber-50
                        border
                        border-amber-100">

                    <div
                        class="
                            w-9
                            h-9
                            shrink-0

                            rounded-lg

                            bg-white
                            border
                            border-amber-200

                            text-amber-500

                            flex
                            items-center
                            justify-center">

                        <i class="fa-solid fa-circle-info"></i>

                    </div>

                    <div>

                        <div class="text-xs font-semibold text-amber-700">
                            Perhatian
                        </div>

                        <div class="text-xs text-amber-600 mt-1">
                            File lama akan diperbarui
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- FOOTER --}}
        <div
            class="
                px-6
                py-4

                border-t
                border-slate-200

                bg-slate-50

                flex
                flex-col
                sm:flex-row
                sm:items-center
                sm:justify-between

                gap-3">

            <div
                class="
                    flex
                    items-center
                    gap-2

                    text-xs
                    text-slate-500">

                <i class="fa-solid fa-shield-halved text-emerald-500"></i>

                Pastikan file yang diunggah sudah benar.

            </div>


            <button
                id="datasetFileSubmit"
                type="submit"

                class="
                    inline-flex
                    items-center
                    justify-center
                    gap-2

                    px-6
                    py-2.5

                    rounded-xl

                    bg-emerald-600
                    hover:bg-emerald-700

                    text-white

                    text-sm
                    font-semibold

                    shadow-sm
                    hover:shadow-md

                    transition-all

                    disabled:bg-slate-400
                    disabled:cursor-not-allowed
                    disabled:shadow-none">

                {{-- NORMAL ICON --}}
                <i
                    id="datasetFileSubmitIcon"
                    class="fa-solid fa-cloud-arrow-up">

                </i>


                {{-- SPINNER --}}
                <i
                    id="datasetFileSubmitSpinner"
                    class="fa-solid fa-spinner fa-spin hidden">

                </i>


                {{-- TEXT --}}
                <span id="datasetFileSubmitText">
                    Simpan File
                </span>

            </button>

        </div>

    </form>

</div>
@endsection