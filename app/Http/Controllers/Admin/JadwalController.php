<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Halaman Jadwal Ruangan (kalender bulanan) - untuk sidebar
     */
    public function index(Request $request)
    {
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        return view('admin.jadwal', compact('ruangans'));
    }

    /**
     * Halaman "Jadwal Hari Ini" (list + search/filter) - untuk "Lihat Semua" dari dashboard
     */
    public function hariIni(Request $request)
    {
        $query = Booking::with('ruangan')
            ->whereDate('tanggal', today())
            ->orderBy('jam_masuk');

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

        $jadwal = $query->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        return view('admin.jadwal-hari-ini', compact('jadwal', 'ruangans'));
    }

    /**
     * Detail Rapat
     */
    public function show($id)
    {
        $booking = Booking::with(['ruangan.fasilitas', 'divisi'])->findOrFail($id);

        return view('admin.detail-rapat', compact('booking'));
    }
}