<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalikelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'walikelas@sekolah.com'],
            [
                'name' => 'Walikelas',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'walikelas',
            ]
        );
    }
}
