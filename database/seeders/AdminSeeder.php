<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (User::where('email', 'admin@sahabatbuku.com')->exists()) {
            return;
        }

        // Buat admin pertama
        User::create([
            'name' => 'Admin SahabatBuku',
            'email' => 'admin@sahabatbuku.com',
            'password' => 'admin123',
            'kelas' => '-',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
