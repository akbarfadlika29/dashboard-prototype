<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

    <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

        <div>

            <h2 class="text-xl font-bold text-slate-800">
                File Dataset
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Preview dokumen yang diunggah
            </p>

        </div>

        @if($canEdit)

            <a
                href="{{ route('dataset.files.edit',$dataset) }}"
                class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium transition">

                <i class="fa-solid fa-file-arrow-up mr-2"></i>
                Ganti File

            </a>

        @endif

    </div>

    <div class="p-6">

        @include('admin.dataset.partials.preview-file')

    </div>

</div>