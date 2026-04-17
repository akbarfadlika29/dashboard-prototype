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
            ->groupBy(fn($item) => $item->data_json['Kecamatan'] ?? 'Unknown')
            ->map(function ($rows) {
                return collect($rows)->sum(fn($r) => (int) ($r->data_json['Jumlah Nikah'] ?? 0));
            })
            ->sortDesc()
            ->take(5);

        return [
            'labels' => $data->keys()->values(),
            'values' => $data->values(),
            'kategori_id' => 2,
            'seksi_id' => 2,
        ];
    }

    private function nikahLokasi()
    {
        $datasetId = 1;

        $data = DatasetData::where('dataset_id', $datasetId)
            ->get();

        $dalam = $data->sum(function ($row) {
            return (int) ($row->data_json['Kantor'] ?? 0);
        });

        $luar = $data->sum(function ($row) {
            return (int) ($row->data_json['Luar Kantor'] ?? 0);
        });

        return [
            'labels' => ['Dalam Kantor', 'Luar Kantor'],
            'values' => [$dalam, $luar],
            'kategori_id' => 2,
            'seksi_id' => 2,
        ];
    }
}