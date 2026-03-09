<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dataset;
use App\Models\DatasetData;

class DatasetController extends Controller
{
    public function show(Dataset $dataset)
    {
        $perPage = request()->get('per_page', 10);

        $filters = $dataset->filters;

        $query = DatasetData::where('dataset_id', $dataset->id);

        foreach ($filters as $filter) {
            $value = request($filter->kolom);

            if ($value) {
                if ($filter->kolom == 'tahun') {
                    $query->where('tahun', $value);
                } else {
                    $query->where("data_json->{$filter->kolom}", $value);
                }
            }
        }

        $datasetData = $query->paginate($perPage)->withQueryString();

        $filterOptions = [];

        foreach ($filters as $filter) {
            if ($filter->kolom == 'tahun') {
                $filterOptions['tahun'] = DatasetData::where('dataset_id', $dataset->id)->select('tahun')->distinct()->orderBy('tahun')->pluck('tahun');
            } else {
                $filterOptions[$filter->kolom] = DatasetData::where('dataset_id', $dataset->id)->get()->pluck("data_json.{$filter->kolom}")->filter()->unique()->sort()->values();
            }
        }

        return view('dataset.show', compact('dataset', 'datasetData', 'perPage', 'filters', 'filterOptions'));
    }
}
