<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // Jadwal hari ini
        $jadwalHariIni = Booking::with('ruangan')
            ->whereDate('tanggal', today())
            ->orderBy('jam_masuk')
            ->get();

        // Riwayat
        $riwayat = Booking::with('ruangan')
            ->where(function ($q) use ($now) {

                // Dibatalakan
                $q->where('status_booking', 1)

                    // Atau booking sudah selesai berdasarkan waktu
                    ->orWhere(function ($q2) use ($now) {
                        $q2->whereNull('status_booking')
                            ->where(function ($q3) use ($now) {

                                // Tanggal sudah lewat
                                $q3->where('tanggal', '<', $now->toDateString())

                                    // Atau hari ini tetapi jam sudah lewat
                                    ->orWhere(function ($q4) use ($now) {
                                        $q4->where(
                                            'tanggal',
                                            $now->toDateString()
                                        )
                                        ->where(
                                            'jam_keluar',
                                            '<',
                                            $now->format('H:i:s')
                                        );
                                    });
                            });
                    });
            })
            ->orderByDesc('tanggal')
            ->orderByDesc('jam_masuk')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'jadwalHariIni',
            'riwayat'
        ));
    }
}