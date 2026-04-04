<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriMapel;

class KategoriMapelSeeder extends Seeder
{
    public function run(): void
    {
        KategoriMapel::create(['nama_kategori' => 'IPA']);
        KategoriMapel::create(['nama_kategori' => 'IPS']);
    }
}