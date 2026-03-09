<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Dataset;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->get();

        return view('kategori.index', compact('kategori'));
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);

        $dataset = Dataset::where('kategori_id', $id)->get();

        return view('kategori.show', compact('kategori', 'dataset'));
    }
}
