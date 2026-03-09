<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dataset;

class DatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            [
                'nama' => 'LAPORAN PERISTIWA PERKAWINAN ATAU RUJUK KABUPATEN TUBAN TAHUN 2025',
                'deskripsi' => 'Data laporan peristiwa nikah, rujuk, dan isbat Kabupaten Tuban Tahun 2025.',
                'schema_json' => [
                    'kecamatan',
                    'desa',
                    'jumlah_nikah',
                    'kantor',
                    'luar_kantor',
                    'nikah_campuran_laki_laki',
                    'nikah_campuran_wanita',
                    'jumlah_rujuk',
                    'jumlah_isbat',
                ],
            ],

            [
                'nama' => 'LAPORAN USIA PENGANTIN KABUPATEN TUBAN BULAN DESEMBER 2025',
                'deskripsi' => 'Data usia dan pendidikan pengantin Kabupaten Tuban Bulan Desember 2025.',
                'schema_json' => [
                    'kecamatan',
                    'desa',
                    'jumlah_nikah',

                    'usia_pengantin_laki_laki_<19',
                    'usia_pengantin_laki_laki_19_21',
                    'usia_pengantin_laki_laki_>21',

                    'usia_pengantin_wanita_<19',
                    'usia_pengantin_wanita_19_21',
                    'usia_pengantin_wanita_>21',

                    'pendidikan_pengantin_laki_sd',
                    'pendidikan_pengantin_laki_sltp',
                    'pendidikan_pengantin_laki_slta',
                    'pendidikan_pengantin_laki_d1_d2',
                    'pendidikan_pengantin_laki_d3',
                    'pendidikan_pengantin_laki_s1',
                    'pendidikan_pengantin_laki_s2',
                    'pendidikan_pengantin_laki_s3',

                    'pendidikan_pengantin_wanita_sd',
                    'pendidikan_pengantin_wanita_sltp',
                    'pendidikan_pengantin_wanita_slta',
                    'pendidikan_pengantin_wanita_d1_d2',
                    'pendidikan_pengantin_wanita_d3',
                    'pendidikan_pengantin_wanita_s1',
                    'pendidikan_pengantin_wanita_s2',
                    'pendidikan_pengantin_wanita_s3',
                ],
            ],

        ];

        foreach ($data as $item) {
            Dataset::updateOrCreate(
                ['nama' => $item['nama']],
                [
                    'kategori_id' => 5, // Hardcode Pernikahan
                    'deskripsi' => $item['deskripsi'],
                    'schema_json' => $item['schema_json'],
                ]
            );
        }
    }
}
