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
            'Pendidikan/Madrasah',
            'Zakat',
            'Wakaf',
            'Masjid/Musholla',
            'Pernikahan',
            'Penyuluhan Agama',
            'Pondok Pesantren',
            'Umum',
            'Kepegawaian',
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
