<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminKategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->paginate(10);
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:150',
            'slug' => 'nullable|unique:kategori,slug',
            'deskripsi' => 'nullable'
        ]);

        Kategori::create([
            'nama' => $request->nama,
            'slug' => $request->slug ?: Str::slug($request->nama),
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama' => 'required|max:150',
            'slug' => 'nullable|unique:kategori,slug,' . $kategori->id,
            'deskripsi' => 'nullable'
        ]);

        $kategori->update([
            'nama' => $request->nama,
            'slug' => $request->slug ?: Str::slug($request->nama),
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->dataset()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan dataset');
        }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}