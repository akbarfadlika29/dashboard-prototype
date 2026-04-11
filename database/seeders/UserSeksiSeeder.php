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
            ],
            [
                'user_id' => 2,
                'seksi_id' => 1,
            ],
            [
                'user_id' => 2,
                'seksi_id' => 3,
            ],
            [
                'user_id' => 3,
                'seksi_id' => 1,
            ],
            [
                'user_id' => 4,
                'seksi_id' => 2,
            ],
            [
                'user_id' => 5,
                'seksi_id' => 4,
            ],
            [
                'user_id' => 6,
                'seksi_id' => 2,
            ],
            [
                'user_id' => 7,
                'seksi_id' => 4,
            ],
            [
                'user_id' => 8,
                'seksi_id' => 5,
            ],
            [
                'user_id' => 8,
                'seksi_id' => 6,
            ],
            [
                'user_id' => 9,
                'seksi_id' => 1,
            ],
            [
                'user_id' => 10,
                'seksi_id' => 2,
            ],
            [
                'user_id' => 11,
                'seksi_id' => 5,
            ],
            [
                'user_id' => 12,
                'seksi_id' => 6,
            ],
        ]);
    }
}
