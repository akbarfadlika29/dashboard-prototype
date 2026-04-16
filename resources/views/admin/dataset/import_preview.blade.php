@extends('layouts.admin')

@section('title', 'Preview Import')

@section('content')

<h1 class="text-xl font-bold mb-6">Preview Import CSV</h1>

{{-- Preview Table --}}
<div class="bg-white rounded-xl shadow p-4 overflow-auto mb-6">
    <table class="table-auto w-full border text-sm">
        @foreach($data as $rowIndex => $row)
            <tr class="{{ $rowIndex === 0 ? 'bg-gray-100 font-semibold' : '' }}">
                @foreach($row as $cell)
                    <td class="border px-3 py-2 whitespace-nowrap">
                        {{ $cell }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>

{{-- Mapping Tipe Data --}}
<form method="POST" action="{{ route('dataset.importStore') }}">
@csrf

<div class="bg-white rounded-xl shadow p-6 space-y-6">

    <h2 class="text-lg font-semibold">Mapping Kolom & Tipe Data</h2>

    {{-- hidden data lama --}}
    <input type="hidden" name="nama" value="{{ $request['nama'] }}">
    <input type="hidden" name="kategori_id" value="{{ $request['kategori_id'] }}">
    <input type="hidden" name="seksi_id" value="{{ $request['seksi_id'] }}">
    <input type="hidden" name="file_path" value="{{ $file_path }}">

    <div class="overflow-auto">
        <table class="table-auto w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">Nama Kolom</th>
                    <th class="border px-3 py-2 text-left">Tipe Data</th>
                </tr>
            </thead>

            <tbody>
                @foreach($headers as $i => $header)
                    <tr>
                        <td class="border px-3 py-2">
                            {{ $header }}

                            <input type="hidden"
                                   name="columns[{{ $i }}][name]"
                                   value="{{ $header }}">
                        </td>

                        <td class="border px-3 py-2">
                            <select name="columns[{{ $i }}][type]"
                                    class="border rounded px-2 py-1 w-full">

                                <option value="text"
                                    {{ $types[$i] == 'text' ? 'selected' : '' }}>
                                    Text
                                </option>

                                <option value="number"
                                    {{ $types[$i] == 'number' ? 'selected' : '' }}>
                                    Number
                                </option>

                                <option value="date"
                                    {{ $types[$i] == 'date' ? 'selected' : '' }}>
                                    Date
                                </option>

                                <option value="boolean"
                                    {{ $types[$i] == 'boolean' ? 'selected' : '' }}>
                                    Boolean
                                </option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <button type="submit"
            class="bg-green-600 text-white px-5 py-2 rounded">
        Import Dataset
    </button>

</div>

</form>

@endsection