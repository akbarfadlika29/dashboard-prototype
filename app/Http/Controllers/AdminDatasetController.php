<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\DatasetData;
use App\Models\DatasetApprovalLog;
use App\Models\Kategori;
use App\Models\Seksi;
use App\Models\DatasetFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminDatasetController extends Controller
{
    private function ensureEditable(Dataset $dataset)
    {
        abort_unless(in_array($dataset->status, ['draft', 'rejected']), 403);
    }

    public function index()
    {
        $user = auth()->user();

        $query = Dataset::with(['kategori', 'seksi']);

        if ($user->isAdminSeksi()) {
            $query->whereIn('seksi_id', $user->seksi->pluck('id'));
        }

        $dataset = $query->latest()->get();

        return view('admin.dataset.index', compact('dataset'));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('nama')->get();

        if (auth()->user()->isAdminSeksi()) {
            $seksi = auth()->user()->seksi;
        } else {
            $seksi = Seksi::orderBy('nama')->get();
        }

        return view('admin.dataset.create', compact('kategori', 'seksi'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'seksi_id' => 'required',
            'kolom' => 'required|array|min:1'
        ]);

        $this->authorizeSeksi($request->seksi_id);

        $dataset = Dataset::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'kategori_id' => $request->kategori_id,
            'seksi_id' => $request->seksi_id,
            'deskripsi' => $request->deskripsi,
            'schema_json' => array_values($request->kolom),
            'kolom' => array_values($request->kolom),
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        // return response()->json($dataset, 200, [], JSON_PRETTY_PRINT);
        return redirect()->route('dataset.index')->with('success', 'Dataset berhasil dibuat');
    }

    public function show(Dataset $dataset)
    {
        $this->authorizeDataset($dataset);

        // $dataset->load('approvalLogs.creator');
        $data = $dataset->data()->latest()->paginate(10)->withQueryString();

        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
        return view('admin.dataset.show', compact('dataset', 'data'));
    }

    public function edit(Dataset $dataset)
    {
        $this->authorizeEditable($dataset);

        $kategori = Kategori::all();
        $seksi = auth()->user()->isAdminSeksi()
            ? auth()->user()->seksi
            : Seksi::all();

        return view('admin.dataset.edit', compact('dataset', 'kategori', 'seksi'));
    }

    public function update(Request $request, Dataset $dataset)
    {
        $this->authorizeEditable($dataset);

        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'seksi_id' => 'required',
            'schema_json' => 'required|array|min:1',
            'kolom' => 'required|array|min:1'
        ]);

        $oldSchema = $dataset->schema_json;
        $newSchema = array_values($request->schema_json);

        foreach ($dataset->data as $row) {
            $newData = [];

            foreach ($newSchema as $index => $key) {
                $oldKey = $oldSchema[$index] ?? null;
                $newData[$key] = $oldKey ? ($row->data_json[$oldKey] ?? null) : null;
            }

            $row->update([
                'data_json' => $newData
            ]);
        }

        $dataset->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'kategori_id' => $request->kategori_id,
            'seksi_id' => $request->seksi_id,
            'deskripsi' => $request->deskripsi,
            'schema_json' => $newSchema,
            'kolom' => array_values($request->kolom),
            'status' => 'draft',
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return redirect()->route('admin-dataset.show', $dataset)->with('success', 'Dataset berhasil diupdate');
    }

    public function destroy(Dataset $dataset)
    {
        $this->ensureEditable($dataset);

        $dataset->data()->delete();
        $dataset->filters()->delete();
        $dataset->delete();

        return redirect()->route('dataset.index')
            ->with('success', 'Dataset berhasil dihapus');
    }

    public function storeData(Request $request, Dataset $dataset)
    {
        $this->authorizeEditable($dataset);

        DatasetData::create([
            'dataset_id' => $dataset->id,
            'data_json' => $request->data,
            'created_by' => auth()->id()
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function updateData(Request $request, DatasetData $data)
    {
        $this->authorizeEditable($data->dataset);

        $data->update([
            'data_json' => $request->data
        ]);

        return back()->with('success', 'Data berhasil diubah');
    }

    public function destroyData(DatasetData $data)
    {
        $this->authorizeEditable($data->dataset);

        $data->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    public function submit(Dataset $dataset)
    {
        $this->authorizeEditable($dataset);

        $dataset->update([
            'status' => 'pending'
        ]);

        DatasetApprovalLog::create([
            'dataset_id' => $dataset->id,
            'action' => 'submit',
            'catatan' => 'Dataset diajukan',
            'created_by' => auth()->id()
        ]);

        return back()->with('success', 'Dataset diajukan');
    }

    public function cancel(Dataset $dataset)
    {
        abort_unless(auth()->user()->hasAnyRole(['kepala_seksi', 'superadmin']), 403);

        abort_unless(in_array($dataset->status, ['pending', 'approved']), 403);

        $dataset->update([
            'status' => 'draft',
        ]);

        return back()->with('success', 'Dataset dikembalikan ke draft');
    }

    private function authorizeEditable(Dataset $dataset)
    {
        $this->authorizeDataset($dataset);

        if (!$dataset->canEdit()) {
            abort(403, 'Dataset tidak bisa diedit');
        }
    }

    private function authorizeDataset(Dataset $dataset)
    {
        $user = auth()->user();

        if ($user->isAdminSeksi() && !$user->seksi->pluck('id')->contains($dataset->seksi_id)) {
            abort(403);
        }
    }

    private function authorizeSeksi($seksiId)
    {
        $user = auth()->user();

        if ($user->isAdminSeksi() && !$user->seksi->pluck('id')->contains($seksiId)) {
            abort(403);
        }
    }

    public function storeColumn(Request $request, Dataset $dataset)
    {
        $this->ensureEditable($dataset);

        $request->validate([
            'label' => 'required',
            'key' => 'required|alpha_dash',
        ]);

        $kolom = $dataset->kolom ?? [];
        $schema = $dataset->schema_json ?? [];

        $kolom[] = $request->label;
        $schema[] = $request->key;

        $dataset->update([
            'kolom' => $kolom,
            'schema_json' => $schema,
            'status' => 'draft',
        ]);

        return back()->with('success', 'Kolom ditambahkan');
    }

    public function updateColumn(Request $request, Dataset $dataset, $index)
    {
        // return response()->json($request, 200, [], JSON_PRETTY_PRINT);
        // Requirement:
        // - Edit kolom dataset
        // - Edit nama kolom
        // - Edit key / schema_json
        // - Edit tipe kolom
        // - Jika key berubah, seluruh data_json ikut disesuaikan
        // - Dataset otomatis kembali ke draft

        $this->ensureEditable($dataset);

        $request->validate([
            'label' => 'required|string',
            // 'key'   => 'required|string|alpha_dash',
            // 'type'  => 'required|in:text,number,date',
        ]);

        $kolom = $dataset->kolom ?? [];
        $schema = $dataset->schema_json ?? [];

        if (!isset($kolom[$index]) || !isset($schema[$index])) {
            abort(404);
        }

        $oldKey = $schema[$index]['name'];

        $oldType = $kolom[$index]['type'] ?? 'text';

        // rebuild array supaya perubahan JSON terdeteksi oleh Eloquent
        $kolom[$index] = [
            'name' => $request->label,
            'type' => $oldType,
        ];

        $schema[$index] = [
            'name' => $request->label,
            'type' => $oldType,
        ];

        // update semua data_json bila key berubah
        foreach ($dataset->data as $row) {
            $json = $row->data_json ?? [];

            if (
                $oldKey !== $request->label &&
                array_key_exists($oldKey, $json)
            ) {
                $json[$request->label] = $json[$oldKey];
                unset($json[$oldKey]);
            }

            $row->update([
                'data_json' => $json,
            ]);
        }

        $dataset->kolom = $kolom;
        $dataset->schema_json = $schema;
        $dataset->status = 'draft';
        $dataset->save();

        $newKey = $request->label;

        if ($oldKey !== $newKey) {
            DatasetFilter::where('dataset_id', $dataset->id)
                ->where('kolom', $oldKey)
                ->update([
                    'kolom' => $newKey
                ]);
        }

        return back()->with('success', 'Kolom berhasil diubah');
    }

    public function destroyColumn(Dataset $dataset, $index)
    {
        $this->ensureEditable($dataset);

        $kolom = $dataset->kolom;
        $schema = $dataset->schema_json;

        $removedKey = $schema[$index]['name'];

        unset($kolom[$index], $schema[$index]);

        foreach ($dataset->data as $row) {
            $json = $row->data_json;
            unset($json[$removedKey]);
            $row->update(['data_json' => $json]);
        }

        DatasetFilter::where('dataset_id', $dataset->id)
            ->where('kolom', $removedKey)
            ->delete();

        $dataset->update([
            'kolom' => array_values($kolom),
            'schema_json' => array_values($schema),
            'status' => 'draft',
        ]);

        return back()->with('success', 'Kolom berhasil dihapus');
    }

    public function updateRow(Request $request, Dataset $dataset, DatasetData $row)
    {
        // Requirement:
        // - Edit data dataset
        // - Data disimpan kembali ke data_json
        // - Dataset otomatis kembali ke draft

        $this->ensureEditable($dataset);

        $json = [];

        foreach ($dataset->schema_json as $key) {

            $field = is_array($key)
                ? ($key['key'] ?? $key['name'])
                : $key;

            $json[$field] = $request->input($field);
        }

        $row->update([
            'data_json' => $json,
        ]);

        $dataset->update([
            'status' => 'draft',
        ]);

        return back()->with('success', 'Data berhasil diubah');
    }

    public function destroyRow(Dataset $dataset, DatasetData $row)
    {
        $this->ensureEditable($dataset);

        $row->delete();

        $dataset->update(['status' => 'draft']);

        return back()->with('success', 'Data berhasil dihapus');
    }

    public function storeFilter(Request $request, Dataset $dataset)
    {
        // $this->ensureEditable($dataset);

        $request->validate([
            'kolom' => 'required',
        ]);

        DatasetFilter::create([
            'dataset_id' => $dataset->id,
            'kolom' => $request->kolom,
        ]);

        return back()->with('success', 'Filter berhasil ditambahkan');
    }

    public function updateFilter(Request $request, Dataset $dataset, DatasetFilter $filter)
    {
        $this->ensureEditable($dataset);

        $filter->update([
            'kolom' => $request->kolom,
            'label' => $request->label,
        ]);

        return back()->with('success', 'Filter berhasil diubah');
    }

    public function destroyFilter(Dataset $dataset, DatasetFilter $filter)
    {
        // $this->ensureEditable($dataset);

        $filter->delete();

        return back()->with('success', 'Filter berhasil dihapus');
    }

    public function import()
    {
        $kategori = Kategori::all();
        $seksi = Seksi::all();

        return view('admin.dataset.import', compact('kategori', 'seksi'));
    }

    public function importPreview(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'seksi_id' => 'required',
            'file' => 'required|mimes:csv,txt,xlsx'
        ]);

        $file = $request->file('file');

        $data = array_map('str_getcsv', file($file));

        return view('admin.dataset.import_preview', [
            'data' => array_slice($data, 0, 10),
            'request' => $request->all()
        ]);
    }
}