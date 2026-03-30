<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserSeksi;

class UserSeksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserSeksi::insert([
            [
                'user_id' => 1,
                'seksi_id' => 1,
            ]
        ]);
    }
}
