<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    public function run(): void
    {
        $ruangans = [
            [
                'nama_ruangan' => 'Ruang Meeting A',
                'status_ruangan' => 1,
                'kapasitas' => 20,
                'deskripsi_fasilitas' => 'AC, Proyektor, Whiteboard',
            ],
            [
                'nama_ruangan' => 'R. Manglayang (Kaca)',
                'status_ruangan' => 1,
                'kapasitas' => 50,
                'deskripsi_fasilitas' => 'AC, TV, WiFi',
            ],
            [
                'nama_ruangan' => 'R. Patuha',
                'status_ruangan' => 1,
                'kapasitas' => 30,
                'deskripsi_fasilitas' => 'Proyektor, WiFi, Meja dan Kursi',
            ],
            [
                'nama_ruangan' => 'R. Burangrang',
                'status_ruangan' => 0,
                'kapasitas' => 25,
                'deskripsi_fasilitas' => 'AC, Whiteboard',
            ],
            [
                'nama_ruangan' => 'R. Tangkuban Perahu (Aula)',
                'status_ruangan' => 1,
                'kapasitas' => 50,
                'deskripsi_fasilitas' => 'Proyektor, Video Conference, Whiteboard, WiFi',
            ],
            [
                'nama_ruangan' => 'R. Puntang',
                'status_ruangan' => 1,
                'kapasitas' => 20,
                'deskripsi_fasilitas' => 'AC, TV',
            ],
        ];

        foreach ($ruangans as $ruangan) {
            Ruangan::create($ruangan);
        }
    }
}