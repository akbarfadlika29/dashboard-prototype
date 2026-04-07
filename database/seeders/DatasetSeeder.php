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
                    ["name" => "Kecamatan", "type" => "text"],
                    ["name" => "Desa/Kelurahan", "type" => "text"],
                    ["name" => "Jumlah Nikah", "type" => "number"],
                    ["name" => "Kantor", "type" => "number"],
                    ["name" => "Luar Kantor", "type" => "number"],
                    ["name" => "Nikah Campuran (Laki-Laki)", "type" => "number"],
                    ["name" => "Nikah Campuran (Wanita)", "type" => "number"],
                    ["name" => "Jumlah Rujuk", "type" => "number"],
                    ["name" => "Jumlah Isbat", "type" => "number"],
                ],
                'kolom' => [
                    ["name" => "Kecamatan", "type" => "text"],
                    ["name" => "Desa/Kelurahan", "type" => "text"],
                    ["name" => "Jumlah Nikah", "type" => "number"],
                    ["name" => "Kantor", "type" => "number"],
                    ["name" => "Luar Kantor", "type" => "number"],
                    ["name" => "Nikah Campuran (Laki-Laki)", "type" => "number"],
                    ["name" => "Nikah Campuran (Wanita)", "type" => "number"],
                    ["name" => "Jumlah Rujuk", "type" => "number"],
                    ["name" => "Jumlah Isbat", "type" => "number"],
                ],
            ],

            [
                'nama' => 'LAPORAN USIA PENGANTIN KABUPATEN TUBAN BULAN DESEMBER 2025',
                'deskripsi' => 'Data usia dan pendidikan pengantin Kabupaten Tuban Bulan Desember 2025.',
                'schema_json' => [
                    ["name" => "Kecamatan", "type" => "text"],
                    ["name" => "Desa/Kelurahan", "type" => "text"],
                    ["name" => "Jumlah Nikah", "type" => "number"],

                    ["name" => "Usia Pengantin (Laki-Laki) (< 19)", "type" => "number"],
                    ["name" => "Usia Pengantin (Laki-Laki) (19-21)", "type" => "number"],
                    ["name" => "Usia Pengantin (Laki-Laki) (> 21)", "type" => "number"],

                    ["name" => "Usia Pengantin (Wanita) (< 19)", "type" => "number"],
                    ["name" => "Usia Pengantin (Wanita) (19-21)", "type" => "number"],
                    ["name" => "Usia Pengantin (Wanita) (> 21)", "type" => "number"],

                    ["name" => "Pendidikan Pengantin (Laki-Laki) (SD)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (SLTP)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (SLTA)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (D1-D2)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (D3)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (S1)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (S2)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (S3)", "type" => "number"],

                    ["name" => "Pendidikan Pengantin (Wanita) (SD)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (SLTP)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (SLTA)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (D1-D2)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (D3)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (S1)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (S2)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (S3)", "type" => "number"],
                ],
                'kolom' => [
                    ["name" => "Kecamatan", "type" => "text"],
                    ["name" => "Desa/Kelurahan", "type" => "text"],
                    ["name" => "Jumlah Nikah", "type" => "number"],

                    ["name" => "Usia Pengantin (Laki-Laki) (< 19)", "type" => "number"],
                    ["name" => "Usia Pengantin (Laki-Laki) (19-21)", "type" => "number"],
                    ["name" => "Usia Pengantin (Laki-Laki) (> 21)", "type" => "number"],

                    ["name" => "Usia Pengantin (Wanita) (< 19)", "type" => "number"],
                    ["name" => "Usia Pengantin (Wanita) (19-21)", "type" => "number"],
                    ["name" => "Usia Pengantin (Wanita) (> 21)", "type" => "number"],

                    ["name" => "Pendidikan Pengantin (Laki-Laki) (SD)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (SLTP)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (SLTA)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (D1-D2)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (D3)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (S1)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (S2)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Laki-Laki) (S3)", "type" => "number"],

                    ["name" => "Pendidikan Pengantin (Wanita) (SD)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (SLTP)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (SLTA)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (D1-D2)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (D3)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (S1)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (S2)", "type" => "number"],
                    ["name" => "Pendidikan Pengantin (Wanita) (S3)", "type" => "number"],
                ],
            ],

        ];

        foreach ($data as $item) {
            Dataset::updateOrCreate(
                ['nama' => $item['nama']],
                [
                    'kategori_id' => 2,
                    'seksi_id' => 2,
                    'deskripsi' => $item['deskripsi'],
                    'schema_json' => $item['schema_json'],
                    'kolom' => $item['kolom'],
                    'status' => 'approved',
                    'created_by' => 1,
                ]
            );
        }
    }
}
