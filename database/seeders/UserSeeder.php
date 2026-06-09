<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed akun admin default untuk Toko RAM Ururu
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $exists = DB::table('users')->where('email', 'admin@ramururu.com')->exists();

        if (!$exists) {
            DB::table('users')->insert([
                'nama_admin' => 'Admin',
                'email' => 'admin@ramururu.com',
                'password' => Hash::make('password'),
            ]);

            $this->command->info('Admin user created: admin@ramururu.com / password');
        } else {
            $this->command->info('Admin user already exists, skipping...');
        }
    }
}
