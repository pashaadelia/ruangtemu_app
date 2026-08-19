<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
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

        return view('user.dashboard', compact('jadwal', 'ruangans'));
    }
}