<?php

namespace App\Services\Dashboard;

class StatisticService
{
    public function getAll()
    {
        return [
            'top_kecamatan' => $this->topKecamatan(),
            'tren_nikah' => $this->trenNikah(),
            'agama' => $this->agama(),
        ];
    }

    private function topKecamatan()
    {
        return [
            'labels' => ['Semanding', 'Palang', 'Soko', 'Tuban', 'Jenu'],
            'values' => [782, 613, 575, 503, 485],
        ];
    }

    private function trenNikah()
    {
        return [
            'labels' => ['2021', '2022', '2023', '2024', '2025'],
            'values' => [7143, 7883, 7592, 8321, 8039],
        ];
    }

    private function agama()
    {
        return [
            'labels' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'],
            'values' => [10843, 1987, 539, 124, 58, 42],
        ];
    }
}