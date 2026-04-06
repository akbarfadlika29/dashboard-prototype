<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Tata Usaha',
            'Bimbingan Masyarakat Islam',
            'Pendidikan Agama Islam',
            'Pendidikan Diniyah & Pondok Pesantren',
            'Pendidikan Madrasah',
            'Zakat & Wakaf',
        ];

        foreach ($data as $nama) {
            Kategori::updateOrCreate(
                ['nama' => $nama],
                [
                    'slug' => Str::slug($nama),
                    'deskripsi' => 'Data statistik terkait ' . $nama,
                ]
            );
        }
    }
}
