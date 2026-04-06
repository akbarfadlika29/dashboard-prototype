<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Dataset;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Dataset::query();

        if (in_array($user->role, ['admin_seksi', 'kepala_seksi'])) {
            $seksiIds = $user->seksi->pluck('id');
            $query->whereIn('seksi_id', $seksiIds);
        }

        $total = (clone $query)->count();
        $draft = (clone $query)->where('status', 'draft')->count();
        $pending = (clone $query)->where('status', 'pending')->count();
        $approved = (clone $query)->where('status', 'approved')->count();
        $rejected = (clone $query)->where('status', 'rejected')->count();
        $latest = (clone $query)->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'user',
            'total',
            'draft',
            'pending',
            'approved',
            'rejected',
            'latest'
        ));
    }
}
