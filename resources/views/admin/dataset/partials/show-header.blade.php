{{-- ================= HEADER ================= --}}
        <div class="bg-gradient-to-r from-white to-slate-50 rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="p-8">

                <div class="flex flex-col xl:flex-row xl:justify-between gap-8">

                    <div class="flex-1">

                        <div class="flex flex-wrap items-center gap-3">

                            <h1 class="text-3xl font-bold text-slate-800">
                                {{ $dataset->nama }}
                            </h1>

                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>

                        </div>

                        @if($dataset->deskripsi)

                            <p class="mt-4 max-w-4xl text-slate-600 leading-relaxed">
                                {{ $dataset->deskripsi }}
                            </p>

                        @endif

                        <div class="mt-6 flex flex-wrap gap-x-8 gap-y-3 text-sm">

                            <div>
                                <div class="text-slate-400">
                                    Kategori
                                </div>

                                <div class="font-semibold text-slate-700">
                                    {{ $dataset->kategori->nama ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-slate-400">
                                    Seksi
                                </div>

                                <div class="font-semibold text-slate-700">
                                    {{ $dataset->seksi->nama ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-slate-400">
                                    Dibuat
                                </div>

                                <div class="font-semibold text-slate-700">
                                    {{ $dataset->created_at->format('d M Y H:i') }}
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="flex flex-wrap gap-3 items-start">

                        {{-- Submit --}}
                        @if ($canEdit && $dataset->count_approved === 0)

                            <form method="POST"
                                action="{{ route('dataset.submit', $dataset) }}"
                                onsubmit="submitButton(this)">

                                @csrf

                                <button
                                    type="submit"
                                    class="submit-btn inline-flex items-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 font-medium transition disabled:opacity-60 disabled:cursor-not-allowed">

                                    <svg class="submit-spinner hidden animate-spin h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24">

                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"/>

                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>

                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="submit-icon w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 4v16h16"/>

                                    </svg>

                                    <span>

                                        @if($dataset->status=='draft')
                                            Ajukan Dataset
                                        @else
                                            Ajukan Kembali
                                        @endif

                                    </span>

                                </button>

                            </form>

                        @endif

                        {{-- Delete --}}
                        @if($canEdit && ($dataset->status=='draft' || $dataset->status=='rejected'))

                            <form method="POST"
                                action="{{ route('dataset.destroy',$dataset) }}"
                                onsubmit="return confirmDelete(event,this)">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="delete-btn inline-flex items-center gap-2 rounded-xl border border-red-300 text-red-600 hover:bg-red-50 px-5 py-3 font-medium transition disabled:opacity-60">

                                    <svg class="delete-spinner hidden animate-spin h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24">

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                            class="opacity-25"/>

                                        <path
                                            fill="currentColor"
                                            class="opacity-75"
                                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>

                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="delete-icon w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7L5 7M10 11v6m4-6v6M6 7l1-2h10l1 2"/>

                                    </svg>

                                    Hapus Dataset

                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Statistic --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 border-t border-slate-200 bg-slate-50">

                <div class="p-5">

                    <div class="text-sm text-slate-500">
                        Jumlah Data
                    </div>

                    <div class="mt-1 text-3xl font-bold text-slate-800">
                        {{ $displayData->count() }}
                    </div>

                </div>

                <div class="p-5 border-l border-slate-200">

                    <div class="text-sm text-slate-500">
                        Jumlah Kolom
                    </div>

                    <div class="mt-1 text-3xl font-bold text-slate-800">
                        {{ count($columns) }}
                    </div>

                </div>

                <div class="p-5 border-l border-slate-200">

                    <div class="text-sm text-slate-500">
                        Filter
                    </div>

                    <div class="mt-1 text-3xl font-bold text-slate-800">
                        {{ $dataset->filters->count() }}
                    </div>

                </div>

                <div class="p-5 border-l border-slate-200">

                    <div class="text-sm text-slate-500">
                        Revision
                    </div>

                    <div class="mt-1 text-3xl font-bold text-slate-800">
                        {{ $revision ? $totalChanges : 0 }}
                    </div>

                </div>

            </div>

        </div>