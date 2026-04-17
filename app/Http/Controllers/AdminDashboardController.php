<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Dataset;
use App\Services\Dashboard\StatisticService;
use App\Models\Kategori;

class AdminDashboardController extends Controller
{
    public function index(StatisticService $statisticService)
    {
        $statistics = $statisticService->getAll();
        $seksi_id = auth()->user()->seksi->pluck('id');

        // dd($seksi_id[0]);
        // dd($statistics['top_kecamatan']['seksi_id']);

        return view('admin.dashboard.index', compact('statistics', 'seksi_id'));
    }
}
