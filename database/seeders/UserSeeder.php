<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nip' => '200001292025051006',
                'nama' => 'MOHAMAD AKBAR FADLIKA WIBOWO S.Tr.Kom.',
                'password' => Hash::make('tumisBuncis_udangKrispi_30'),
                'role' => 'superadmin',
            ],
            [
                'nip' => '197808122005011002',
                'nama' => 'IMAM SYAFII S.Ag., MA.',
                'password' => Hash::make('ImamS456'),
                'role' => 'kepala_seksi',
            ],
            [
                'nip' => '198505042024211005',
                'nama' => 'SHOLACHUDIN BADRI S.Pd.I',
                'password' => Hash::make('BadriS456'),
                'role' => 'admin_umum',
            ],
            [
                'nip' => '197706252014111001',
                'nama' => 'JARIANTO S.H.',
                'password' => Hash::make('Jarianto456'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '197103052009011004',
                'nama' => 'ZAINUL AMININ SH.',
                'password' => Hash::make('AmininZ345'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '196902101998031001',
                'nama' => 'MASHARI M.Ag',
                'password' => Hash::make('Masharie778'),
                'role' => 'kepala_seksi',
            ],
            [
                'nip' => '197508012003121005',
                'nama' => 'IMAM BUKORI SH,MM',
                'password' => Hash::make('Bukhori23'),
                'role' => 'kepala_seksi',
            ],
            [
                'nip' => '197511232005011004',
                'nama' => 'LUKMAN HAKIM S.Ag',
                'password' => Hash::make('HakimL27'),
                'role' => 'kepala_seksi',
            ],
            [
                'nip' => '198201162014111002',
                'nama' => 'IMAM SHOFIYUDDIN',
                'password' => Hash::make('Shofiyu82'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '197104212007101002',
                'nama' => 'BANI MUHARROR S.Pd.I',
                'password' => Hash::make('BaniM71'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '198502062025211009',
                'nama' => 'FEBY PANDU SATRIAWAN S.Kom',
                'password' => Hash::make('Febyps85'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '198508042005011002',
                'nama' => 'MAHENDRA HENDY SAPUTRA SH',
                'password' => Hash::make('Mahesa85'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '197607042025211008',
                'nama' => 'SUGIANTO',
                'password' => Hash::make('Sugianto1504'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '198301062025211012',
                'nama' => 'ZAKKY ZAKARIA YAHYA',
                'password' => Hash::make('Zakky1504'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '197903222007101005',
                'nama' => 'MOCHAMMAD ALI BAHARUDIN S.Pd.I',
                'password' => Hash::make('AliBahar1504'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '199501282020121011',
                'nama' => 'MOHAMMAD ALVIN FAHMI S.E.',
                'password' => Hash::make('AlvinF1504'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '199205312023211020',
                'nama' => 'ALIF AKBAR MUTTAQIN S.Kom.',
                'password' => Hash::make('AlifAkbarM1504'),
                'role' => 'superadmin',
            ],
            [
                'nip' => '199404032025211047',
                'nama' => 'MOH. YASIN YUSUF S.Pd',
                'password' => Hash::make('MYasin1504'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '198008042005011003',
                'nama' => 'MOH ANSHORI S.Pd',
                'password' => Hash::make('MohAnshori1504'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '199103132020121011',
                'nama' => 'WAHYU TRI MULYO S.ST',
                'password' => Hash::make('WahyuTM1504'),
                'role' => 'admin_seksi',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
