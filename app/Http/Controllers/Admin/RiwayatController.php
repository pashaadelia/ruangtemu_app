<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();

        $query = Booking::with('ruangan')
            ->where(function ($q) use ($now) {
                // Dibatalkan
                $q->where('status_booking', 1)
                    // Atau sudah lewat jam selesainya (otomatis "Selesai")
                    ->orWhere(function ($q2) use ($now) {
                        $q2->whereNull('status_booking')
                            ->where(function ($q3) use ($now) {
                                $q3->where('tanggal', '<', $now->toDateString())
                                    ->orWhere(function ($q4) use ($now) {
                                        $q4->where('tanggal', $now->toDateString())
                                            ->where('jam_keluar', '<', $now->format('H:i:s'));
                                    });
                            });
                    });
            })
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

        // Filter tanggal spesifik (prioritas utama)
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            // Kalau tanggal spesifik tidak diisi, boleh filter per bulan dan/atau tahun
            if ($request->filled('bulan')) {
                $query->whereMonth('tanggal', $request->bulan);
            }
            if ($request->filled('tahun')) {
                $query->whereYear('tanggal', $request->tahun);
            }
        }

        $riwayats = $query->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        $tahunOptions = Booking::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('admin.riwayat', [
            'riwayats' => $riwayats,
            'ruangans' => $ruangans,
            'search'   => $request->query('search'),
            'ruanganFilter' => $request->query('ruangan'),
            'tanggalFilter' => $request->query('tanggal'),
            'bulanFilter'   => $request->query('bulan'),
            'tahunFilter'   => $request->query('tahun'),
            'tahunOptions'  => $tahunOptions,
        ]);
    }
}