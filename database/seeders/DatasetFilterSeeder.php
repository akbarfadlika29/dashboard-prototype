<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DatasetFilter;

class DatasetFilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'dataset_id' => 1,
                'kolom' => 'kecamatan',
            ],
            [
                'dataset_id' => 1,
                'kolom' => 'desa',
            ]
        ];

        foreach ($data as $item) {
            DatasetFilter::create($item);
        }

        $data2 = [
            [
                'dataset_id' => 2,
                'kolom' => 'kecamatan',
            ],
            [
                'dataset_id' => 2,
                'kolom' => 'desa',
            ]
        ];

        foreach ($data2 as $item) {
            DatasetFilter::create($item);
        }
    }
}
