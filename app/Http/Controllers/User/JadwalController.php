<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Halaman "Jadwal Hari Ini" untuk user (satpam)
     */
    public function index(Request $request)
    {
        $query = Booking::with(['ruangan', 'divisi'])
            ->whereDate('tanggal', now()->toDateString());

        // Search berdasarkan nama ruangan atau nama rapat
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_rapat', 'like', "%{$search}%")
                  ->orWhereHas('ruangan', function ($q2) use ($search) {
                      $q2->where('nama_ruangan', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan ruangan
        if ($request->filled('ruangan')) {
            $query->where('ruangan_id', $request->ruangan);
        }

        $jadwal = $query->orderBy('jam_masuk')->get();

        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        return view('user.dashboard', compact('jadwal', 'ruangans'));
    }

    /**
     * Halaman Detail Rapat
     */
    public function show(Booking $booking)
    {
        $booking->load(['ruangan.fasilitas', 'divisi']);

        return view('user.detail-rapat', compact('booking'));
    }
}