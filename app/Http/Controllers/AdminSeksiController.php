<?php

namespace App\Http\Controllers;

use App\Models\Seksi;
use Illuminate\Http\Request;

class AdminSeksiController extends Controller
{
    public function index()
    {
        $seksi = Seksi::latest()->get();
        return view('admin.seksi.index', compact('seksi'));
    }

    public function create()
    {
        return view('admin.seksi.create');
    }

    public function store(Request $request)
    {
        Seksi::create($request->validate([
            'nama' => 'required'
        ]));

        return redirect()->route('admin.seksi.index');
    }
}