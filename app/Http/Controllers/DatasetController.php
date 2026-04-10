<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dataset;
use App\Models\DatasetData;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class DatasetController extends Controller
{
    public function show(Dataset $dataset)
    {
        // Hanya dataset yang sudah approved yang boleh dilihat publik
        abort_if($dataset->status !== 'approved', 404);

        $perPage = request()->get('per_page', 10);

        $filters = $dataset->filters;

        $query = DatasetData::where('dataset_id', $dataset->id);

        foreach ($filters as $filter) {
            $value = request($filter->kolom);

            if ($value !== null && $value !== '') {
                if ($filter->kolom === 'tahun') {
                    $query->where('tahun', $value);
                } else {
                    $query->where("data_json->{$filter->kolom}", $value);
                }
            }
        }

        $datasetData = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $filterOptions = [];

        foreach ($filters as $filter) {
            if ($filter->kolom === 'tahun') {
                $filterOptions['tahun'] = DatasetData::where('dataset_id', $dataset->id)
                    ->select('tahun')
                    ->distinct()
                    ->orderBy('tahun')
                    ->pluck('tahun');
            } else {
                $filterOptions[$filter->kolom] = DatasetData::where('dataset_id', $dataset->id)
                    ->get()
                    ->pluck("data_json.{$filter->kolom}")
                    ->filter()
                    ->unique()
                    ->sort()
                    ->values();
            }
        }

        // return response()->json($dataset, 200, [], JSON_PRETTY_PRINT);

        return view('public.dataset.show', compact(
            'dataset',
            'datasetData',
            'perPage',
            'filters',
            'filterOptions'
        ));
    }

    public function exportCsv(Dataset $dataset)
    {
        // Hanya dataset approved yang boleh di-export
        abort_if($dataset->status !== 'approved', 404);

        $filename = 'dataset-' . $dataset->slug . '.csv';

        return new StreamedResponse(function () use ($dataset) {
            $handle = fopen('php://output', 'w');

            // Header menggunakan nama kolom tampilan
            fputcsv($handle, $dataset->kolom);

            foreach ($dataset->data as $row) {
                $line = [];

                foreach ($dataset->schema_json as $key) {
                    $line[] = $row->data_json[$key] ?? '';
                }

                fputcsv($handle, $line);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportExcel(Dataset $dataset)
    {
        abort_if($dataset->status !== 'approved', 404);

        $filters = $dataset->filters;

        $query = DatasetData::where('dataset_id', $dataset->id);

        foreach ($filters as $filter) {
            $value = request($filter->kolom);

            if ($value !== null && $value !== '') {
                if ($filter->kolom === 'tahun') {
                    $query->where('tahun', $value);
                } else {
                    $query->where("data_json->{$filter->kolom}", $value);
                }
            }
        }

        $filename = $dataset->nama . '.csv';

        return new StreamedResponse(function () use ($dataset, $query) {

            $handle = fopen('php://output', 'w');

            // =====================
            // HEADER
            // =====================
            $headers = array_map(function ($col) {
                return $col['name'] ?? '';
            }, $dataset->kolom);

            fputcsv($handle, $headers);

            // =====================
            // DATA
            // =====================
            foreach ($query->get() as $row) {

                $line = [];

                foreach ($dataset->schema_json as $col) {
                    $key = $col['name']; // 🔥 ambil name

                    $line[] = $row->data_json[$key] ?? '';
                }

                fputcsv($handle, $line);
            }

            fclose($handle);

        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportPdf(Dataset $dataset)
    {
        abort_if($dataset->status !== 'approved', 404);

        $filters = $dataset->filters;

        $query = DatasetData::where('dataset_id', $dataset->id);

        foreach ($filters as $filter) {
            $value = request($filter->kolom);

            if ($value !== null && $value !== '') {
                if ($filter->kolom === 'tahun') {
                    $query->where('tahun', $value);
                } else {
                    $query->where("data_json->{$filter->kolom}", $value);
                }
            }
        }

        $rows = $query->latest()->get();

        $pdf = Pdf::loadView('public.dataset.export-pdf', [
            'dataset' => $dataset,
            'rows' => $rows,
        ])->setPaper('a4', 'landscape');

        return $pdf->download($dataset->nama . '.pdf');
    }
}