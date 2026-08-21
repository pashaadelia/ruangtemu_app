<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Menampilkan halaman Riwayat.
     *
     * Riwayat menampilkan booking dengan status:
     * 2 = ditolak
     * 3 = selesai
     */
    public function index(Request $request)
    {
        $query = Booking::with('ruangan')
            ->whereIn('status_booking', [2, 3])
            ->orderByDesc('tanggal')
            ->orderByDesc('jam_masuk');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_rapat', 'like', "%{$search}%")
                  ->orWhereHas('ruangan', function ($q2) use ($search) {
                      $q2->where('nama_ruangan', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('ruangan')) {
            $query->where('id_ruangan', $request->ruangan);
        }

        $riwayats = $query->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        return view('admin.riwayat', [
            'riwayats' => $riwayats,
            'ruangans' => $ruangans,
            'search'   => $request->query('search'),
            'ruanganFilter' => $request->query('ruangan'),
        ]);
    }
}