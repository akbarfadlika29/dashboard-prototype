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
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
