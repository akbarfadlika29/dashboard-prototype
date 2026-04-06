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
                'nama' => 'Mohamad Akbar Fadlika Wibowo',
                'password' => Hash::make('tumisBuncis_udangKrispi_30'),
                'role' => 'superadmin',
            ],
            [
                'nip' => '197808122005011002',
                'nama' => 'Imam Syafii',
                'password' => Hash::make('ImamS456'),
                'role' => 'kepala_seksi',
            ],
            [
                'nip' => '198505042024211005',
                'nama' => 'Sholachudin Badri',
                'password' => Hash::make('BadriS456'),
                'role' => 'admin_umum',
            ],
            [
                'nip' => '197706252014111001',
                'nama' => 'Jarianto',
                'password' => Hash::make('Jarianto456'),
                'role' => 'admin_seksi',
            ],
            [
                'nip' => '197103052009011004',
                'nama' => 'Zainul Aminin',
                'password' => Hash::make('AmininZ345'),
                'role' => 'admin_seksi',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
