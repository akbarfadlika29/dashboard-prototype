@extends('layouts.admin')

@section('title', 'Preview Import')

@section('content')

<h1 class="text-xl font-bold mb-6">Preview Data</h1>

<div class="bg-white p-4 rounded-xl shadow overflow-auto">
    <table class="table-auto w-full border">
        @foreach($data as $row)
            <tr>
                @foreach($row as $cell)
                    <td class="border p-2 text-sm">
                        {{ $cell }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>

<form method="POST" action="#">
    @csrf

    {{-- nanti dipakai kirim ulang data --}}
    @foreach($request as $key => $value)
        @if(!is_array($value))
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach

    <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
        Import Data
    </button>
</form>

@endsection