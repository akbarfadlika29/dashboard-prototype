<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Dataset;
use App\Services\Dashboard\StatisticService;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->get();

        return view('kategori.index', compact('kategori'));
    }

    public function show($id, StatisticService $statisticService)
    {
        $kategori = Kategori::findOrFail($id);

        $dataset = Dataset::where('kategori_id', $id)->get();

        $statistics = $statisticService->getAll();

        return view('kategori.show', compact(
            'kategori',
            'dataset',
            'statistics'
        ));
    }
}
