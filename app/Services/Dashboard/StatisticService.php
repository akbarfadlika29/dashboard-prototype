<?php

namespace App\Services\Dashboard;

use App\Models\DatasetData;

class StatisticService
{
    public function getAll()
    {
        return [
            'top_kecamatan' => $this->topKecamatan(),
            'nikah_lokasi' => $this->nikahLokasi(),
        ];
    }

    private function topKecamatan()
    {
        $datasetId = 1; // dataset perkawinan 2025

        $data = DatasetData::where('dataset_id', $datasetId)
            ->get()
            ->groupBy(fn($item) => $item->data_json['kecamatan'] ?? 'Unknown')
            ->map(function ($rows) {
                return collect($rows)->sum(fn($r) => (int) ($r->data_json['jumlah_nikah'] ?? 0));
            })
            ->sortDesc()
            ->take(5);

        return [
            'labels' => $data->keys()->values(),
            'values' => $data->values(),
        ];
    }

    private function nikahLokasi()
    {
        $datasetId = 1;

        $data = DatasetData::where('dataset_id', $datasetId)
            ->get();

        $dalam = $data->sum(function ($row) {
            return (int) ($row->data_json['kantor'] ?? 0);
        });

        $luar = $data->sum(function ($row) {
            return (int) ($row->data_json['luar_kantor'] ?? 0);
        });

        return [
            'labels' => ['Dalam Kantor', 'Luar Kantor'],
            'values' => [$dalam, $luar],
        ];
    }
}