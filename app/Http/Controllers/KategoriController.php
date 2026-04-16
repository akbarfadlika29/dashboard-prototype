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
        $kategori = Kategori::orderBy('nama','asc')->latest()->get();

        return view('public.kategori.index', compact('kategori'));
    }

    public function show($id, StatisticService $statisticService)
    {
        $kategori = Kategori::findOrFail($id);

        $dataset = Dataset::where('kategori_id', $id)->where('status', 'approved')->get();

        $statistics = $statisticService->getAll();

        // return response()->json($statistics, 200, [], JSON_PRETTY_PRINT);

        return view('public.kategori.show', compact(
            'kategori',
            'dataset',
            'statistics'
        ));
    }
}
