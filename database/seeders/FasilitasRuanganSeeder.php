<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruangan;
use App\Models\Fasilitas;

class FasilitasRuanganSeeder extends Seeder
{
    public function run(): void
    {
        $ruangans = Ruangan::all();
        $fasilitas = Fasilitas::all()->keyBy('nama_fasilitas');

        // Contoh mapping ruangan -> fasilitas
        $mapping = [
            'Ruang Meeting A' => ['Proyektor', 'AC', 'Whiteboard'],
            'R. Manglayang (Kaca)' => ['AC', 'TV', 'WiFi'],
            'R. Patuha' => ['Proyektor', 'WiFi', 'Meja dan Kursi'],
            'R. Burangrang' => ['AC', 'Whiteboard'],
            'R. Tangkuban Perahu (Aula)' => ['Proyektor', 'Whiteboard', 'WiFi'],
            'R. Puntang' => ['AC', 'TV'],
        ];

        foreach ($ruangans as $ruangan) {
            if (isset($mapping[$ruangan->nama_ruangan])) {
                foreach ($mapping[$ruangan->nama_ruangan] as $namaFasilitas) {
                    if (isset($fasilitas[$namaFasilitas])) {
                        $ruangan->fasilitas()->attach($fasilitas[$namaFasilitas]->id);
                    }
                }
            }
        }
    }
}