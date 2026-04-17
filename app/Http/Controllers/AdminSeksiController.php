<?php

namespace App\Http\Controllers;

use App\Models\Seksi;
use Illuminate\Http\Request;

class AdminSeksiController extends Controller
{
    public function index()
    {
        $seksi = Seksi::withCount(['users', 'datasets'])
            ->latest()
            ->paginate(10);

        return view('admin.seksi.index', compact('seksi'));
    }

    public function create()
    {
        return view('admin.seksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:150|unique:seksi,nama'
        ]);

        Seksi::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.seksi.index')
            ->with('success', 'Seksi berhasil ditambahkan');
    }

    public function edit(Seksi $seksi)
    {
        return view('admin.seksi.edit', compact('seksi'));
    }

    public function update(Request $request, Seksi $seksi)
    {
        $request->validate([
            'nama' => 'required|max:150|unique:seksi,nama,' . $seksi->id
        ]);

        $seksi->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.seksi.index')
            ->with('success', 'Seksi berhasil diupdate');
    }

    public function destroy(Seksi $seksi)
    {
        if ($seksi->users()->count() > 0 || $seksi->datasets()->count() > 0) {
            return back()->with('error', 'Seksi tidak bisa dihapus karena masih digunakan');
        }

        $seksi->delete();

        return back()->with('success', 'Seksi berhasil dihapus');
    }
}