<div class="bg-white rounded-2xl border p-6 space-y-4">

    <input type="text" name="nama" value="{{ old('nama', $dataset->nama ?? '') }}" class="w-full border rounded-xl p-3" placeholder="Nama dataset">

    <textarea name="deskripsi" class="w-full border rounded-xl p-3" placeholder="Deskripsi">{{ old('deskripsi', $dataset->deskripsi ?? '') }}</textarea>

    <select name="kategori_id" class="w-full border rounded-xl p-3">
        @foreach($kategori as $item)
            <option value="{{ $item->id }}" @selected(old('kategori_id', $dataset->kategori_id ?? '') == $item->id)>
                {{ $item->nama }}
            </option>
        @endforeach
    </select>

    <select name="seksi_id" class="w-full border rounded-xl p-3">
        @foreach($seksi as $item)
            <option value="{{ $item->id }}" @selected(old('seksi_id', $dataset->seksi_id ?? '') == $item->id)>
                {{ $item->nama }}
            </option>
        @endforeach
    </select>

</div>