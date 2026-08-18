<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasilitas;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $fasilitas = [
            'Proyektor',
            'AC',
            'Whiteboard',
            'TV',
            'WiFi',
            'Meja dan Kursi',
        ];

        foreach ($fasilitas as $nama) {
            Fasilitas::create(['nama_fasilitas' => $nama]);
        }
    }
}