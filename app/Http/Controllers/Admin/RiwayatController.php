<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Menampilkan halaman Riwayat.
     *
     * NOTE: $riwayats masih berupa array kosong karena belum terhubung
     * ke database. Nanti tinggal ganti dengan query, misalnya:
     *
     * $riwayats = Riwayat::with('ruangan')
     *     ->when($request->search, fn ($q, $search) =>
     *         $q->where('judul_meeting', 'like', "%{$search}%")
     *           ->orWhereHas('ruangan', fn ($q2) =>
     *               $q2->where('nama', 'like', "%{$search}%")
     *           )
     *     )
     *     ->latest('tanggal')
     *     ->get();
     */
    public function index(Request $request)
    {
        $riwayats = collect();

        return view('admin.riwayat', [
            'riwayats' => $riwayats,
            'search'   => $request->query('search'),
        ]);
    }
}