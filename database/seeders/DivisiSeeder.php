<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Divisi;

class DivisiSeeder extends Seeder
{
    public function run(): void
    {
        $divisis = [
            'Pengendalian Proyek',
            'Pengendalian Bidang',
            'Proyek Site',
            'Pertahanan dan Umum',
            'K3L',
        ];

        foreach ($divisis as $nama) {
            Divisi::create(['nama_divisi' => $nama]);
        }
    }
}