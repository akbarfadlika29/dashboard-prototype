<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\DatasetApprovalLog;
use App\Models\DatasetData;
use App\Models\DatasetFilter;
use App\Models\DatasetRevision;
use App\Models\DatasetRevisionChange;
use App\Models\DatasetFileRevisionChange;
use App\Models\Kategori;
use App\Models\Seksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdminDatasetController extends Controller
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
            'kategori',
            'seksi',
            'activeRevision'
        ]);

        if ($user->isAdminSeksi()) {
            $query->whereIn('seksi_id', $user->seksi->pluck('id'));
        }

        $dataset = $query->latest()->get();

        // return response()->json($dataset, 200, [], JSON_PRETTY_PRINT);

        return view('admin.dataset.index', compact('dataset'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $kategori = Kategori::orderBy('nama')->get();

        $seksi = auth()->user()->isAdminSeksi()
            ? auth()->user()->seksi
            : Seksi::orderBy('nama')->get();

        return view('admin.dataset.create', compact(
            'kategori',
            'seksi'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'seksi_id' => 'required',
            'kolom' => 'required|array|min:1'
        ]);

        $this->authorizeSeksi($request->seksi_id);

        Dataset::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'kategori_id' => $request->kategori_id,
            'seksi_id' => $request->seksi_id,
            'deskripsi' => $request->deskripsi,
            'schema_json' => array_values($request->kolom),
            'kolom' => array_values($request->kolom),
            'status' => Dataset::STATUS_DRAFT,
            'created_by' => auth()->id(),
            'count_approved' => 0,
        ]);

        return redirect()
            ->route('dataset.index')
            ->with('success', 'Dataset berhasil dibuat');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Dataset $dataset)
    {
        $this->authorizeDataset($dataset);

        $dataset->load([
            'kategori',
            'seksi',
            'creator',
            'filters',
            'activeRevision.changes'
        ]);

        $displayData = $dataset->displayData();

        $revision = $dataset->activeRevision;

        $data = $displayData;

        // return response()->json($dataset, 200, [], JSON_PRETTY_PRINT);

        $createCount = 0;
        $updateCount = 0;
        $deleteCount = 0;
        $datasetUpdate = 0;

        if ($revision) {
            $createCount = $revision->changes
                ->where('action', 'create_row')
                ->count();

            $updateCount = $revision->changes
                ->where('action', 'update_row')
                ->count();

            $deleteCount = $revision->changes
                ->where('action', 'delete_row')
                ->count();

            $datasetUpdate = $revision->changes
                ->where('action', 'update_dataset')
                ->count();
        }

        return view('admin.dataset.show', compact(
            'dataset',
            'data',
            'revision',
            'createCount',
            'updateCount',
            'deleteCount',
            'datasetUpdate'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Dataset $dataset)
    {
        $this->authorizeEditable($dataset);

        if ($dataset->first_created === 'files') {

            return view(
                'admin.dataset.partials.edit-files',
                compact('dataset')
            );

        }

        $kategori = Kategori::all();

        $seksi = auth()->user()->isAdminSeksi()
            ? auth()->user()->seksi
            : Seksi::all();

        return view('admin.dataset.edit', compact(
            'dataset',
            'kategori',
            'seksi'
        ));
    }

    public function editFile(Dataset $dataset)
    {
        $this->authorizeEditable($dataset);

        abort_if(
            $dataset->first_created !== 'files',
            404
        );

        return view(
            'admin.dataset.partials.edit-files',
            compact('dataset')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATASET
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Dataset $dataset)
    {
        $this->authorizeEditable($dataset);

        if ($dataset->first_created === 'files') {

            return $this->updateFileDataset(
                $request,
                $dataset
            );

        }

        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'seksi_id' => 'required',
            'schema_json' => 'required|array|min:1',
            'kolom' => 'required|array|min:1'
        ]);

        /*
        |--------------------------------------------------------------------------
        | DIRECT UPDATE (DRAFT / REJECTED)
        |--------------------------------------------------------------------------
        */

        if ($dataset->isDirectEdit()) {

            $dataset->update([
                'nama' => $request->nama,
                'slug' => Str::slug($request->nama),
                'kategori_id' => $request->kategori_id,
                'seksi_id' => $request->seksi_id,
                'deskripsi' => $request->deskripsi,
                'schema_json' => array_values($request->schema_json),
                'kolom' => array_values($request->kolom),
            ]);

            return redirect()
                ->route('dataset.show.admin', $dataset)
                ->with('success', 'Dataset berhasil diupdate');
        }

        /*
        |--------------------------------------------------------------------------
        | REVISION UPDATE (APPROVED)
        |--------------------------------------------------------------------------
        */

        $revision = $this->getOrCreateRevision($dataset);

        DatasetRevisionChange::create([
            'revision_id' => $revision->id,
            'action' => 'update_dataset',
            'before_json' => [
                'nama' => $dataset->nama,
                'kategori_id' => $dataset->kategori_id,
                'seksi_id' => $dataset->seksi_id,
                'deskripsi' => $dataset->deskripsi,
                'schema_json' => $dataset->schema_json,
                'kolom' => $dataset->kolom,
            ],
            'after_json' => [
                'nama' => $request->nama,
                'slug' => Str::slug($request->nama),
                'kategori_id' => $request->kategori_id,
                'seksi_id' => $request->seksi_id,
                'deskripsi' => $request->deskripsi,
                'schema_json' => array_values($request->schema_json),
                'kolom' => array_values($request->kolom),
            ]
        ]);

        return redirect()
            ->route('dataset.show.admin', $dataset)
            ->with('success', 'Perubahan disimpan ke draft revision');
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

        // $this->ensureEditable($dataset);

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

    public function updateFile(
        Request $request,
        Dataset $dataset
    )
    {
        $this->authorizeEditable($dataset);

        abort_if(
            $dataset->first_created !== 'files',
            404
        );

        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $file = $request->file('file');

        $originalName = $file->getClientOriginalName();
        $mime = $file->getMimeType();
        $size = $file->getSize();

        $newName = Str::uuid().'.'.$file->getClientOriginalExtension();

        $directory = public_path('uploads/dataset');

        if ($dataset->isDirectEdit()) {
            // hapus file lama
            $oldFile = public_path($dataset->file_storage);

            if (file_exists($oldFile)) {
                unlink($oldFile);
            }

            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $file->move($directory, $newName);

            $dataset->update([
                'file_storage' => 'uploads/dataset/'.$newName,
                'file_original_name' => $originalName,
                'file_mime' => $mime,
                'file_size' => $size,
            ]);

            return redirect()
                ->route('dataset.show.admin', $dataset)
                ->with('success', 'File dataset berhasil diperbarui.');
        }

        $revision = $this->getOrCreateRevision($dataset);

        $file->move($directory, $newName);
        
        DatasetFileRevisionChange::create([
            'revision_id' => $revision->id,
            'action' => 'update_file',
            'after_file_storage' => 'uploads/dataset/'.$newName,
            'after_file_original_name' => $originalName,
            'after_file_mime' => $mime,
            'after_file_size' => $size,
        ]);

        
        return back()->with(
            'success',
            'Perubahan berhasil disimpan ke draft revision'
        );
    }

    public function destroyColumn(Dataset $dataset, $index)
    {
        // $this->ensureEditable($dataset);

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

    /*
    |--------------------------------------------------------------------------
    | DESTROY DATASET
    |--------------------------------------------------------------------------
    */

    public function destroy(Dataset $dataset)
{
    // $this->authorizeEditable($dataset);

    abort_if(
        $dataset->isApproved(),
        403,
        'Dataset approved tidak dapat dihapus langsung'
    );

    /*
    |--------------------------------------------------------------------------
    | DATASET FILES
    |--------------------------------------------------------------------------
    */
    if ($dataset->first_created === 'files') {

        $file = public_path($dataset->file_storage);

        if (file_exists($file) && is_file($file)) {
            unlink($file);
        }

        $dataset->filters()->delete();
        $dataset->delete();

        return redirect()
            ->route('dataset.index')
            ->with('success', 'Dataset berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | DATASET MANUAL / IMPORT CSV
    |--------------------------------------------------------------------------
    */
    $dataset->data()->delete();
    $dataset->filters()->delete();
    $dataset->delete();

    return redirect()
        ->route('dataset.index')
        ->with('success', 'Dataset berhasil dihapus');
}

    /*
    |--------------------------------------------------------------------------
    | STORE ROW
    |--------------------------------------------------------------------------
    */

    public function storeRow(Request $request, Dataset $dataset)
    {
        $this->authorizeEditable($dataset);

        /*
        |--------------------------------------------------------------------------
        | DIRECT CREATE
        |--------------------------------------------------------------------------
        */

        if ($dataset->isDirectEdit()) {

            DatasetData::create([
                'dataset_id' => $dataset->id,
                'data_json' => $request->data,
                'created_by' => auth()->id()
            ]);

            return back()->with('success', 'Data berhasil ditambahkan');
        }

        /*
        |--------------------------------------------------------------------------
        | REVISION CREATE
        |--------------------------------------------------------------------------
        */

        $revision = $this->getOrCreateRevision($dataset);

        DatasetRevisionChange::create([
            'revision_id' => $revision->id,
            'action' => 'create_row',
            'after_json' => [
                'data_json' => $request->data,
                'created_by' => auth()->id()
            ]
        ]);

        return back()->with(
            'success',
            'Perubahan berhasil disimpan ke draft revision'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE ROW
    |--------------------------------------------------------------------------
    */

    public function updateRow(
        Request $request,
        Dataset $dataset,
        DatasetData $row
    ) {
        $this->authorizeEditable($dataset);

        $json = [];

        foreach ($dataset->schema_json as $key) {

            $field = is_array($key)
                ? ($key['key'] ?? $key['name'])
                : $key;

            $json[$field] = $request->input("data.$field");
        }

        /*
        |--------------------------------------------------------------------------
        | DIRECT UPDATE
        |--------------------------------------------------------------------------
        */

        if ($dataset->isDirectEdit()) {

            $row->update([
                'data_json' => $json
            ]);

            return back()->with('success', 'Data berhasil diubah');
        }

        /*
        |--------------------------------------------------------------------------
        | REVISION UPDATE
        |--------------------------------------------------------------------------
        */

        $revision = $this->getOrCreateRevision($dataset);

        DatasetRevisionChange::create([
            'revision_id' => $revision->id,
            'action' => 'update_row',
            'target_id' => $row->id,
            'before_json' => [
                'data_json' => $row->data_json
            ],
            'after_json' => [
                'data_json' => $json
            ]
        ]);

        return back()->with(
            'success',
            'Perubahan berhasil disimpan ke draft revision'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ROW
    |--------------------------------------------------------------------------
    */

    public function destroyRow(
        Dataset $dataset,
        DatasetData $row
    ) {
        $this->authorizeEditable($dataset);

        /*
        |--------------------------------------------------------------------------
        | DIRECT DELETE
        |--------------------------------------------------------------------------
        */

        if ($dataset->isDirectEdit()) {

            $row->delete();

            return back()->with('success', 'Data berhasil dihapus');
        }

        /*
        |--------------------------------------------------------------------------
        | REVISION DELETE
        |--------------------------------------------------------------------------
        */

        $revision = $this->getOrCreateRevision($dataset);

        DatasetRevisionChange::create([
            'revision_id' => $revision->id,
            'action' => 'delete_row',
            'target_id' => $row->id,
            'before_json' => [
                'data_json' => $row->data_json
            ]
        ]);

        return back()->with(
            'success',
            'Perubahan berhasil disimpan ke draft revision'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT
    |--------------------------------------------------------------------------
    */

    public function submit(Dataset $dataset)
    {
        $this->authorizeEditable($dataset);

        /*
        |--------------------------------------------------------------------------
        | DATASET BARU
        |--------------------------------------------------------------------------
        */

        if ($dataset->isDraft() || $dataset->isRejected()) {

            $dataset->update([
                'status' => Dataset::STATUS_PENDING
            ]);

            DatasetApprovalLog::create([
                'dataset_id' => $dataset->id,
                'action' => 'submit',
                'catatan' => 'Dataset diajukan',
                'created_by' => auth()->id()
            ]);

            return back()->with(
                'success',
                'Dataset berhasil diajukan'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | REVISION SUBMIT
        |--------------------------------------------------------------------------
        */

        $revision = $dataset->activeRevision;

        abort_if(!$revision, 403, 'Revision tidak ditemukan');

        abort_if(
            ($revision->changes()->count() < 1 && $dataset->first_created !== 'files'),
            403,
            'Belum ada perubahan'
        );

        $revision->update([
            'status' => 'pending'
        ]);

        DatasetApprovalLog::create([
            'dataset_id' => $dataset->id,
            'action' => 'submit_revision',
            'catatan' => 'Revision diajukan',
            'created_by' => auth()->id()
        ]);

        return back()->with(
            'success',
            'Revision berhasil diajukan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

    public function storeFilter(Request $request, Dataset $dataset)
    {
        $request->validate([
            'kolom' => 'required'
        ]);

        DatasetFilter::create([
            'dataset_id' => $dataset->id,
            'kolom' => $request->kolom
        ]);

        return back()->with(
            'success',
            'Filter berhasil ditambahkan'
        );
    }

    public function updateFilter(
        Request $request,
        Dataset $dataset,
        DatasetFilter $filter
    ) {
        $filter->update([
            'kolom' => $request->kolom,
            'label' => $request->label,
        ]);

        return back()->with(
            'success',
            'Filter berhasil diubah'
        );
    }

    public function destroyFilter(
        Dataset $dataset,
        DatasetFilter $filter
    ) {
        $filter->delete();

        return back()->with(
            'success',
            'Filter berhasil dihapus'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | REVISION HELPER
    |--------------------------------------------------------------------------
    */

    private function getOrCreateRevision(Dataset $dataset)
    {
        $revision = $dataset->activeRevision;

        if ($revision) {
            return $revision;
        }

        return DatasetRevision::create([
            'dataset_id' => $dataset->id,
            'status' => 'draft',
            'created_by' => auth()->id()
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | AUTHORIZATION
    |--------------------------------------------------------------------------
    */

    private function authorizeEditable(Dataset $dataset)
    {
        $this->authorizeDataset($dataset);

        if (!$dataset->isEditable()) {
            abort(403, 'Dataset tidak bisa diedit');
        }
    }

    private function authorizeDataset(Dataset $dataset)
    {
        $user = auth()->user();

        if (
            $user->isAdminSeksi() &&
            !$user->seksi->pluck('id')->contains($dataset->seksi_id)
        ) {
            abort(403);
        }
    }

    private function authorizeSeksi($seksiId)
    {
        $user = auth()->user();

        if (
            $user->isAdminSeksi() &&
            !$user->seksi->pluck('id')->contains($seksiId)
        ) {
            abort(403);
        }
    }

    public function import()
    {
        $kategori = Kategori::all();
        $seksi    = Seksi::all();

        return view('admin.dataset.import', compact('kategori', 'seksi'));
    }

    public function importPreview(Request $request)
    {
        $request->validate([
            'nama'        => 'required',
            'kategori_id' => 'required',
            'seksi_id'    => 'required',
            'file'        => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');

        // baca file upload sementara
        $rows = array_map('str_getcsv', file($file->getRealPath()));

        // hapus baris kosong
        $rows = array_filter($rows, function ($row) {
            return count(array_filter($row, fn($cell) => trim($cell) !== '')) > 0;
        });

        $rows = array_values($rows);

        if (count($rows) < 1) {
            return back()->with('error', 'CSV kosong.');
        }

        // simpan file temp
        $path = $file->store('temp');

        $headers = array_map('trim', $rows[0]);
        $sampleRows = array_slice($rows, 1, 10);

        // auto detect type per kolom
        $types = [];

        foreach ($headers as $index => $header) {
            $columnValues = [];

            foreach ($sampleRows as $row) {
                $columnValues[] = $row[$index] ?? null;
            }

            $types[$index] = $this->detectColumnType($columnValues);
        }

        $data = collect(array_slice($rows,1))
            ->map(function($row) use($headers){

                return array_pad($row, count($headers), '');

            });

        $kategoriNama = Kategori::find($request->kategori_id)?->nama;
        $seksiNama = Seksi::find($request->seksi_id)?->nama;

        return view('admin.dataset.import_preview', [
            'data'=>$data,
            'headers'=>$headers,
            'types'=>$types,
            'request'=>$request->except('file'),
            'file_path'=>$path,
            'totalRows' => count($rows) - 1,
            'totalColumns' => count($headers),
            'kategoriNama' => $kategoriNama,
            'seksiNama' => $seksiNama,
        ]);
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'nama'        => 'required',
            'kategori_id' => 'required',
            'seksi_id'    => 'required',
            'file_path'   => 'required',
            'columns'     => 'required|array',
        ]);

        if (!Storage::exists($request->file_path)) {
            return back()->with('error', 'File temporary tidak ditemukan.');
        }

        $filePath = Storage::path($request->file_path);

        // baca seluruh file
        $content = file_get_contents($filePath);

        // ubah ke UTF-8 jika diperlukan
        $encoding = mb_detect_encoding(
            $content,
            ['UTF-8', 'Windows-1252', 'ISO-8859-1'],
            true
        );

        if ($encoding && $encoding !== 'UTF-8') {
            $content = mb_convert_encoding($content, 'UTF-8', $encoding);
        }

        // pecah menjadi baris
        $lines = preg_split("/\r\n|\n|\r/", $content);

        // parse CSV
        $rows = array_map('str_getcsv', $lines);

        $rows = array_filter($rows, function ($row) {
            return count(array_filter($row, fn($cell) => trim($cell) !== '')) > 0;
        });

        $rows = array_values($rows);

        if (count($rows) < 1) {
            return back()->with('error', 'CSV kosong.');
        }

        $header = array_map('trim', $rows[0]);
        $dataRows = array_slice($rows, 1);

        /*
        |--------------------------------------------------------------------------
        | SCHEMA JSON
        |--------------------------------------------------------------------------
        | sementara schema_json dan kolom sama dulu
        */
        $schema = [];

        foreach ($request->columns as $col) {
            $schema[] = [
                'name' => $col['name'],
                'type' => $col['type'],
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE DATASET
        |--------------------------------------------------------------------------
        */
        $dataset = Dataset::create([
            'nama'        => $request->nama,
            'slug'        => Str::slug($request->nama) . '-' . time(),
            'kategori_id' => $request->kategori_id,
            'seksi_id'    => $request->seksi_id,
            'schema_json' => $schema,
            'kolom'       => $schema, // sementara sama
            'status'      => 'draft',
            'created_by'  => auth()->id(),
            'count_approved' => 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | INSERT DATA ROW
        |--------------------------------------------------------------------------
        */
        foreach ($dataRows as $row) {

            if (count($row) !== count($header)) {
                continue;
            }

            $json = [];

            foreach ($header as $i => $colName) {
                $type = $schema[$i]['type'] ?? 'text';
                $value = $row[$i] ?? null;

                $json[$colName] = $this->castValue($value, $type);
            }

            DatasetData::create([
                'dataset_id' => $dataset->id,
                'data_json'  => $json,
                'created_by' => auth()->id(),
            ]);
        }

        // hapus file temp
        Storage::delete($request->file_path);

        return redirect()
            ->route('dataset.index')
            ->with('success', 'Dataset berhasil diimport.');
    }

    public function importFiles()
    {
        $kategori = Kategori::all();
        $seksi = Seksi::all();

        return view('admin.dataset.import_files', compact('kategori', 'seksi'));
    }

    public function importFilesPreview(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'seksi_id' => 'required|exists:seksi,id',
            'file' => 'required|mimes:pdf,xlsx,xls,jpg,jpeg,png|max:10240', 
        ]);

        $file = $request->file('file');

// Ambil semua informasi dulu
$originalName = $file->getClientOriginalName();
$extension    = strtoupper($file->getClientOriginalExtension());
$mime         = $file->getMimeType();
$size         = $file->getSize();
$sizeHuman    = number_format($size / 1024, 2) . ' KB';

// Baru dipindahkan
$tempDirectory = public_path('uploads/temp');

if (!file_exists($tempDirectory)) {
    mkdir($tempDirectory, 0755, true);
}

$tempName = time().'_'.Str::random(10).'.'.$file->getClientOriginalExtension();

$file->move($tempDirectory, $tempName);

$tempPath = 'uploads/temp/'.$tempName;

return view('admin.dataset.import_files_preview', [
    'request'       => $request->except('file'),
    'file_path'     => $tempPath,
    'original_name' => $originalName,
    'extension'     => $extension,
    'mime'          => $mime,
    'size'          => $size,
    'size_human'    => $sizeHuman,
]);
    }

    public function importFilesStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'seksi_id' => 'required|exists:seksi,id',
            'file_path' => 'required|string',
            'original_name' => 'required|string',
            'mime' => 'required|string',
            'size' => 'required|numeric',
        ]);

        $tempFile = public_path($request->file_path);

        if (!file_exists($tempFile)) {
            return back()->with('error', 'File temporary tidak ditemukan.');
        }

        $extension = pathinfo($tempFile, PATHINFO_EXTENSION);

        $newName = Str::uuid() . '.' . $extension;

        // Folder tujuan
        $finalDirectory = public_path('uploads/dataset');

        // Buat folder jika belum ada
        if (!file_exists($finalDirectory)) {
            mkdir($finalDirectory, 0755, true);
        }

        $finalFile = $finalDirectory . '/' . $newName;

        // Pindahkan file
        rename($tempFile, $finalFile);

        // Path yang disimpan di database
        $finalPath = 'uploads/dataset/' . $newName;

        Dataset::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama).'-'.time(),
            'kategori_id' => $request->kategori_id,
            'seksi_id' => $request->seksi_id,
            'schema_json' => null,
            'kolom' => null,
            'status' => 'draft',
            'created_by' => auth()->id(),
            'count_approved' => 0,
            'first_created' => 'files',
            'file_storage' => $finalPath,
            'file_original_name' => $request->original_name,
            'file_mime' => $request->mime,
            'file_size' => $request->size,
        ]);

        return redirect()->route('dataset.index')->with('success', 'Dataset berhasil dibuat.');
    }

    private function detectColumnType(array $values)
    {
        $values = array_filter($values, fn($v) => $v !== null && trim($v) !== '');

        if (empty($values)) {
            return 'text';
        }

        $isNumber = true;
        $isDate = true;
        $isBoolean = true;

        foreach ($values as $value) {
            $value = trim($value);

            // number
            if (!is_numeric(str_replace(',', '.', $value))) {
                $isNumber = false;
            }

            // date
            if (strtotime($value) === false) {
                $isDate = false;
            }

            // boolean
            if (!in_array(strtolower($value), [
                '1', '0',
                'true', 'false',
                'yes', 'no',
                'ya', 'tidak'
            ])) {
                $isBoolean = false;
            }
        }

        if ($isBoolean) return 'boolean';
        if ($isNumber)  return 'number';
        if ($isDate)    return 'date';

        return 'text';
    }

    private function castValue($value, $type)
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $value = trim($value);

        return match ($type) {
            'number' => is_numeric($value)
                ? (float) str_replace(',', '.', $value)
                : null,

            'boolean' => in_array(strtolower($value), [
                '1', 'true', 'yes', 'ya'
            ]),

            'date' => date('Y-m-d', strtotime($value)),

            default => $value,
        };
    }
}