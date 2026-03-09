<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dashboard\StatisticService;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function data(StatisticService $service)
    {
        return response()->json([
            'charts' => $service->getAll()
        ]);
    }
}
