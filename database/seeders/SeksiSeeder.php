<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seksi;

class SeksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Sub Bagian Tata Usaha',
            'Seksi Bimbingan Masyarakat Islam',
            'Seksi Pendidikan Agama Islam',
            'Seksi Pendidikan Diniyah dan Pondok Pesantren',
            'Seksi Pendidikan Madrasah',
            'Penyelenggara Zakat dan Wakaf'
        ];

        foreach ($data as $nama) {
            Seksi::updateOrCreate(
                ['nama' => $nama]
            );
        }
    }
}
