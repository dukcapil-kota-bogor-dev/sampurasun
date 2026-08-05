<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'KK', 'KTP', 'KIA', 'Akta Kelahiran', 'Akta Kematian', 'Akta Perkawinan', 'Akta Perceraian',
            'SKTT', 'IKD', 'Surat Pindah', 'Kedatangan', 'Layanan Online', 'Pengaduan', 'BAPR',
            'Update Data', 'Ganti Foto', 'Kutipan Kedua', 'Ludo', 'Lainnya'
        ];

        foreach ($names as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
