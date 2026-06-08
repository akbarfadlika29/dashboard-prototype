<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\DatasetApprovalLog;
use App\Models\DatasetData;
use App\Models\DatasetRevision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminApprovalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = auth()->user();

        $query = Dataset::with([
            'seksi',
            'creator',
            'activeRevision'
        ]);

        if ($user->isKepalaSeksi()) {
            $query->whereIn(
                'seksi_id',
                $user->seksi->pluck('id')
            );
        }

        $dataset = $query->latest()->get();

        return view('admin.approval.index', compact('dataset'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Dataset $dataset)
    {
        $dataset->load([
            'seksi',
            'creator',
            'filters',
            'activeRevision.changes'
        ]);

        $datasetData = $dataset->data()
            ->latest()
            ->paginate(10);

        return view(
            'admin.approval.show',
            compact('dataset', 'datasetData')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE DATASET BARU
    |--------------------------------------------------------------------------
    */

    public function approve(Request $request, Dataset $dataset)
    {
        $this->authorizeApproval($dataset);

        abort_unless(
            $dataset->status === 'pending',
            403
        );

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

        return back()->with(
            'success',
            'Dataset berhasil disetujui'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT DATASET BARU
    |--------------------------------------------------------------------------
    */

    public function reject(Request $request, Dataset $dataset)
    {
        $this->authorizeApproval($dataset);

        abort_unless(
            $dataset->status === 'pending',
            403
        );

        $dataset->update([
            'status' => 'rejected'
        ]);

        DatasetApprovalLog::create([
            'dataset_id' => $dataset->id,
            'action' => 'reject',
            'catatan' => $request->catatan,
            'created_by' => auth()->id(),
        ]);

        return back()->with(
            'success',
            'Dataset berhasil ditolak'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE REVISION
    |--------------------------------------------------------------------------
    */

    public function approveUpdate(
        Request $request,
        Dataset $dataset
    ) {
        $this->authorizeApproval($dataset);

        $revision = $dataset->activeRevision;

        abort_if(
            !$revision || $revision->status !== 'pending',
            403,
            'Revision tidak ditemukan'
        );

        DB::transaction(function () use (
            $dataset,
            $revision,
            $request
        ) {

            foreach ($revision->changes as $change) {

                switch ($change->action) {

                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE DATASET
                    |--------------------------------------------------------------------------
                    */

                    case 'update_dataset':

                        $dataset->update(
                            $change->after_json
                        );

                        break;

                    /*
                    |--------------------------------------------------------------------------
                    | CREATE ROW
                    |--------------------------------------------------------------------------
                    */

                    case 'create_row':

                        DatasetData::create([
                            'dataset_id' => $dataset->id,
                            'data_json' => $change->after_json['data_json'],
                            'created_by' => $revision->created_by
                        ]);

                        break;

                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE ROW
                    |--------------------------------------------------------------------------
                    */

                    case 'update_row':

                        $row = DatasetData::find(
                            $change->target_id
                        );

                        if ($row) {

                            $row->update([
                                'data_json' => $change->after_json['data_json']
                            ]);
                        }

                        break;

                    /*
                    |--------------------------------------------------------------------------
                    | DELETE ROW
                    |--------------------------------------------------------------------------
                    */

                    case 'delete_row':

                        $row = DatasetData::find(
                            $change->target_id
                        );

                        if ($row) {
                            $row->delete();
                        }

                        break;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | APPROVE REVISION
            |--------------------------------------------------------------------------
            */

            $revision->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            DatasetApprovalLog::create([
                'dataset_id' => $dataset->id,
                'action' => 'approve_revision',
                'catatan' => $request->catatan,
                'created_by' => auth()->id(),
            ]);
        });

        return back()->with(
            'success',
            'Revision berhasil disetujui'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT REVISION
    |--------------------------------------------------------------------------
    */

    public function rejectUpdate(
        Request $request,
        Dataset $dataset
    ) {
        $this->authorizeApproval($dataset);

        $revision = $dataset->activeRevision;

        abort_if(
            !$revision,
            403,
            'Revision tidak ditemukan'
        );

        $revision->changes()->delete();

        $revision->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        DatasetApprovalLog::create([
            'dataset_id' => $dataset->id,
            'action' => 'reject_revision',
            'catatan' => $request->catatan,
            'created_by' => auth()->id(),
        ]);

        return back()->with(
            'success',
            'Revision berhasil ditolak'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CANCEL
    |--------------------------------------------------------------------------
    */

    public function cancel(
        Request $request,
        Dataset $dataset
    ) {
        $dataset->update([
            'status' => 'draft'
        ]);

        return back()->with(
            'success',
            'Dataset berhasil dikembalikan ke draft'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | AUTHORIZATION
    |--------------------------------------------------------------------------
    */

    private function authorizeApproval(Dataset $dataset)
    {
        $user = auth()->user();

        if ($user->isSuperadmin()) {
            return;
        }

        if (
            $user->isKepalaSeksi() &&
            $user->seksi->pluck('id')->contains($dataset->seksi_id)
        ) {
            return;
        }

        abort(403);
    }
}