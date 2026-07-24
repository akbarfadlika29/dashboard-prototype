
@if($dataset->hasDraftRevision())
    @php
        $file = asset($dataset->activeRevision->latestFileChange->after_file_storage);

        $ext = strtolower(pathinfo($dataset->activeRevision->latestFileChange->after_file_storage, PATHINFO_EXTENSION));
    @endphp
@else
    @php
        $file = asset($dataset->file_storage);

        $ext = strtolower(pathinfo($dataset->file_storage, PATHINFO_EXTENSION));
    @endphp
@endif


@if(in_array($ext,['pdf']))

    <iframe
        src="{{ $file }}"
        class="w-full h-[900px] rounded-xl">
    </iframe>

@elseif(in_array($ext,['jpg','jpeg','png','webp']))

    <img
        src="{{ $file }}"
        class="rounded-xl w-full">

@elseif(in_array($ext,['xlsx','xls']))

    <div class="text-center py-20">

        <i class="fa-solid fa-file-excel text-6xl text-green-600"></i>

        <div class="mt-5">

            <a
                href="{{ $file }}"
                target="_blank"
                class="px-5 py-2 rounded-xl bg-green-600 text-white">

                Download Excel

            </a>

        </div>

    </div>

@endif