<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jadwalHariIni = Booking::with('ruangan')
            ->whereDate('tanggal', today())
            ->orderBy('jam_masuk')
            ->get();

        $riwayat = Booking::with('ruangan')
            ->whereIn('status_booking', [2, 3]) // ditolak, selesai
            ->orderByDesc('tanggal')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('jadwalHariIni', 'riwayat'));
    }
}
