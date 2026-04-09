<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\DatasetApprovalLog;
use Illuminate\Http\Request;

class AdminApprovalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = Dataset::with(['seksi', 'creator']);

        if ($user->isKepalaSeksi()) {
            $query->whereIn('seksi_id', $user->seksi->pluck('id'));
        }

        $dataset = $query->latest()->get();

        return view('admin.approval.index', compact('dataset'));
    }

    public function show(Dataset $dataset)
    {
        $dataset->load([
            'seksi',
            'creator',
            'data',
            'filters',
        ]);

        return view('admin.approval.show', compact('dataset'));
    }

    public function approve(Request $request, Dataset $dataset)
    {
        $this->authorizeApproval($dataset);

        $dataset->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        DatasetApprovalLog::create([
            'dataset_id' => $dataset->id,
            'action' => 'approve',
            'catatan' => $request->catatan,
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Dataset disetujui');
    }

    public function reject(Request $request, Dataset $dataset)
    {
        $this->authorizeApproval($dataset);

        $dataset->update([
            'status' => 'rejected'
        ]);

        DatasetApprovalLog::create([
            'dataset_id' => $dataset->id,
            'action' => 'reject',
            'catatan' => $request->catatan,
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Dataset ditolak');
    }

    public function cancel(Request $request, Dataset $dataset)
    {
        $dataset->update([
            'status' => 'draft',
        ]);

        return back()->with('seccess', 'Dataset berhasil dikembalikan ke draft.');
    }

    private function authorizeApproval(Dataset $dataset)
    {
        $user = auth()->user();

        if ($user->isSuperadmin()) {
            return;
        }

        if ($user->isKepalaSeksi() && $user->seksi->pluck('id')->contains($dataset->seksi_id)) {
            return;
        }

        abort(403);
    }
}